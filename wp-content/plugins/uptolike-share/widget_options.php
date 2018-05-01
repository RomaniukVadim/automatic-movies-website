<?php

class MySettingsPage {
    public $options;
    public $settings_page_name = 'uptolike_settings';

    public function __construct() {
        add_action('admin_menu', array($this, 'add_plugin_page'));
        add_action('admin_init', array($this, 'page_init'));
        $this->options = get_option('my_option_name');
    }

    public function add_plugin_page() {
        add_options_page('Settings Admin', 'UpToLike', 'manage_options', $this->settings_page_name, //'my-setting-admin',
            array($this, 'create_admin_page'));
    }

    /** creates url of iframe with statistics page from given params
     *
     * @param $projectId
     * @param $partnerId
     * @param $mail
     * @param $cryptKey
     *
     * @return stringшfr
     */
    public function statIframe($projectId, $partnerId, $mail, $cryptKey) {
        $params = array('mail' => $mail, 'partner' => $partnerId, 'projectId' => $projectId,

        );
        $paramsStr = 'mail=' . $mail . '&partner=' . $partnerId . '&projectId=' . $projectId;
        $signature = md5($paramsStr . $cryptKey);
        $params['signature'] = $signature;
        $finalUrl = 'https://uptolike.com/api/statistics.html?' . http_build_query($params);

        return $finalUrl;
    }

    /** create url of iframe with constructor from given params
     *
     * @param $projectId
     * @param $partnerId
     * @param $mail
     * @param $cryptKey
     *
     * @return string
     */
    public function constructorIframe($projectId, $partnerId, $mail, $cryptKey) {
        $params = array('mail' => $mail, 'partner' => $partnerId, 'projectId' => $projectId);

        $paramsStr = 'mail=' . $mail . '&partner=' . $partnerId . '&projectId=' . $projectId . $cryptKey;
        $signature = md5($paramsStr);
        $params['signature'] = $signature;
        if ('' !== $cryptKey) {
            $finalUrl = 'https://uptolike.com/api/constructor.html?' . http_build_query($params);
        } else $finalUrl = 'https://uptolike.com/api/constructor.html';
        return $finalUrl;
    }

    /** returns tabs html code. May be replace by proper html code
     *
     * @param string $current
     */
    public function ilc_admin_tabs($current = 'construct') {
        $tabs = array('construct' => 'Конструктор', 'stat' => 'Статистика', 'settings' => 'Настройки');

        echo '<div id="icon-themes" class="icon32"><br></div>';
        echo '<h2 class="nav-tab-wrapper">';
        foreach ($tabs as $tab => $name) {
            $class = ($tab == $current) ? ' nav-tab-active' : '';
            echo "<a class='nav-tab$class' href='#' id=" . $tab . " ref='?page=" . $this->settings_page_name . "&tab=$tab'>$name</a>";
        }
        echo '</h2>';
    }

