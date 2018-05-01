<?php
if (!class_exists('WP_List_Table')) {
  require_once(ABSPATH.'wp-admin/includes/class-wp-list-table.php');
}
class WPGTable extends WP_List_Table {
    
    var $categories;

    function get_columns(){
      return array(
        'cb' => '<input type="checkbox" />',
        'name' => 'Наименование ленты',
        'type' => 'Тип',
        'url' => 'URL',
        'published' => 'Статус',
        'catid' => 'Рубрики',
        'id' => 'ID',
        'last_update' => 'Обновление',
        'count_posts' => 'Кол-во записей',
      );
    }

    function get_sortable_columns() {
      $sortable_columns = array(
        'id' => array('id', false),
        'name' => array('name', false),
        'published'  => array('published', false),
        'type' => array('type', false),
        'url' => array('url', false),
        'catid' => array('catid', false),
        'last_update' => array('last_update', false),
        'count_posts' => array('count_posts', false),
      );
      return $sortable_columns;
    }
    
    function column_default( $item, $column_name ) {
      switch($column_name) {
        case 'catid':
          $categories = array();
          foreach ($item['catid'] as $k) {
            if (isset($this->categories[(int)$k])) {
              $categories[] = $this->categories[(int)$k];
            }
          }
          return implode(', ', $categories);
        case 'last_update':
          return  $item['last_update'] ? date('d.m.Y H:i:s', $item['last_update']) : '';
        case 'name':
          return '<a target="_blank" href="?page=wpgrabber-edit&id='.$item['id'].'">'.$item['name'].'</a>';
        case 'url':
          return '<a target="_blank" href="'.$item['url'].'">'.str_replace('http://', '', $item['url']).'</a>';
        case 'published':
          return '<a href="?page=wpgrabber-index&rows[]='.$item['id'].'&action=' . ($item['published'] ? 'Off' : 'On') . '">'. ($item['published'] ? '<span style="color:green;">Вкл.</span>' : '<span style="color:red;">Выкл.</span>') .'</a>';
        default:
          return $item[$column_name];
      }
    }
    
    function prepare_items() {
      global $wpdb;

      $sql = 'SELECT term_id, name FROM `'.$wpdb->prefix.'terms`';
      $buff = $wpdb->get_results($sql, ARRAY_A);
      if ($wpdb->last_error != '') {
        WPGErrorHandler::add($wpdb->last_error, __FILE__, __LINE__);
      } elseif (count($buff)) {
        foreach ($buff as $el) {
          $this->categories[$el['term_id']] = $el['name'];
        }
      }

      $per_page = $this->get_items_per_page('wpgrabber_feeds_per_page', 10);
      $current_page = $this->get_pagenum();
      $this->_column_headers = $this->get_column_info();

      $sql_where = array();
      $sql_order = array();

      if (isset($_POST['s'])) {
        $search = trim($_POST['s']);
        if ($search != '') {
          $sql_where[] = 'w.`name` LIKE \'%'.esc_sql($search).'%\'';
        }
      }

      $filter_catid = (isset($_SESSION['wpgrabberCategoryFilter']) and intval($_SESSION['wpgrabberCategoryFilter'])) ?
        (int)$_SESSION['wpgrabberCategoryFilter'] : null;

      $order_by = null;
      $order_way = null;

      if (isset($_GET['orderby'])) {
        $ob = trim($_GET['orderby']);
        $sortable = $this->get_sortable_columns();
        if ($ob != '' and isset($sortable[$ob])) {
          $order_by = $ob;
          $order_way = (isset($_GET['order']) and $_GET['order'] == 'desc') ? 'DESC' : 'ASC';
          if ($order_by != 'catid') {
            $table = $order_by == 'count_posts' ? '' : 'w.';
            $sql_order[] = $table.$order_by.' '.$order_way;
          }
        }
      }
      $sql_order[] = 'w.id DESC';

      $is_load_full_list = ($filter_catid !== null or $order_by == 'catid');

      $sql = 'SELECT SQL_CALC_FOUND_ROWS
          w.*, COUNT(wc.id) AS count_posts
        FROM `'.$wpdb->prefix.'wpgrabber` AS w
        LEFT JOIN `'.$wpdb->prefix.'wpgrabber_content` AS wc ON wc.feed_id = w.id
        '.(!empty($sql_where) ? 'WHERE '.implode(' AND ', $sql_where) : '').'
        GROUP BY w.id
        '.(!empty($sql_order) ? 'ORDER BY '.implode(', ', $sql_order) : '').'
        '.(!$is_load_full_list ? ('LIMIT '.(($current_page - 1) * $per_page).', '.$per_page) : '');

      $items = $wpdb->get_results($sql, ARRAY_A);
      if ($wpdb->last_error != '') {
        WPGErrorHandler::add($wpdb->last_error, __FILE__, __LINE__);
      } else {
        $items = is_array($items) ? $items : array();
        if (!empty($items)) {
          $sort_catid = array();
          foreach ($items as $k => $v) {
            $items[$k]['catid'] = array();
            $params = @unserialize(base64_decode($v['params']));
            if (!empty($params['catid'])) {
              $items[$k]['catid'] = $params['catid'];
              if ($order_by == 'catid' and $order_way == 'DESC') {
                rsort($items[$k]['catid']);
              } else {
                sort($items[$k]['catid']);
              }
            }
            if ($filter_catid !== null and !in_array($filter_catid, $items[$k]['catid'])) {
              unset($items[$k]);
              continue;
            }
            if ($order_by == 'catid') {
              if (!empty($items[$k]['catid'])) {
                $sort_catid[] = ($order_way == 'DESC') ? max($items[$k]['catid']) : min($items[$k]['catid']);
              } else {
                $sort_catid[] = 0;
              }
            }
          }
          if ($order_by == 'catid') {
            array_multisort($sort_catid, ($order_way == 'DESC' ? SORT_DESC : SORT_ASC), $items);
          }
        }
        if ($is_load_full_list) {
          $total_items = count($items);
          $items = array_splice($items, (($current_page - 1) * $per_page), $per_page);
        } else {
          $total_items = $wpdb->get_var('SELECT FOUND_ROWS()');
        }
        $this->items = $items;
        $this->set_pagination_args(
          array(
            'total_items' => $total_items,
            'per_page' => $per_page,
          )
        );
      }
    }
    
