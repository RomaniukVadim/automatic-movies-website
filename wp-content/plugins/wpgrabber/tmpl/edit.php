<style>
.button-panel {padding-top: 30px; padding-left: 10px; border-top: 1px solid #cacaca; margin-top: 30px;}
.button-panel p.submit {float: left; margin-right: 10px; padding:0px;margin:0px; margin-right: 10px;}
.button-panel input.button {margin-right: 10px; float: left; display: block;}
div.tab-content {
    display: none;
    padding: 5px;
    padding-top: 20px;
}
.tab-content-table tr td, .tab-content-table tr th {
    padding-top: 3px;    
    padding-bottom: 3px;    
}
div.tab-content fieldset {
    padding: 10px;
    border: 1px solid #cacaca;
    margin-top: 15px;
}
div.tab-content fieldset legend {
    font-weight: bold;
}    
</style>
<div class="wrap">
<form method="post" id="editForm" action="?page=wpgrabber-index&action=Save">
<div id="icon-edit" class="icon32"></div><h2>WPGrabber - <?php echo $isNew ? 'Новая лента *' : 'Редактирование ленты'; ?> - 
    <a href="http://top-bit.ru/product/services/ustanovka-avtonapolneniya" target="_blank" title="Заказать платную настройку лент"><b>Заказать настройку ленты</b></a></h2>
<input type="hidden" name="tab" id="tab-active" value="<?php echo $tab; ?>" />
<h2 class="nav-tab-wrapper">
    <a href="#tab1" id="tab1" class="nav-tab<?php echo $tab == 1 ? ' nav-tab-active' : ''; ?>">Основные</a>
    <a href="#tab2" id="tab2" class="nav-tab<?php echo $tab == 2 ? ' nav-tab-active' : ''; ?>">Контент</a>
    <a href="#tab3" id="tab3" class="nav-tab<?php echo $tab == 3 ? ' nav-tab-active' : ''; ?>">Картинки</a>
    <a href="#tab4" id="tab4" class="nav-tab<?php echo $tab == 4 ? ' nav-tab-active' : ''; ?>">Перевод</a>
    <!--<a href="#tab5" id="tab5" class="nav-tab">Таксономия</a>  -->
    <a href="#tab6" id="tab6" class="nav-tab<?php echo $tab == 6 ? ' nav-tab-active' : ''; ?>">Обработка</a>
    <a href="#tab7" id="tab7" class="nav-tab<?php echo $tab == 7 ? ' nav-tab-active' : ''; ?>">Вид</a>
    <a href="#tab8" id="tab8" class="nav-tab<?php echo $tab == 8 ? ' nav-tab-active' : ''; ?>">Дополнительно</a>
</h2> 
<script>
    jQuery(document).ready(function($) {
        $('.nav-tab-wrapper a').click(function(){
            $('.nav-tab-wrapper a').attr('class', 'nav-tab');
            $('.tab-content').hide();
            $('#div_' + $(this).attr('id')).show();
            $(this).attr('class', 'nav-tab nav-tab-active');
            $('#tab-active').val($(this).attr('id').replace('tab', ''));
        });
    });
    function __get(id) {
        return document.getElementById(id);    
    }
    function __hideEl(id)
    {
        document.getElementById(id).style.display='none';        
    }
    function __showEl(id)
    {
        document.getElementById(id).style.display='';
    }
    function __setFeedType(type) {
        if (type == 'html') {
            __get('tr-rss_encoding').style.display='none';        
            __get('tr-html_encoding').style.display='';
            __get('span-url-rss').style.display='none';
            __get('tr-title-words').style.display='none';
            __get('span-url-html').style.display='inline';
            __get('span-url-vk').style.display='none';
            __get('span-title-vk').style.display='none';
            __get('tr-link-tmpl').style.display='';
            __get('tr-autoIntroOn').style.display='';
            __get('tr-title').style.display='';        
        } 
        if (type == 'rss') {
            <?php if ($isNew) { ?>
            __hideEl('tr-html_encoding');
            __hideEl('tr-text_start');
            __hideEl('tr-text_end');
            <?php } ?>
            __get('tr-html_encoding').style.display='';
            __get('tr-rss_encoding').style.display=''; 
            __get('tr-rss_textmod').style.display='';
            __get('span-url-html').style.display='none';       
            __get('tr-title-words').style.display='none';       
            __get('span-url-rss').style.display='inline';
            __get('span-url-vk').style.display='none';
            __get('tr-link-tmpl').style.display='none';
            __get('span-title-vk').style.display='none';
            __get('tr-autoIntroOn').style.display='none';
            __get('tr-title').style.display='none';
        }
        if (type == 'vk') {
            __get('tr-text_start').style.display='none';
            __get('tr-text_end').style.display='none'; 
            __get('tr-link-tmpl').style.display='none';
            __get('tr-autoIntroOn').style.display='none';
            __get('tr-html_encoding').style.display='none';
            __get('tr-rss_encoding').style.display='none';  
            __get('tr-title').style.display='';  
            __get('span-url-rss').style.display='none';
            __get('tr-title-words').style.display='';
            __get('span-title-vk').style.display='';
            __get('span-url-html').style.display='none';
            __get('span-url-vk').style.display='inline';
        }
    }
</script>
<!--Основные-->
<div class="tab-content" id="div_tab1"<?php echo $tab == 1 ? ' style="display: block;"' : ''; ?>>
    <table class="tab-content-table">
        <tr>
        <td width="210">Наименование ленты</td><td><input type="text" name="row[name]" size="100" value="<?php echo $row['name']; ?>" /></td>
        </tr>
        <tr>
        <td><b>Тип ленты</b></td><td><?php echo WPGHelper::selectList('row[type]', array('html', 'rss', 'vk'), $row['type'], false, 'onchange=__setFeedType(this.value);') ;?> </td>
        </tr>
        <tr>
        <td>
            <span id="span-url-rss" <?php if ($row['type'] == 'html' or $row['type'] == 'vk') { ?>style="display:none;"<?php } ?>>URL RSS-ленты</span>
            <span id="span-url-html" <?php if ($row['type'] == 'rss' or $row['type'] == 'vk') { ?>style="display:none;"<?php } ?>>URL индексной страницы</span>
            <span id="span-url-vk" <?php if ($row['type'] == 'html' or $row['type'] == 'rss') { ?>style="display:none;"<?php } ?>>URL VK-стены</span>
            </td><td><input type="text" name="row[url]" value="<?php echo $row['url']; ?>" size="100" /></td>
        </tr>
        <tr id="tr-rss_encoding" <?php if ($row['type'] == 'html' or $row['type'] == 'vk') { ?>style="display:none;"<?php } ?>>
        <td>Кодировка RSS-ленты</td><td><?php echo WPGHelper::selectList('row[rss_encoding]', WPGHelper::charsetList(), $row['rss_encoding']) ;?></td>
        </tr>
        <tr id="tr-rss_textmod" <?php if ($row['type'] != 'rss') echo 'style="display:none;"'; ?>>
        <td>Брать текст</td><td><?php echo WPGHelper::selectList('params[rss_textmod]', array('0'=>'cо страницы', '1'=>'из описания RSS-потока'), $row['params']['rss_textmod'], 1, 'onchange="if (this.value==1){__hideEl(\'tr-html_encoding\');__hideEl(\'tr-text_start\');__hideEl(\'tr-text_end\');} else {__showEl(\'tr-html_encoding\');__showEl(\'tr-text_start\');__showEl(\'tr-text_end\');}"');?></td>
        </tr>
        <tr id="tr-html_encoding" <?php if ($row['type'] == 'vk' || ($row['type'] == 'rss' && $row['params']['rss_textmod'])) echo 'style="display:none;"'; ?>>
        <td>Кодировка HTML-страницы</td><td><?php echo WPGHelper::selectList('row[html_encoding]', WPGHelper::charsetList(), $row['html_encoding']) ;?></td>
        </tr>
        <tr id="tr-autoIntroOn" <?php if ($row['type'] == 'rss'  or $row['type'] == 'vk') { ?>style="display:none;"<?php } ?>>
        <td>Определять анонс</td><td><?php echo WPGHelper::selectList('params[autoIntroOn]', array('автоматически','вручную','без анонса'), $row['params']['autoIntroOn'], 1, 'onchange="if (this.value==1){document.getElementById(\'tr-link-tmpl\').style.display=\'none\';document.getElementById(\'tr-link-tmpl-ext\').style.display=\'\';}else{document.getElementById(\'tr-link-tmpl\').style.display=\'\';document.getElementById(\'tr-link-tmpl-ext\').style.display=\'none\';} "'); ?></td>
        </tr>
        <tr id="tr-link-tmpl" <?php if ($row['params']['autoIntroOn'] or $row['type'] == 'rss'  or $row['type'] == 'vk') echo 'style="display:none;"'; ?>>
        <td>Шаблон ссылок</td><td><input type="text" name="row[links]" value="<?php echo htmlentities($row['links'], ENT_COMPAT, 'UTF-8'); ?>" size="100" /></td>
        </tr>
        <tr id="tr-link-tmpl-ext" <?php if ($row['params']['autoIntroOn']!=1 or $row['type'] == 'rss') echo 'style="display:none;"'; ?>>
        <td valign="top">Расширенный шаблон поиска<br />ссылок вместе с анонсами</td><td><textarea name="params[introLinkTempl]" style="width: 421px; height: 50px;"><?php echo $row['params']['introLinkTempl']; ?></textarea>
        <br>порядок следования: <?php echo WPGHelper::selectList('params[orderLinkIntro]', array('0'=>'ссылка, анонс', '1'=>'анонс, ссылка'), $row['params']['orderLinkIntro'], true); ?>
        <br /><small>данный шаблон должен быть обязательно обрамлен в символы | | . <br />Ссылку и текст анонса - заключите в круглые скобки в таком виде: (.*?)</small>
        </td>
        </tr>
        <tr id="tr-title" <?php if ($row['type'] == 'rss') echo 'style="display:none;"'; ?>>
        <td>Шаблон заголовка<span id="span-title-vk" <?php if ($row['type'] != 'vk') { ?>style="display:none;"<?php } ?>></span></td><td><input type="text" name="row[title]" value="<?php echo htmlentities($row['title'], ENT_COMPAT, 'UTF-8'); ?>" size="100" /></td>
        </tr>
        <tr id="tr-title-words" <?php if ($row['type'] != 'vk') echo 'style="display:none;"'; ?>>
        <td>Кол-во слов в заголовке</td><td><input type="text" name="params[title_words_count]" value="<?php echo htmlentities($row['params']['title_words_count'], ENT_COMPAT, 'UTF-8'); ?>" size="5" style="text-align: center;" /> <i>( если не указан Шаблон заголовока или заголовок не определен! )</i></td>
        </tr>
        <tr id="tr-text_start" <?php if ($row['type'] == 'vk' || ($row['type'] == 'rss' && $row['params']['rss_textmod'])) echo 'style="display:none;"'; ?>>
        <td>Начальная точка полного текста</td><td><input type="text" name="row[text_start]" value="<?php echo htmlentities($row['text_start'], ENT_COMPAT, 'UTF-8'); ?>" size="100" /></td>
        </tr>
        <tr id="tr-text_end" <?php if ($row['type'] == 'vk' || ($row['type'] == 'rss' && $row['params']['rss_textmod'])) echo 'style="display:none;"'; ?>>
        <td>Конечная точка полного текста</td><td><input type="text" name="row[text_end]" value="<?php echo htmlentities($row['text_end'], ENT_COMPAT, 'UTF-8'); ?>" size="100" /></td>
        </tr>
        <tr>
        <td>Просмотр ссылок сверху вниз</td><td><?php echo WPGHelper::yesNoRadioList('params[start_top]', $row['params']['start_top']); ?></td>
        </tr>
        <tr>
        <td>Начать с ссылки</td><td><input style="text-align: center;" type="text" name="params[start_link]" value="<?php echo (int) $row['params']['start_link']; ?>" size="5" /> <small>0 - с первой ссылки</small></td>
        </tr>
        <tr>
          <td>Пропускать ранее не загруженные (ошибочные) ссылки</td>
          <td><?php echo WPGHelper::yesNoRadioList('params[skip_error_urls]', $row['params']['skip_error_urls']); ?></td>
        </tr>
        <tr>
        <td>Включить ленту</td><td><?php echo WPGHelper::yesNoRadioList('row[published]', $row['published']); ?></td>
        </tr>
        <?php if (get_option('wpg_methodUpdateSort')==1) { ?>
        <tr>
        <td>Период обновления ленты (сек.)</td><td><input style="text-align: center;" type="text" name="row[interval]" value="<?php echo $row['interval']; ?>" size="5" /></td>
        </tr>
        <?php } ?>
    </table>
</div>

<!--Контент-->
<div class="tab-content" id="div_tab2"<?php echo $tab == 2 ? ' style="display: block;"' : ''; ?>>
    <table class="tab-content-table">
        <tr>
        <td width="315">За один запуск сохранять не более (записей)</td><td><input style="text-align: center;" type="text" name="params[max_items]" size="5" value="<?php echo $row['params']['max_items']; ?>" /> (0 - неограничено)</td>
        </tr>
        <tr>
        <td>Сохранять записи только уникальными (не повторяющимися) заголовками</td><td><?php echo WPGHelper::yesNoRadioList('params[titleUniqueOn]', $row['params']['titleUniqueOn']); ?></td>
        </tr>
        <tr>
        <td>Сохранять записи в Рубрике</td><td><?php echo WPGHelper::getCategoriesList('params[catid]', $row['params']['catid']); ?></td>
        </tr>
        <tr>
        <td>Тип</td><td><?php echo WPGHelper::selectList('params[postType]', WPGHelper::getPostTypes(), $row['params']['postType'], true); ?></td>
        </tr>
        <tr>
        <td>Автор записей</td><td><?php echo WPGHelper::selectList('params[user_id]', WPGHelper::getAuthors(), $row['params']['user_id'], true); ?></td>
        </tr>
        <tr>
        <td>Статус создаваемых записей</td><td><?php echo WPGHelper::selectList('params[post_status]', WPGHelper::getListPostStatus(), $row['params']['post_status'], true); ?></td>      
        </tr>
    </table>
    <fieldset>
        <legend>Настройка генерации анонса</legend>
        <table>
        <tr>
        <td width="300">Для выделения анонса вставлять тег <b>Далее</b></td><td><?php echo WPGHelper::yesNoRadioList('params[post_more_on]', $row['params']['post_more_on']); ?></td>
        </tr>
        <tr>
        <td>Размер анонсовой части текст (кол-во символов)</td><td><input style="text-align: center;" type="text" name="params[intro_size]" size="5" value="<?php echo $row['params']['intro_size']; ?>" /></td>
        </tr>
        <tr>
        <td>Конечный символ для отделения анонса</td><td><input style="text-align: center; float:none;" type="text" name="params[introSymbolEnd]" size="5" value="<?php echo $row['params']['introSymbolEnd']; ?>" /> - <small>пустое значение в этом поле заменяется на пробел (для обрезки по предложению вставте точку .)</small></td>
        </tr>
        </table>
    </fieldset>
    <fieldset>
        <legend>Настройки генерации постоянных ссылок</legend>
        <table>
        <tr>
        <td width="300">Формировать постоянные ссылки для записей</td><td><?php echo WPGHelper::yesNoRadioList('params[postSlugOn]', $row['params']['postSlugOn']); ?></td>
        </tr>
        <tr>
        <td>Метод генерации</td><td><?php echo WPGHelper::selectList('params[aliasMethod]', array('транслитерация заголовков'), $row['params']['aliasMethod'], 1); ?></td>
        </tr>
        <tr>
        <td>Размер алиаса (кол-во символов)</td>
        <td><input type="text" name="params[aliasSize]" style="text-align:center;" size="8" value="<?php echo $row['params']['aliasSize']; ?>" /> <small>(0 - не обрезать!)</small></td>
        </tr>
        </table>
        </fieldset>
</div>

<!--Картинки-->
<div class="tab-content" id="div_tab3"<?php echo $tab == 3 ? ' style="display: block;"' : ''; ?>>
    <table class="tab-content-table">
        <tr>
            <td width="270">Не сохранять записи без картинок</td><td><?php echo WPGHelper::yesNoRadioList('params[no_save_without_pic]', $row['params']['no_save_without_pic']); ?></td>
        </tr>
        <tr>
            <td>Вырезать первую картинку в начало записи</td><td><?php echo WPGHelper::yesNoRadioList('params[intro_pic_on]', $row['params']['intro_pic_on']); ?></td>
        </tr>
    </table>
    <fieldset>
    <legend>Настройки сохранения картинок на сервере</legend>
    <table class="tab-content-table">
         <tr>
            <td>Сохранять картинки на сервере <br></td><td><?php echo WPGHelper::yesNoRadioList('params[image_save]', $row['params']['image_save'], array(' onchange="if (this.value==1){document.getElementById(\'tr-post_thumb_on\').style.display=\'\';}else{document.getElementById(\'tr-post_thumb_on\').style.display=\'none\';}" ', ' onchange="if (this.value==0){document.getElementById(\'tr-post_thumb_on\').style.display=\'none\';}else{document.getElementById(\'tr-post_thumb_on\').style.display=\'\';}" ')); ?> &nbsp;&nbsp;&nbsp;<i>( включите данную опцию для создания миниатюр записей WordPress )</i></td>
        </tr>
        <tr id="tr-post_thumb_on"<?php if (!$row['params']['image_save']) echo ' style="display:none;"'; ?>>
            <td>Назначить первую картинку в качестве миниатюры записи</td><td><?php echo WPGHelper::yesNoRadioList('params[post_thumb_on]', $row['params']['post_thumb_on']); ?></td>
        </tr>
        <tr>
            <td>Включить обработку пробелов в путях картинок</td><td><?php echo WPGHelper::yesNoRadioList('params[image_space_on]', $row['params']['image_space_on']); ?></td>
        </tr>
        <tr>
            <td width="260">Каталог хранения картинок</td><td><input type="text" name="params[image_path]" value="<?php echo htmlentities($row['params']['image_path']); ?>" size="60" /></td>
        </tr>
        <tr>
            <td>Генерация путей картинок</td><td><?php echo WPGHelper::selectList('params[img_path_method]', array('0'=>'/относительный путь', '1'=>'относительный путь', '2'=>'абсолютный путь'), $row['params']['img_path_method'], 1); ?></td>
        </tr>
        <tr>
            <td valign="top">Шаблон HTML-кода картинок</td><td>
            <textarea name="params[imageHtmlCode]" style="width: 421px; height: 50px;"><?php echo htmlentities($row['params']['imageHtmlCode'], ENT_COMPAT, 'UTF-8'); ?></textarea><br />
            <small style="font-size: 10px;">по умолчанию: <b style="font-family: Tahoma;">&lt;img src=&quot;%PATH%&quot; /&gt;</b>
            <br />где %PATH% - путь до картинки, %ADDS% - атрибуты элемента IMG из исходника,<br /> %TITLE% - заголовок материала, %ATTR% - дополнительные атрибуты картинок</small>
            </td>
        </tr>
    </table>
    </fieldset>
    <fieldset>
    <legend>Изменение размеров картинок</legend>
        <table class="tab-content-table">
            <tr>
            <td width="260">Изменять размеры изображений</td><td><?php echo WPGHelper::yesNoRadioList('params[image_resize]', $row['params']['image_resize']); ?></td>
            </tr>
            <tr>
            <td colspan="2">
            <fieldset>
            <legend>Параметры картинок в анонсе</legend>
            Метод масштабирования: <?php echo WPGHelper::selectList('params[img_intro_crop]', array('с сохранением пропорций', 'кадрирование (точные размеры)'), $row['params']['img_intro_crop'], 1, 'style="float:none;"'); ?><br><br>
            Ширина: <input style="text-align: center;" type="text" name="params[intro_pic_width]" value="<?php echo $row['params']['intro_pic_width']; ?>" size="6" /> Высота: <input style="text-align: center;" type="text" name="params[intro_pic_height]" value="<?php echo $row['params']['intro_pic_height']; ?>" size="6" /> Качество JPEG: <input style="text-align: center;" type="text" name="params[intro_pic_quality]" value="<?php echo $row['params']['intro_pic_quality']; ?>" size="6" />
            </fieldset>
            </td>
            </tr>
            <tr>
            <td colspan="2">
            <fieldset>
            <legend>Параметры картинок в основном тексте</legend>
            Ширина: <input style="text-align: center;" type="text" name="params[text_pic_width]" value="<?php echo $row['params']['text_pic_width']; ?>" size="6" /> Высота: <input style="text-align: center;" type="text" name="params[text_pic_height]" value="<?php echo $row['params']['text_pic_height']; ?>" size="6" /> Качество JPEG: <input style="text-align: center;" type="text" name="params[text_pic_quality]" value="<?php echo $row['params']['text_pic_quality']; ?>" size="6" />
            </fieldset>
            </td>
            </tr>
        </table>
    </fieldset>
</div>

<!--Перевод-->
<div class="tab-content" id="div_tab4"<?php echo $tab == 4 ? ' style="display: block;"' : ''; ?>>
  <table class="tab-content-table">
      <tr>
        <td width="230">Не сохранять записи если не получилось перевести заголовок или текст</td>
        <td><?php echo WPGHelper::yesNoRadioList('params[nosave_if_not_translate]', $row['params']['nosave_if_not_translate']); ?></td>
      </tr>
  </table>
  <fieldset>
    <legend>Первый перевод</legend>
    <script>
      function setTranslateProviderInfo(e) {
        var provider = jQuery(e).val();
        jQuery('.translate-select-list').attr('disabled', true).hide();
        jQuery('#translate-select-list-'+provider).attr('disabled', false).show();
          if (provider == 0) {
            jQuery('#yandex-api-key').show();
          } else {
            jQuery('#yandex-api-key').hide();
          }
      }
    </script>
    <table class="tab-content-table">
      <tr>
        <td width="220">Включить первый перевод записей</td>
        <td><?php echo WPGHelper::yesNoRadioList('params[translate_on]', $row['params']['translate_on']); ?></td>
      </tr>
      <tr>
        <td>Используемая система перевода</td>
        <td>
          <?php echo WPGHelper::selectList(
                       'params[translate_method]',
                       WPGHelper::translateProvidersList(),
                       $row['params']['translate_method'],
                       true,
                       'onchange="setTranslateProviderInfo(this);"'
                     ); ?></td>
      </tr>
      <?php $selected_provider = (int)$row['params']['translate_method']; ?>
      <tr>
        <td>Направление перевода</td>
        <td>
          <?php foreach (WPGHelper::translateProvidersList() as $provider => $name): ?>
            <?php echo WPGHelper::selectList(
                         'params[translate_lang]',
                         WPGHelper::translateLangsList($provider),
                         $row['params']['translate_lang'],
                         true,
                         'class="translate-select-list" id="translate-select-list-'.$provider.'"'.
                           (($provider != $selected_provider) ? ' disabled="disabled" style="display: none;"' : '')
                       ); ?>
          <?php endforeach; ?>
        </td>
      </tr>
        <tr<?php echo ($selected_provider != 0) ? ' style="display: none;"' : ''; ?> id="yandex-api-key">
          <td>API-ключ для Яндекс.Перевода</td>
          <td>
            <input type="text" name="params[yandex_api_key]" value="<?php echo WPGTools::esc($row['params']['yandex_api_key']); ?>" size="90" />
          </td>
        </tr>
    </table>
  </fieldset>
  <fieldset>
    <legend>Второй перевод</legend>
    <script>
      function setTranslateProviderInfo2(e) {
        var provider = jQuery(e).val();
        jQuery('.translate-select-list2').attr('disabled', true).hide();
        jQuery('#translate-select-list2-'+provider).attr('disabled', false).show();
          if (provider == 0) {
            jQuery('#yandex-api-key2').show();
          } else {
            jQuery('#yandex-api-key2').hide();
          }
      }
    </script>
    <table class="tab-content-table">
      <tr>
        <td width="220">Включить второй перевод записей</td>
        <td><?php echo WPGHelper::yesNoRadioList('params[translate2_on]', $row['params']['translate2_on']); ?></td>
      </tr>
      <tr>
        <td>Используемая система перевода</td>
        <td>
          <?php echo WPGHelper::selectList(
                       'params[translate2_method]',
                       WPGHelper::translateProvidersList(),
                       $row['params']['translate2_method'],
                       true,
                       'onchange="setTranslateProviderInfo2(this);"'
                     ); ?></td>
      </tr>
      <?php $selected_provider = (int)$row['params']['translate2_method']; ?>
      <tr>
        <td>Направление перевода</td>
        <td>
          <?php foreach (WPGHelper::translateProvidersList() as $provider => $name): ?>
            <?php echo WPGHelper::selectList(
                         'params[translate2_lang]',
                         WPGHelper::translateLangsList($provider),
                         $row['params']['translate2_lang'],
                         true,
                         'class="translate-select-list2" id="translate-select-list2-'.$provider.'"'.
                           (($provider != $selected_provider) ? ' disabled="disabled" style="display: none;"' : '')
                       ); ?>
          <?php endforeach; ?>
        </td>
      </tr>
        <tr<?php echo ($selected_provider != 0) ? ' style="display: none;"' : ''; ?> id="yandex-api-key2">
          <td>API-ключ для Яндекс.Перевода</td>
          <td>
            <input type="text" name="params[yandex_api_key2]" value="<?php echo WPGTools::esc($row['params']['yandex_api_key2']); ?>" size="90" />
          </td>
        </tr>
    </table>
  </fieldset>
</div>

<!--SEO-->
<div class="tab-content" id="div_tab5" style="display: none;">
        <fieldset>
        <legend>Настройки генерации меток для записи</legend>
            <table>
            <tr>
            <td width="260">Включить генерацию меток</td><td><?php echo WPGHelper::yesNoRadioList('params[tagsOn]', $row['params']['tagsOn']); ?></td>
            </tr>
            <tr>
            <td>Количество меток</td><td><input type="text" name="params[tagsCount]" style="text-align:center;" size="8" value="<?php echo $row['params']['tagsCount']; ?>" /></td>
            </tr>
            <tr>
            <td valign="top">Список стоп-слов через запятую<br />исключаемых из меток</td><td><textarea name="params[tagsStopList]" style="width: 450px; height: 70px;"><?php echo $row['params']['tagsStopList'] ? $row['params']['metaKeysStopList'] : 'без, более, бы, был, была, были, было, быть, вам, вас, ведь, весь, вдоль, вместо, вне, вниз, внизу, внутри, во, вокруг, вот, все, всегда, всего, всех, вы, где, да, давай, давать, даже, для, до, достаточно, его, ее, её, если, есть, ещё, же, за, за исключением, здесь, из, из-за, или, им, иметь, их, как, как-то, кто, когда, кроме, кто, ли, либо, мне, может, мои, мой, мы, на, навсегда, над, надо, наш, не, него, неё, нет, ни, них, но, ну, об, однако, он, она, они, оно, от, отчего, очень, по, под, после, потому, потому что, почти, при, про, снова, со, так, также, такие, такой, там, те, тем, то, того, тоже, той, только, том, тут, ты, уже, хотя, чего, чего-то, чей, чем, что, чтобы, чьё, чья, эта, эти, это'; ?></textarea></td>
            </tr>
            </table>    
        </fieldset>
</div>

<!--Обработка-->
<div class="tab-content" id="div_tab6"<?php echo $tab == 6 ? ' style="display: block;"' : ''; ?>>
    <table class="tab-content-table">
        <tr>
        <td>Удалять HTML-теги</td><td><?php echo WPGHelper::yesNoRadioList('params[strip_tags]', $row['params']['strip_tags']); ?></td>
        </tr>
        <tr>
        <td>Разрешенные HTML-теги</td>
        <td><input type="text" name="params[allowed_tags]" size="100" value="<?php echo $row['params']['allowed_tags']; ?>" /></td>
        </tr>
        <tr>
        <tr>
        <td>Удалять JavaScript-код</td><td><?php echo WPGHelper::yesNoRadioList('params[js_script_no_del]', $row['params']['js_script_no_del'], '', 'Нет', 'Да'); ?> &nbsp;&nbsp;&nbsp;<i>( при включении в <b>Да</b>, добавьте в разрешенные HTML-теги: <b>&lt;script&gt;</b> ) </i></td>
        </tr>
        <tr>
        <td>Удалять CSS-код</td><td><?php echo WPGHelper::yesNoRadioList('params[css_no_del]', $row['params']['css_no_del'], '', 'Нет', 'Да'); ?> &nbsp;&nbsp;&nbsp;<i>( при включении в <b>Да</b>, добавьте в разрешенные HTML-теги: <b>&lt;style&gt;</b> ) </i></td>
        </tr>
        <tr>
        <td>Включить дополнительные шаблоны обработки</td><td><?php echo WPGHelper::yesNoRadioList('params[user_replace_on]', $row['params']['user_replace_on']); ?></td>
        </tr>
        <tr>
        <td colspan="2">
        <fieldset>
        <legend>Дополнительные шаблоны обработки:</legend>
        <div style="overflow: auto; height: 400px;">
            <style>
            .truser tr td, tr th {
                padding: 3px;
                background: #e7e7e7;
                font-size: 12px;
            }
            .truser input, .truser select {
                font-size: 12px;
            }
            .truser tr th {
                text-align: center;    
            }
            </style>
            <table class="truser">
                <tr>
                <th width="30px">#</th>
                <th>Объект применения</th>
                <th>Наименование шаблона</th>
                <th>Шаблон поиска</th>
                <th>Шаблон замены</th>
                <th>Кол-во замен</th>
                </tr>
                <?php
                for ($i=0; $i<20; $i++) { ?>
                <tr align="center">
                <td><?php echo ($i+1); ?></td>
                <td><?php echo WPGHelper::selectList("params[usrepl][$i][type]", array('0' => 'выключен', 'index' => 'индексная html-страница (rss-контент или vk-лента)', 'page' => 'страница контента до парсинга', 'intro' => 'анонс', 'text' => 'полный текст', 'title' => 'заголовок'), $row['params']['usrepl'][$i]['type'], 1, 'style="width:150px;"'); ?></td>
                <td><input size="30" type="text" name="params[usrepl][<?php echo $i; ?>][name]" value="<?php echo $row['params']['usrepl'][$i]['name']; ?>" /></td>
                <td><input size="60" type="text" name="params[usrepl][<?php echo $i; ?>][search]" value="<?php echo htmlspecialchars($row['params']['usrepl'][$i]['search']); ?>" /></td>
                <td><input size="50" type="text" name="params[usrepl][<?php echo $i; ?>][replace]" value="<?php echo htmlspecialchars($row['params']['usrepl'][$i]['replace']); ?>" /></td>
                <td><input style="text-align:center;" size="5" type="text" name="params[usrepl][<?php echo $i; ?>][limit]" value="<?php echo $row['params']['usrepl'][$i]['limit']; ?>" /></td>
                </tr>
                <?php } ?>
            </table>
        </div>
        </fieldset>
        </td>
        </tr>
    </table>
</div>


<!--Вид-->
<div class="tab-content" id="div_tab7"<?php echo $tab == 7 ? ' style="display: block;"' : ''; ?>>
    <table class="tab-content-table">
        <tr>
        <td>Использовать шаблон формирования записи</td><td><?php echo WPGHelper::yesNoRadioList('params[template_on]', $row['params']['template_on']); ?></td>
        </tr>
    </table>
    <fieldset>
        <legend>Шаблон записи</legend>
        <table>
        <tr>
        <td>Заголовок</td><td><input type="text" name="params[template_title]" style="width:410px" value="<?php echo $row['params']['template_title']; ?>" /></td>
        </tr>
        <tr>
          <td valign="top">Текст</td>
            <td>
                <table cellpadding="0" cellspacing="0">
                <tr valign="top">
                <td><textarea name="params[template_full_text]" style="width:410px" rows="13"><?php echo $row['params']['template_full_text']; ?></textarea></td>
                <td style="padding: 10px;">
                    <b>%TITLE%</b> - Заголовок записи<br />
                    <b>%INTRO_TEXT%</b> - Анонсовая часть текста<br />
                    <b>%FULL_TEXT%</b> - Полный текст<br />
                    <b>%INTRO_PIC%</b> - Первая найденная картинка в тексте<br />
                    <b>%FEED%</b> - Наименование ленты<br />
                    <b>%FEED_URL%</b> - URL ленты<br />
                    <b>%SOURCE_URL%</b> - ссылка на источник материала<br />
                    <b>%SOURCE_SITE%</b> - URL-адрес сайта-источника<br />
                    <b>%TITLE_SOURCE%</b> - Заголовок до первого перевода<br />
                    <b>%TEXT_SOURCE%</b> - Текст до первого перевода<br />
                    <b>%NOW_DATE%</b> - Текущая дата в формате 12.03.2015<br />
                    <b>%NOW_TIME%</b> - Текущее время в формате 23:00<br />
                    <b><?php echo htmlentities('<a href="%SOURCE_URL%">Источник</a>', 0, 'utf-8'); ?></b> - пример ссылки на источник
                    </td>
                </tr>
                </table>
            </td>
        </tr>
        </table>
    </fieldset>
</div>


<!--Дополнительно-->
<div class="tab-content" id="div_tab8"<?php echo $tab == 8 ? ' style="display: block;"' : ''; ?>>
    <table class="tab-content-table">
        <tr>
        <td width="225">Для запросов использовать метод</td><td><?php echo WPGHelper::selectList('params[requestMethod]', array('0'=>'по умолчанию', '1'=>'CURL','2'=>'file_get_contents','3'=>'fsockopen'), $row['params']['requestMethod'], 1); ?></td>
        </tr>
    </table>
    <fieldset>
        <legend>Обработка фильтр-слов</legend>
        <table>
        <tr>
        <td width="215">Включить обработку фильтр-слов</td><td><?php echo WPGHelper::yesNoRadioList('params[filter_words_on]', $row['params']['filter_words_on']); ?></td>
        </tr>
        <tr>
        <td>Искать слова</td><td><?php echo WPGHelper::selectList('params[filter_words_where]', array('title'=>'в заголовке', 'text'=>'в тексте', 'title+text'=>'в заголовке и тексте'), $row['params']['filter_words_where'], 1); ?></td>
        </tr>
        <tr>
        <td>При появлении слов</td><td><?php echo WPGHelper::selectList('params[filter_words_save]', array('сохранять записи', 'не сохранять записи'), $row['params']['filter_words_save'], 1); ?></td>
        </tr>
        <tr>
            <td valign="top">Список фильтр-слов <br>(если несколько, то через запятую)</td><td><textarea name="params[filter_words_list]" style="width: 450px; height: 70px;"><?php echo $row['params']['filter_words_list']; ?></textarea></td>
            </tr>
        </table>
    </fieldset>
    <?php if(wpgIsStandard()): ?>
      <fieldset>
        <legend>Синонимизация через сервис Synonyma.ru</legend>
        <table class="tab-content-table">
          <tr>
            <td width="220">Включить синонимизацию</td>
            <td><?php echo WPGHelper::yesNoRadioList('params[synonyma_on]', $row['params']['synonyma_on']); ?></td>
          </tr>
        </table>
      </fieldset>
    <?php endif; ?>
</div>
<input type="hidden" name="row[id]" value="<?php echo $row['id']; ?>">
<div class="button-panel">
<?php submit_button($isNew ? 'Сохранить' : 'Сохранить изменения','primary'); ?>
<?php submit_button('Применить','secondary','apply',false,array('onclick'=>"this.form.action='?page=wpgrabber-edit&act=apply';")); ?>
<?php if (!$isNew): ?>
  <?php submit_button('Тест импорта', 'secondary', 'ajax-button-test', false,array('onclick'=>'wpgrabberRun('.$row['id'].', true); return false;')); ?>
  <?php submit_button('Импорт', 'secondary', 'ajax-button-exec', false,array('onclick'=>'wpgrabberRun('.$row['id'].', false); return false;')); ?>
<?php endif; ?>
<?php submit_button('Отмена','secondary','cancel',false,array('onclick'=>"this.form.action='?page=wpgrabber-index';")); ?>
</div>
</form>
</div><br><br>