    /** render html page with code configuration settings
     */
    public function create_admin_page() {
        $this->options = get_option('my_option_name');
        if ((isset($this->options['uptolike_email'])) && ('' !== $this->options['uptolike_email'])) {
            $email = $this->options['uptolike_email'];
        } else $email = get_option('admin_email');
        $partnerId = 'cms';
        $projectId = 'cms' . preg_replace('/^www\./', '', $_SERVER['HTTP_HOST']);
        $projectId = str_replace('.', '', $projectId);
        $projectId = str_replace('-', '', $projectId);
        $options = get_option('my_option_name');
        if (is_array($options) && array_key_exists('id_number', $options)) {
            $cryptKey = $options['id_number'];
        } else $cryptKey = '';
        ?>
        <script type="text/javascript">
            <?php include('js/main.js'); ?>
        </script>
        <style type="text/css">
            <?php include('css/uptolike_style.css')?>
        </style>
        <div id="uptolike_site_url" style="display: none"><?php echo get_site_url(); ?></div>
        <div class="wrap">
            <h2 class="placeholder">&nbsp;</h2>

            <div id="wrapper">
                <form id="settings_form" method="post" action="options.php">
                    <h1> UpToLike виджет</h1>
                    <h2 class="nav-tab-wrapper">
                        <a class="nav-tab nav-tab-active" href="#" id="construct">
                            Конструктор
                        </a>
                        <a class="nav-tab" href="#" id="stat">
                            Статистика
                        </a>
                        <a class="nav-tab" href="#" id="settings">
                            Настройки
                        </a>
                    </h2>

                    <div class="wrapper-tab active" id="con_construct">
                        <iframe id='cons_iframe' style='height: 445px;width: 100%;'
                                data-src="<?php echo $this->constructorIframe($projectId, $partnerId, $email, $cryptKey); ?>"></iframe>
                        <br>
                        <a onclick="getCode();" href="#">
                            <button type="reset">Сохранить изменения</button>
                        </a>
                    </div>
                    <div class="wrapper-tab" id="con_stat">
                        <iframe style="width: 100%;height: 380px;" id="stats_iframe"
                                data-src="<?php echo $this->statIframe($projectId, $partnerId, $email, $cryptKey); ?>">
                        </iframe>
                        <div id="before_key_req">Введите ваш адрес электронной почты для получения
                            ключа.
                        </div>
                        <div id="after_key_req">На ваш адрес электронной почты отправлен секретный
                            ключ. Введите его в поле ниже<br/>
                            Если письмо с ключом долго не приходит, возможно оно попало в Спам.<br/><br/>
                            Если ключ так и не был получен напишите письмо в службу поддержки: <a
                                href="mailto:uptolikeshare@gmail.com">uptolikeshare@gmail.com</a><br/>
                            В письме пришлите, пожалуйста, адрес вашего сайта и адрес электронной
                            почты, указанный в плагине.<br/>
                        </div>
                        <table>
                            <tr id="email_tr">
                                <td>Email:</td>
                                <td><input type="text" id="uptolike_email_field"></td>
                            </tr>
                            <tr id="cryptkey_field">
                                <td>Ключ:</td>
                                <td><input type="text" id="uptolike_cryptkey"></td>
                            </tr>
                            <tr id="get_key_btn_field">
                                <td></td>
                                <td>
                                    <button id="get_key" type="button"> Получить ключ</button>
                                </td>
                            </tr>
                            <tr id="bad_key_field">
                                <td colspan="2">Введен неверный ключ! Убедитесь что вы скопировали
                                    ключ без лишних символов (пробелов и т.д.)
                                </td>
                            </tr>
                            <tr id="foreignAccess_field">
                                <td colspan="2">Данный проект принадлежит другому пользователю.
                                    Обратитесь в службу поддержки
                                </td>
                            </tr>
                            <tr id="key_auth_field">
                                <td></td>
                                <td>
                                    <button id="auth" type="button"> Авторизация</button>
                                </td>
                            </tr>
                        </table>
                        <div>Обратная связь: <a href="mailto:uptolikeshare@gmail.com">uptolikeshare@gmail.com</a>
                        </div>
                    </div>
                    <div class="wrapper-tab" id="con_settings">
                        <div class="utl_left_block">
                            <?php
                            settings_fields('my_option_group');
                            do_settings_sections('uptolike_settings');
                            ?>
                            <input type="submit" name="submit_btn" value="Cохранить изменения">
                            <br>
                        </div>
                        <div class="utl_right_block">
                            <div class="utl_blok1">
                                <div class="utl_blok2">
                                    <div class="utl_logo utl_i_logo">
                                    </div>
                                </div>
                                <div class="utl_innertext">Для вставки шорткода в .php файл шаблона
                                    нужно использовать конструкцию
                                    <br><b><i>
                                            &lt;?php echo do_shortcode("[uptolike]"); ?&gt;<br></i></b>
                                    Для вставки в режиме визуального редактора достаточно
                                    вставить<b> <i>[uptolike]</i></b>.
                                </div>
                            </div>
                            <div class="utl_blok1">
                                <div class="utl_blok2">
                                    <div class="utl_logo utl_like_logo">
                                    </div>
                                </div>
                                <div class="utl_innertext">Данный плагин полностью бесплатен. Мы
                                    регулярно его улучшаем и добавляем новые функции.<br>
                                    Пожалуйста, оставьте свой отзыв на <a
                                        href="https://wordpress.org/support/view/plugin-reviews/uptolike-share">данной
                                        странице</a>. Спасибо! <br>
                                </div>
                            </div>
                            <div class="utl_blok1">
                                <div class="utl_blok2">
                                    <div class="utl_logo utl_mail_logo">
                                    </div>
                                </div>
                                <div class="utl_innertext"><a
                                        href="http://uptolike.ru">Uptolike.ru</a> &mdash; конструктор
                                    социальных кнопок для вашего сайта с расширенным
                                    функционалом.<br>
                                    Служба поддержки: <a
                                        href="mailto:uptolikeshare@gmail.com">uptolikeshare@gmail.com</a>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
        <?php
    }

