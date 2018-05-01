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
.tab-content-table tr td, .tab-content-table tr th {
    padding-top: 3px;    
    padding-bottom: 3px;    
}
.wrap fieldset {
    padding: 10px;
    border: 1px solid #cacaca;
    margin-top: 10px;
}
.wrap fieldset legend {
    font-weight: bold;
}
</style>
<script>
    jQuery(document).ready(function($) {
        $('.nav-tab-wrapper a').click(function(){
            $('.nav-tab-wrapper a').attr('class', 'nav-tab');
            $('.tab-content').hide();
            $('#div_' + $(this).attr('id')).show();
            $(this).attr('class', 'nav-tab nav-tab-active');
            $('#tab-active').val($(this).attr('id').replace('tab', ''));
        });
        $('#tab1').trigger('click');
    });
</script>
<div class="wrap">
<form method="post">
<div id="icon-options-general" class="icon32"></div><h2>WPGrabber - Настройки - 
    <a href="http://top-bit.ru/product/services/ustanovka-avtonapolneniya" target="_blank" title="Заказать платную настройку лент"><b>Заказать настройку ленты</b></a></h2>
<h2 class="nav-tab-wrapper">
    <a href="#tab1" id="tab1" class="nav-tab<?php echo $tab == 1 ? ' nav-tab-active' : ''; ?>">Основные</a>
    <a href="#tab2" id="tab2" class="nav-tab<?php echo $tab == 3 ? ' nav-tab-active' : ''; ?>">Картинки</a>
    <a href="#tab3" id="tab3" class="nav-tab<?php echo $tab == 4 ? ' nav-tab-active' : ''; ?>">Переводы</a>
    <a href="#tab4" id="tab4" class="nav-tab<?php echo $tab == 5 ? ' nav-tab-active' : ''; ?>">Автообновление</a>
    <a href="#tab5" id="tab5" class="nav-tab<?php echo $tab == 6 ? ' nav-tab-active' : ''; ?>">Дополнительно</a>
</h2>

<div class="tab-content" id="div_tab1"<?php echo $tab == 1 ? ' style="display: block;"' : ''; ?>>
    <fieldset>
        <legend>Настройка сетевых запросов</legend>
        <table class="tab-content-table">
        <tr>
            <td width="395">Для запросов использовать метод</td>
            <td><?php echo WPGHelper::selectList('options[getContentMethod]', array('0'=>'CURL','1'=>'file_get_contents','2'=>'fsockopen'), get_option('wpg_' .'getContentMethod'), 1); ?></td> 
        </tr>
        <tr>
            <td width="395">Для скачивания файлов (картинок) использовать метод</td>
            <td><?php echo WPGHelper::selectList('options[saveFileUrlMethod]', array('0'=>'copy','1'=>'CURL','2'=>'file_get_contents + file_put_contents'), get_option('wpg_' .'saveFileUrlMethod'), 1); ?></td> 
        </tr>
        <tr>
            <td>Включить обработку редиректов <br></td>
            <td><?php echo WPGHelper::yesNoRadioList('options[curlRedirectOn]', get_option('wpg_' .'curlRedirectOn')); ?>&nbsp;&nbsp;&nbsp;&nbsp;<i>(CURL-опция: CURLOPT_FOLLOWLOCATION)</i></td>
        </tr>
        <tr>
            <td>Максимальное время ожидания ответа от сервера</td>
            <td><input type="text" size="5" name="options[requestTime]" value="<?php echo get_option('wpg_' .'requestTime'); ?>" /> <i>(0 - неограничено, пустое значение - по умолчанию)</i></td>
        </tr>
        </table>
    </fieldset>
     <fieldset>
        <legend>Настройка каталогов</legend>
        <table class="tab-content-table">
        <tr>
            <td>Каталог временных файлов</td>
            <td><input type="text" name="options[testPath]" value="<?php echo get_option('wpg_' .'testPath'); ?>" size="60" /></td>
        </tr>
        </table>
     </fieldset>
     
    <fieldset>
        <legend>Настройка процесса импорта</legend>
        <table class="tab-content-table">
        <tr>
            <td width="395">Время выполнение основного процесса импорта в секундах</td>
            <td><input type="text" size="5" name="options[phpTimeLimit]" value="<?php echo get_option('wpg_' . 'phpTimeLimit'); ?>" /> <i>(0 - неограничено, пустое значение - по умолчанию: 30 сек.)</i></td>
        </tr>
        <tr>
            <td>Разбивать процесс импорта на части</td>
            <td><?php echo WPGHelper::yesNoRadioList('options[useTransactionModel]', get_option('wpg_' .'useTransactionModel')); ?></td>
        </tr>
        </table>
    </fieldset>
