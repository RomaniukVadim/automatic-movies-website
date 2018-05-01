<?php

function constructorIframe($projectId, $partnerId, $mail, $cryptKey) {
    $params = array('mail' => $mail, 'partner' => $partnerId, 'projectId' => $projectId);

    $paramsStr = 'mail=' . $mail . '&partner=' . $partnerId . '&projectId=' . $projectId . $cryptKey;
    $signature = md5($paramsStr);
    $params['signature'] = $signature;
    if ('' !== $cryptKey) {
        $finalUrl = 'https://uptolike.com/api/constructor.html?' . http_build_query($params);
    } else $finalUrl = 'https://uptolike.com/api/constructor.html';

    return $finalUrl;
}

function statIframe($projectId, $partnerId, $mail, $cryptKey) {
    $params = array('mail' => $mail, 'partner' => $partnerId, 'projectId' => $projectId,

    );
    $paramsStr = 'mail=' . $mail . '&partner=' . $partnerId . '&projectId=' . $projectId;
    $signature = md5($paramsStr . $cryptKey);
    $params['signature'] = $signature;
    $finalUrl = 'https://uptolike.com/api/statistics.html?' . http_build_query($params);

    return $finalUrl;
}

function usb_admin_page() {
    $options = get_option('my_option_name');

    if ((isset($options['uptolike_email'])) && ('' !== $options['uptolike_email'])) {
        $email = $options['uptolike_email'];
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
                <h1>UpToLike виджет</h1>

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
                            data-src="<?php echo constructorIframe($projectId, $partnerId, $email, $cryptKey); ?>"></iframe>
                    <br>
                    <a onclick="getCode();" href="#">
                        <button type="reset">Сохранить изменения</button>
                    </a>
                </div>
                <div class="wrapper-tab" id="con_stat">

                    <iframe style="width: 100%;height: 380px;" id="stats_iframe"
                            data-src="<?php echo statIframe($projectId, $partnerId, $email, $cryptKey); ?>">
                    </iframe>

                    <div id="before_key_req">Введите ваш адрес электронной почты для получения
                        ключа.
                    </div>
                    <div id="after_key_req">На ваш адрес электронной почты отправлен секретный ключ.
                        Введите его в поле ниже<br/>
                        Если письмо с ключом долго не приходит, возможно оно попало в
                        Спам.<br/><br/>
                        Если ключ так и не был получен напишите письмо в службу поддержки: <a
                            href="mailto:uptolikeshare@gmail.com">uptolikeshare@gmail.com</a><br/>
                        В письме пришлите, пожалуйста, адрес вашего сайта и адрес электронной почты,
                        указанный в плагине.<br/>
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
                            <td colspan="2">Введен неверный ключ! Убедитесь что вы скопировали ключ
                                без лишних символов (пробелов и т.д.)
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
                <div class="wrapper-tab " id="con_settings">
                    <div class="utl_left_block">
                        <?php
                        $my_settings_page = new MySettingsPage();
                        $my_settings_page->page_init();
                        settings_fields('my_option_group');
                        do_settings_sections($my_settings_page->settings_page_name);
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
                                Для вставки в режиме визуального редактора достаточно вставить<b>
                                    <i>[uptolike]</i></b>.
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
                            <div class="utl_innertext"><a href="http://uptolike.ru">Uptolike.ru</a>
                                - конструктор социальных кнопок для вашего сайта с расширенным
                                функционалом.<br>
                                Служба поддержки: <a href="mailto:uptolikeshare@gmail.com">uptolikeshare@gmail.com</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php
}

usb_admin_page();