    public function page_init() {
        register_setting('my_option_group', 'my_option_name', array($this, 'sanitize'));

        add_settings_section('setting_section_id', 'Настройки отображения блока Uptolike', array($this, 'print_section_info'), $this->settings_page_name);

        add_settings_field('widget_code', 'код виджета', // Title
            array($this, 'widget_code_callback'), $this->settings_page_name, 'setting_section_id');

        add_settings_field('data_pid', 'Ключ(CryptKey)', array($this, 'id_number_callback'), $this->settings_page_name, 'setting_section_id');

        add_settings_field('email',
            'email для регистрации', array($this, 'uptolike_email_callback'), $this->settings_page_name, 'setting_section_id');

        add_settings_field('on_main',
            'На главной странице ', array($this, 'uptolike_on_main_callback'), $this->settings_page_name, 'setting_section_id');

        add_settings_field('on_page',
            'На статических страницах', array($this, 'uptolike_on_page_callback'), $this->settings_page_name, 'setting_section_id');

        add_settings_field('on_post',
            'На страницах записей', array($this, 'uptolike_on_post_callback'), $this->settings_page_name, 'setting_section_id');

        add_settings_field('on_archive',
            'На страницах архивов', array($this, 'uptolike_on_archive_callback'), $this->settings_page_name, 'setting_section_id');

        add_settings_field('on_special_pages',
            'На спец. страницах <p class="utl_quest"><img class="utl_quest" src="/wp-content/plugins/uptolike-share/images/quest.png"><span class="utl_quest">Отображается только боковая панель на страницах, созданных плагинами (WooCommerce, WP-Shop и т.д.)</span></p>', array($this, 'uptolike_on_special_pages_callback'), $this->settings_page_name, 'setting_section_id');

        add_settings_field('widget_position',
            'Расположение блока', array($this, 'uptolike_widget_position_callback'), $this->settings_page_name, 'setting_section_id');

        add_settings_field('widget_align',
            'Выравнивание блока', array($this, 'uptolike_widget_align_callback'), $this->settings_page_name, 'setting_section_id');

        add_settings_field('widget_mode',
            'Режим работы', array($this, 'uptolike_widget_mode_callback'), $this->settings_page_name, 'setting_section_id');

        add_settings_field('utl_language',
            'Язык', array($this, 'uptolike_utl_language_callback'), $this->settings_page_name, 'setting_section_id');

        add_settings_field('uptolike_json',
            'настройки конструктора', array($this, 'uptolike_json_callback'), $this->settings_page_name, 'setting_section_id');
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize($input) {
        $new_input = array();
        if (isset($input['id_number'])) $new_input['id_number'] = str_replace(' ', '', $input['id_number']);

        if (isset($input['widget_code'])) $new_input['widget_code'] = $input['widget_code'];

        if (isset($input['uptolike_email'])) $new_input['uptolike_email'] = $input['uptolike_email'];

        if (isset($input['before_content'])) $new_input['before_content'] = $input['before_content'];

        if (isset($input['on_main'])) {
            $new_input['on_main'] = 1;
        } else $new_input['on_main'] = 0;

        if (isset($input['on_page'])) {
            $new_input['on_page'] = 1;
        } else $new_input['on_page'] = 0;

        if (isset($input['on_post'])) {
            $new_input['on_post'] = 1;
        } else $new_input['on_post'] = 0;

        if (isset($input['on_special_pages'])) {
            $new_input['on_special_pages'] = 1;
        } else $new_input['on_special_pages'] = 0;

        if (isset($input['on_archive'])) {
            $new_input['on_archive'] = 1;
        } else $new_input['on_archive'] = 0;

        if (isset($input['email'])) $new_input['email'] = $input['email'];

        if (isset($input['after_content'])) $new_input['after_content'] = $input['after_content'];

        if (isset($input['widget_position'])) $new_input['widget_position'] = $input['widget_position'];

        if (isset($input['widget_mode'])) $new_input['widget_mode'] = $input['widget_mode'];

        if (isset($input['widget_align'])) $new_input['widget_align'] = $input['widget_align'];

        if (isset($input['utl_language'])) $new_input['utl_language'] = $input['utl_language'];


        if (isset($input['uptolike_json'])) $new_input['uptolike_json'] = $input['uptolike_json'];

        return $new_input;
    }


    public function print_section_info() {
    }

    public function widget_code_callback() {
        printf('<textarea id="widget_code" name="my_option_name[widget_code]" >%s</textarea>', isset($this->options['widget_code']) ? esc_attr($this->options['widget_code']) : '');
    }

    /** 12536473050877
     * Get the settings option array and print one of its values
     */
    public function id_number_callback() {
        printf('<input type="text" class="id_number" name="my_option_name[id_number]" value="%s" />', isset($this->options['id_number']) ? esc_attr($this->options['id_number']) : '');
    }

    public function uptolike_email_callback() {
        printf('<input type="text" id="uptolike_email" name="my_option_name[uptolike_email]" value="%s" />', isset($this->options['uptolike_email']) ? esc_attr($this->options['uptolike_email']) : '');
    }

    public function uptolike_json_callback() {
        printf('<input type="hidden" id="uptolike_json" name="my_option_name[uptolike_json]" value="%s" />', isset($this->options['uptolike_json']) ? esc_attr($this->options['uptolike_json']) : '');
    }

    public function uptolike_partner_id_callback() {
        printf('<input type="text" id="uptolike_partner" name="my_option_name[uptolike_partner]" value="%s" />', isset($this->options['uptolike_partner']) ? esc_attr($this->options['uptolike_partner']) : '');
    }

    public function uptolike_project_callback() {
        printf('<input type="text" id="uptolike_project" name="my_option_name[uptolike_project]" value="%s" />', isset($this->options['uptolike_project']) ? esc_attr($this->options['uptolike_project']) : '');
    }

    public function uptolike_on_main_callback() {
        echo '<input type="checkbox" id="on_main" name="my_option_name[on_main]"';
        echo($this->options['on_main'] == '1' ? 'checked="checked"' : '');
        echo '/>';
    }

    public function uptolike_on_page_callback() {
        echo '<input type="checkbox" id="on_page" name="my_option_name[on_page]"';
        echo($this->options['on_page'] == '1' ? 'checked="checked"' : '');
        echo '/>';
    }

    public function uptolike_on_post_callback() {
        echo '<input type="checkbox" id="on_post" name="my_option_name[on_post]"';
        echo($this->options['on_post'] == '1' ? 'checked="checked"' : '');
        echo '/>';
    }

    public function uptolike_on_special_pages_callback() {
        echo '<input type="checkbox" id="on_special_pages" name="my_option_name[on_special_pages]"';
        echo($this->options['on_special_pages'] == '1' ? 'checked="checked"' : '');
        echo '/>';
    }

    public function uptolike_on_archive_callback() {
        echo '<input type="checkbox" id="on_archive" name="my_option_name[on_archive]"';
        echo($this->options['on_archive'] == '1' ? 'checked="checked"' : '');
        echo '/>';
    }

    public function uptolike_widget_mode_callback() {
        $plg_mode = $code_mode = $both_mode = '';

        if (isset($this->options['widget_mode'])) {
            if ($this->options['widget_mode'] == 'plg') {
                $plg_mode = "selected='selected'";
            } elseif ($this->options['widget_mode'] == 'code') {
                $code_mode = "selected='selected'";
            } elseif ($this->options['widget_mode'] == 'both') {
                $both_mode = "selected='selected'";
            }
        } else {
            $my_options = get_option('my_option_name');
            $my_options['widget_mode'] = 'plg'; // cryptkey store
            update_option('my_option_name', $my_options);
        }
        echo "<select id='widget_mode' name='my_option_name[widget_mode]'>
                            <option {$plg_mode} value='plg'>Плагин</option>
                            <option {$code_mode} value='code'>Шорткод</option>
                            <option {$both_mode} value='both'>Плагин и шорткод</option>
                        </select>";
    }

    public function uptolike_widget_align_callback() {
        $left = $right = $center = '';

        if (isset($this->options['widget_align'])) {
            if ('left' == $this->options['widget_align']) {
                $left = "selected='selected'";
            } elseif ('right' == $this->options['widget_align']) {
                $right = "selected='selected'";
            } elseif ('center' == $this->options['widget_align']) {
                $center = "selected='selected'";
            }
        } else {
            $my_options = get_option('my_option_name');
            $my_options['widget_align'] = 'left'; // cryptkey store
            update_option('my_option_name', $my_options);
        }

        echo "<select id='widget_align' name='my_option_name[widget_align]'>
                            <option {$left} value='left'>По левому краю</option>
                            <option {$right} value='right'>По правому краю</option>
                            <option {$center} value='center'>По центру</option>
                        </select>";
    }

    public function uptolike_widget_position_callback() {
        $top = $bottom = $both = '';

        if (isset($this->options['widget_position'])) {
            if ($this->options['widget_position'] == 'top') {
                $top = "selected='selected'";
            } elseif ($this->options['widget_position'] == 'bottom') {
                $bottom = "selected='selected'";
            } elseif ($this->options['widget_position'] == 'both') {
                if (json_decode($this->options['uptolike_json'])->orientation < 2) {
                    $both = "selected='selected'";
                } else {
                    $both = '';
                    $bottom = "selected='selected'";
                    $my_options = get_option('my_option_name');
                    $my_options['widget_position'] = 'bottom'; // cryptkey store
                    update_option('my_option_name', $my_options);
                }
            } else {
                $bottom = "selected='selected'";
            }
        } else {
            $my_options = get_option('my_option_name');
            $my_options['widget_position'] = 'bottom'; // cryptkey store
            update_option('my_option_name', $my_options);
        }
        echo "<select id='widget_position' name='my_option_name[widget_position]'>
            <option {$top} value='top'>Только сверху</option>
            <option {$bottom} value='bottom'>Только снизу</option>";
        if (json_decode($this->options['uptolike_json'])->orientation < 2) {
            echo "<option {$both} value='both'>Сверху и снизу</option>";
        }
        echo "</select>";

    }

    public function uptolike_utl_language_callback() {
        $ru = $en = $ua = $de = $es = $it = $pl = $lt = '';
        if (isset($this->options['utl_language'])) {
            if ($this->options['utl_language'] == 'ru') {
                $ru = "selected='selected'";
            } elseif ('en' == $this->options['utl_language']) {
                $en = "selected='selected'";
            } elseif ('ua' == $this->options['utl_language']) {
                $ua = "selected='selected'";
            } elseif ('de' == $this->options['utl_language']) {
                $de = "selected='selected'";
            } elseif ('es' == $this->options['utl_language']) {
                $es = "selected='selected'";
            } elseif ('it' == $this->options['utl_language']) {
                $it = "selected='selected'";
            } elseif ('pl' == $this->options['utl_language']) {
                $pl = "selected='selected'";
            } elseif ('lt' == $this->options['utl_language']) {
                $lt = "selected='selected'";
            } else {
                $ru = "selected='selected'";
            }
        } else {
            $my_options = get_option('my_option_name');
            $my_options['utl_language'] = 'ru'; // cryptkey store
            update_option('my_option_name', $my_options);
        }
        echo "<select id='widget_position' name='my_option_name[utl_language]'>
                    <option {$ru} value='ru'>Русский</option>
                    <option {$en} value='en'>Английский</option>
                    <option {$ua} value='ua'>Украинский</option>
                    <option {$de} value='de'>Немецкий</option>
                    <option {$es} value='es'>Испанский</option>
                    <option {$it} value='it'>Итальянский</option>
                    <option {$pl} value='pl'>Латвийский</option>
                    <option {$lt} value='lt'>Польский</option>
              </select>";
    }
}

function get_widget_code($url = '') {
    $options = get_option('my_option_name');
    $widget_code = $options['widget_code'];
    $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"], 0, strpos($_SERVER["SERVER_PROTOCOL"], '/'))) . '://';
    if ($url == '') {
        if (is_single() || is_page()) {
            $url = get_permalink();
        } else $url = $protocol . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
    }
    if ($_SERVER["REQUEST_URI"] == '/' && !(json_decode($options['uptolike_json'])->orientation < 2) && !empty(json_decode($options['uptolike_json'])->orientation)) {
        $url = home_url('/');
    }

    $domain = preg_replace('/^www\./', '', get_site_url());
    $data_pid = 'cms' . str_replace(array('https://', 'http://', '.', '-'), '', $domain);

    $widget_code = str_replace('data-pid="-1"', 'data-pid="' . $data_pid . '"', $widget_code);
    $widget_code = str_replace('data-pid=""', 'data-pid="' . $data_pid . '"', $widget_code);
    $widget_code = str_replace('div data', 'div data-url="' . $url . '" del', $widget_code);//data-url duplicate
    $widget_code = preg_replace('!del-url="(.*?)"!si', '', $widget_code);
    $widget_code = str_replace('del-url', '', $widget_code);
    $widget_code = str_replace('del-', '', $widget_code);
    $align = $options['widget_align'];

    $align_style = 'style="text-align: ' . $align . ';"';
    $widget_code = str_replace('div data', 'div data-lang="' . $options['utl_language'] . '" data', $widget_code);
    $widget_code = str_replace('<div ', '<div ' . $align_style . ' ', $widget_code);

    return $widget_code;
}

function add_widget($content) {
    global $post;
    $options = get_option('my_option_name');
    $widget_mode = $options['widget_mode'];
    if (is_array($options) && (($widget_mode == 'plg') or ($widget_mode == 'both')) && array_key_exists('widget_code', $options)) {
        if ((!empty(json_decode($options['uptolike_json'])->orientation) && json_decode($options['uptolike_json'])->orientation < 2) || !(isset(json_decode($options['uptolike_json'])->orientation))) {
            if (is_front_page() || is_home()) {
                if ($options['on_main'] == 1 && (home_url('/') == request_home_url())) {
                    switch ($options['widget_position']) {
                        case 'both':
                            return get_widget_code(get_permalink()) . $content . get_widget_code(get_permalink());
                        case 'top':
                            return get_widget_code(get_permalink()) . $content;
                        case 'bottom':
                            return $content . get_widget_code(get_permalink());
                    }
                } elseif ($options['on_main'] != 1 && (home_url('/') == request_home_url())) {
                    return $content;
                }
            } elseif (is_page() && $options['on_page'] == 1 && (home_url('/') != request_home_url())) {
                switch ($options['widget_position']) {
                    case 'both':
                        return get_widget_code(get_permalink()) . $content . get_widget_code(get_permalink());
                    case 'top':
                        return get_widget_code(get_permalink()) . $content;
                    case 'bottom':
                        return $content . get_widget_code(get_permalink());
                }
            } elseif (is_single() && $options['on_post'] == 1 && (home_url('/') != request_home_url())) {
                switch ($options['widget_position']) {
                    case 'both':
                        return get_widget_code(get_permalink()) . $content . get_widget_code(get_permalink());
                    case 'top':
                        return get_widget_code(get_permalink()) . $content;
                    case 'bottom':
                        return $content . get_widget_code(get_permalink());
                }
            } elseif (is_archive() && $options['on_archive'] == 1 && $options['on_post'] == 1) {
                switch ($options['widget_position']) {
                    case 'both':
                        return get_widget_code(get_permalink()) . $content . get_widget_code(get_permalink());
                    case 'top':
                        return get_widget_code(get_permalink()) . $content;
                    case 'bottom':
                        return $content . get_widget_code(get_permalink());
                }
            }
            return $content;
        } else { //if vertical panel
            if (is_front_page() || is_home()) {
                if ($options['on_main'] == 1 && (home_url('/') == request_home_url())) {
                    return $content . get_widget_code();
                } elseif ($options['on_main'] != 1 && (home_url('/') == request_home_url())) {
                    return $content;
                }
            } elseif (is_page()) {
                if ($options['on_page'] == 1 && (home_url('/') != request_home_url())) {
                    return $content . get_widget_code();
                } elseif ($options['on_page'] != 1) {
                    return $content;
                }
            } elseif (is_single()) {
                if ($options['on_post'] == 1 && (home_url('/') != request_home_url())) {
                    return $content . get_widget_code();
                } elseif ($options['on_post'] != 1) {
                    return $content;
                }
            } elseif (is_archive()) {
                if ($options['on_archive'] == 1 && $options['on_post'] == 1 && (home_url('/') != request_home_url())) {
                    return $content . get_widget_code();
                } elseif ($options['on_archive'] != 1) {
                    return $content;
                }
            }
        }
        return $content;
    }
    return $content;
}

add_filter('the_content', 'add_widget', 100);

function uptolike_shortcode($atts) {
    $options = get_option('my_option_name');
    $widget_mode = $options['widget_mode'];
    if (($widget_mode == 'code') or ($widget_mode == 'both')) {
        return get_widget_code();
    };
    return true;
}

add_shortcode('uptolike', 'uptolike_shortcode');

function my_widgetcode_notice() {
    $options = get_option('my_option_name');
    if (is_array($options) && array_key_exists('widget_code', $options)) {
        $widget_code = $options['widget_code'];
        if ($widget_code == '') {
            echo " <div class='updated'>
                     <p>Во вкладке 'Конструктор' плагина Uptolike настройте внешний вид кнопок и нажмите 'Сохранить изменения'</p>
              </div>";
        }
    };
}

function try_reg() {
    include('api_functions.php');
    $domain = preg_replace('/^www\./', '', $_SERVER['HTTP_HOST']);
    $options = get_option('my_option_name');
    $email = $options['uptolike_email'];
    if ('' == $options['id_number']) {
        $reg_ans = userReg($email, 'cms', 'cms' . $domain);
        if (is_string($reg_ans)) {
            $my_options = get_option('my_option_name');
            $my_options['id_number'] = $reg_ans; // cryptkey store
            $my_options['choice'] = 'reg';
            update_option('my_option_name', $my_options);
        };
        update_option('regme', true);
    }
}

function my_choice_notice() {
    $options = get_option('my_option_name');
    if (is_bool($options) or (('' == $options['id_number']) and ((!array_key_exists('choice', $options)) OR ('ignore' !== $options['choice'])))) {
        echo "<div class='updated' style='
            background: #fff url(//uptolike.com/img/logo.png) no-repeat 2px;
            padding-left: 50px;
            padding-top: 15px;
            padding-bottom: 15px;'>Кнопки Uptolike успешно установлены! <a href='options-general.php?page=uptolike_settings&choice=ignore' style='float: right;'>Закрыть</a></div>";
    };
}

function set_default_code() {
    $options = get_option('my_option_name');
    if (is_bool($options)) {
        $options = array();
    }
    $domain = get_site_url();
    $domain = str_replace(array('http://', 'https://', '.', '-', 'www.'), '', $domain);
    $data_pid = 'cms' . $domain;
    $code = <<<EOD
<script type="text/javascript">(function (w, doc) {
    if (!w.__utlWdgt) {
        w.__utlWdgt = true;
        var d = doc, s = d.createElement('script'), g = 'getElementsByTagName';
        s.type = 'text/javascript';
        s.charset = 'UTF-8';
        s.async = true;
        s.src = ('https:' == w.location.protocol ? 'https' : 'http') + '://w.uptolike.com/widgets/v1/uptolike.js';
        var h = d[g]('body')[0];
        h.appendChild(s);
    }
})(window, document);
</script>
<div data-url data-background-alpha="0.0" data-orientation="horizontal" data-text-color="000000" data-share-shape="round-rectangle" data-buttons-color="ff9300" data-sn-ids="fb.tw.ok.vk.gp.mr." data-counter-background-color="ffffff" data-share-counter-size="11" data-share-size="30" data-background-color="ededed" data-share-counter-type="common" data-pid data-counter-background-alpha="1.0" data-share-style="1" data-mode="share" data-following-enable="false" data-like-text-enable="false" data-selection-enable="true" data-icon-color="ffffff" class="uptolike-buttons">
</div>
EOD;
    $code = str_replace('data-pid', 'data-pid="' . $data_pid . '"', $code);
    $options['widget_code'] = $code;
    $options['on_main'] = 1;
    $options['on_page'] = 1;
    $options['on_post'] = 1;
    $options['on_special_pages'] = 1;
    $options['on_archive'] = 1;
    $options['widget_position'] = 'bottom';
    $options['widget_mode'] = 'plg';
    $options['widget_align'] = 'left';
    $options['utl_language'] = 'ru';
    update_option('my_option_name', $options);
}

function choice_helper($choice) {
    $options = get_option('my_option_name');
    $options['choice'] = $choice;
    if ('ignore' == $choice) {
        set_default_code();
    }
    update_option('my_option_name', $options);
}

function usb_admin_actions() {
    if (current_user_can('manage_options')) {
        if (function_exists('add_meta_box')) {
            add_menu_page("UpToLike", "UpToLike", "manage_options", "UpToLike", 'my_custom_menu_page', plugins_url('uptolike-share/images/logo-small.png'));
        }
    }
}

function my_custom_menu_page() {
    include_once('usb-admin.php');
}

function request_home_url($url = '') {
    $result = '';
    $default_port = 80;
    if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on')) {
        $result .= 'https://';
        $default_port = 443;
    } else {
        $result .= 'http://';
    }
    $result .= $_SERVER['SERVER_NAME'];
    if ($_SERVER['SERVER_PORT'] != $default_port) {
        $result .= ':' . $_SERVER['SERVER_PORT'];
    }
    $result .= $_SERVER['REQUEST_URI'];
    if ($url) {
        $result .= $url;
    }
    return $result;
}