</div>

<!-- Картинки -->
<div class="tab-content" id="div_tab2"<?php echo $tab == 2 ? ' style="display: block;"' : ''; ?>>
  <table class="tab-content-table">
  <tr>
        <td>Каталог хранения картинок из постов</td>
        <td><input type="text" name="options[imgPath]" value="<?php echo get_option('wpg_' .'imgPath'); ?>" size="60" /></td>
  </tr>
  </table>
</div>

<!-- Переводы -->
<div class="tab-content" id="div_tab3"<?php echo $tab == 3 ? ' style="display: block;"' : ''; ?>>
  <fieldset>
    <legend>Яндекс.Перевод</legend>
      <table class="tab-content-table" width="95%">
        <tr>
          <td valign="top">API-ключ Яндекс (по умолчанию)</td>
          <td><textarea rows="2" style="width:100%" name="options[yandexApiKey]"><?php echo WPGTools::esc(get_option('wpg_'.'yandexApiKey')); ?></textarea> 
          <i>
            <a href="https://tech.yandex.ru/keys/get/?service=trnsl" target="_blank">Получить бесплатный API-ключ Яндекс</a><br>
            <a href="/wp-admin/admin.php?page=wpgrabber-settings&translate_yandex=update" style="font-weight: bold;"><?php echo get_option("wpg_yandexTransLangs") ? 'Обновить базу переводов с сервиса Яндекс.Перевод' : '<font color="red">Загрузить базу переводов с сервиса Яндекс.Перевод</font>'; ?></a>  
          </i></td>
        </tr>
        <?php /*
        <tr>
          <td width="395">API-ключ сервиса Bing Переводчик</td>
          <td><input size="100" type="text" name="options[bingApiKey]" value="<?php echo WPGTools::esc(get_option('wpg_'.'bingApiKey')); ?>" /></td>
        </tr>
        */ ?>
      </table>
  </fieldset>
</div>