    function column_name($item) {
      $actions = array(
        'edit'  => sprintf('<a href="?page=wpgrabber-edit&id=' . $item['id'] . '">Изменить</a>',$_REQUEST['page'],'edit',$item['id']),
        'test'  => sprintf(
          '<a href="?page=wpgrabber-index&action=test&id='.$item['id'].'" onclick="wpgrabberRun('.$item['id'].', true); return false;">Тест&nbsp;импорта</a>',
          $_REQUEST['page'], 'edit', $item['id']
        ),
        'import'  => sprintf(
          '<a href="?page=wpgrabber-index&action=exec&id='.$item['id'].'" onclick="wpgrabberRun('.$item['id'].', false); return false;">Импорт</a>',
          $_REQUEST['page'],
          'edit',
          $item['id']
        ),
      );
      return sprintf('%1$s %2$s', $item['name'], $this->row_actions($actions));
    }
    
    function get_bulk_actions() {
          return array(
            'copy'    => 'Копировать',
            'export'    => 'Экспорт',
            'on'    => 'Включить ленты',
            'off'    => 'Выключить ленты',
            'del'    => 'Удалить ленты',
            'clear'    => 'Удалить записи',
          );
    }
    
    function column_cb($item) {
        return sprintf(
            '<input type="checkbox" name="rows[]" value="%s" />', $item['id']
        );
    }
    
    function no_items() {
      _e('<br />У Вас пока еще нет настроенных лент! <a href="?page=wpgrabber-edit">Создать ленту?</a><br /><br />' );
    }
    
    function extra_tablenav( $which ) {
?>
        <div class="alignleft actions">
<?php
        if ($which == 'top') {
            $dropdown_options = array(
                'show_option_all' => 'Выбрать рубрику',
                'hide_empty' => 0,
                'hierarchical' => 1,
                'show_count' => 0,
                'orderby' => 'name',
                'selected' => isset($_SESSION['wpgrabberCategoryFilter']) ? $_SESSION['wpgrabberCategoryFilter'] : null,
            );
            wp_dropdown_categories( $dropdown_options );
            submit_button('Фильтр','button',false,false,array('onclick'=>"this.form.action='?page=wpgrabber-index';"));
        }
?>
        </div>
<?php
    }
}