function headeruptolike() {
    $options = get_option('my_option_name');
    if ((home_url('/') == request_home_url()) && $options['on_main'] == 1) {
        $in_content = array(0, 1);
        $in_fixed_block = array(2, 3, 4, 5);
        $curr_value = json_decode($options['uptolike_json'])->orientation;
        if (in_array($curr_value, $in_content)) {
        } elseif (in_array($curr_value, $in_fixed_block)) {
            echo get_widget_code();
        }
    } elseif ((home_url('/') != request_home_url()) && ($options['on_special_pages'] == 1 || $options['on_page'] == 1)) {
        $in_content = array(0, 1);
        $in_fixed_block = array(2, 3, 4, 5);
        $curr_value = json_decode($options['uptolike_json'])->orientation;
        if (in_array($curr_value, $in_content)) {
        } elseif (in_array($curr_value, $in_fixed_block)) {
            echo get_widget_code();
        }
    }
}

class UptolikeWidget extends WP_Widget {

    function UptolikeWidget() {
        parent::__construct(false, 'Блок кнопок UpToLike');
    }

    function widget($args, $instance) {
    }

    function update($new_instance, $old_instance) {
    }

    function form($instance) {
    }
}

function uptolike_register_widgets() {
    register_widget('UptolikeWidget');
}

register_activation_hook(__FILE__, 'usb_admin_actions');

add_action('widgets_init', 'uptolike_register_widgets');
add_action('wp_footer', 'headeruptolike', 1);
add_action('admin_notices', 'my_choice_notice');
add_action('admin_notices', 'my_widgetcode_notice');
add_action('admin_menu', 'usb_admin_actions');

if (is_admin()) {
    $options = get_option('my_option_name');
    if (array_key_exists('regme', $_REQUEST)) {
        try_reg();
    }
    if (array_key_exists('choice', $_REQUEST)) {
        choice_helper($_REQUEST['choice']);
    }
    $my_settings_page = new MySettingsPage();
    if (is_bool($options) OR (!array_key_exists('widget_code', $options)) OR ($options['widget_code'] == '')) {
        set_default_code();
    }
}