<!-- Автообновление -->
<div class="tab-content" id="div_tab4"<?php echo $tab == 4 ? ' style="display: block;"' : ''; ?>>
    <fieldset>
        <table class="tab-content-table">
        <tr>
            <td width="290">Включить автообновление лент</td>
            <td><?php echo WPGHelper::yesNoRadioList('options[cronOn]', get_option('wpg_' .'cronOn')); ?></td>
        </tr>
        <tr>
            <td width="290"><b>Автоматически отключать ленты</b> с ошибками и ленты которые не успевают обновляться?</b></td>
            <td><?php echo WPGHelper::yesNoRadioList('options[offFeedsModeOn]', get_option('wpg_' .'offFeedsModeOn')); ?></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>Для ручного запуска и проверки скрипта автообновления лент перейдите по адресу: <a target="_blank" href="<?php echo home_url('/?wpgrun=1'); ?>"><?php echo home_url('/?wpgrun=1'); ?></a></td>
        </tr>
        <tr>
            <td valign="top">Метод обновления</td>
            <td><?php echo WPGHelper::selectList('options[methodUpdate]', array(0=>'1. WordPress CRON через сайт (зависит от посещаемости сайта!)',1=>'2. Настроенное CRON-задание на веб-сервере (хостинге)'), get_option('wpg_' .'methodUpdate'), 1, 'onchange="if (this.value==1){document.getElementById(\'div-methodUpdate\').style.display=\'\';}else{document.getElementById(\'div-methodUpdate\').style.display=\'none\';}"'); ?>
            <div style="color: #9D0000; font-style: italic; padding-top: 5px;" id="div-methodUpdate"<?php echo get_option('wpg_' .'methodUpdate') ? '' : ' style="display:none;"';?>>
            <b>Внимание!</b> Для работы данного метода обновления Вам потребуется настроить CRON-задание на Вашем сервере (хостинге) <a href="http://top-bit.ru" target="_blank">( подробнее )</a>
            </div>
            </td>
        </tr>
        <tr>
            <td>Порядок и периоды обновления лент</td>
            <td><?php echo WPGHelper::selectList('options[methodUpdateSort]', array('0'=>'по порядку через заданный интервал','1'=>'учитывая индивидуальные периоды каждой ленты'), get_option('wpg_' .'methodUpdateSort'), 1, 'onchange="if (this.value==1){document.getElementById(\'tr-cronInterval\').style.display=\'none\';}else{document.getElementById(\'tr-cronInterval\').style.display=\'\';}"'); ?></td>
        </tr>
        <tr id="tr-cronInterval"<?php echo get_option('wpg_' .'methodUpdateSort') ? ' style="display:none;"' : '';?>>
            <td>Интервал запуска процессов обновления / периоды обновления (мин.)</td>
            <td><input type="text" size="5" name="options[cronInterval]" value="<?php echo get_option('wpg_' .'cronInterval'); ?>" /> <i>(пустое значение будет заменено на 60 минут)</i></td>
        </tr>
        <tr>
            <td>Кол-во лент обновляемых за один процесс автообновления</td>
            <td><?php echo WPGHelper::selectList('options[countUpdateFeeds]', array(1,2,3,4,5), get_option('wpg_' .'countUpdateFeeds')); ?> 
            <i>(оптимальным является не более 1-2 лент, для ненагруженных лент можно выбрать 5)</i></td>
        </tr>
        </table>
    </fieldset>
</div>

<!-- Дополнительно -->
<div class="tab-content" id="div_tab5"<?php echo $tab == 5 ? ' style="display: block;"' : ''; ?>>
    <fieldset>
        <legend>Логирование ошибок плагина</legend>
        <table class="tab-content-table">
        <tr>
            <td width="395">Включить логирование ошибок</td>
            <td><?php echo WPGHelper::yesNoRadioList('options[logErrors]', get_option('wpg_' .'logErrors')); ?></td>
        </tr>
        <?php /*
        <tr>
            <td width="395">Автоматически отправлять письма с ошибками на адрес службы технической поддержки</td>
            <td><?php echo WPGHelper::yesNoRadioList('options[sendErrors]', get_option('wpg_' .'sendErrors')); ?></td>
        </tr>
        */ ?>
        <tr>
          <td colspan="2">
            <a href="?page=wpgrabber-settings&wpgrabberGetErrorLogFile" target="_blank">посмотреть лог-файл ошибок</a>
          </td>
        </tr>
        </table>
    </fieldset>
    <?php if(wpgIsStandard()): ?>
      <fieldset>
        <legend>Настройки сервиса Synonyma.ru</legend>
        <table class="tab-content-table">
          <tr>
            <tr>
              <td width="395">Логин</td>
              <td>
                <input type="text" name="options[synonymaLogin]" value="<?php echo WPGTools::esc(get_option('wpg_'.'synonymaLogin')); ?>" />
              </td>
            </tr>
            <tr>
              <td>Ключ</td>
              <td>
                <input type="text" size="50" name="options[synonymaHash]" value="<?php echo WPGTools::esc(get_option('wpg_'.'synonymaHash')); ?>" />
              </td>
            </tr>
          </tr>
        </table>
      </fieldset>
    <?php endif; ?>
</div>
<?php submit_button('Сохранить изменения','primary','saveButton'); ?>
</form>
</div>