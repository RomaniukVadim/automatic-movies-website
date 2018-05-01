<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('DB_NAME', 'u761527634_base');

/** Имя пользователя MySQL */
define('DB_USER', 'u761527634_base');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', '6DaNtIyqYi');

/** Имя сервера MySQL */
define('DB_HOST', 'localhost');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8mb4');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '*::BJro.]oNXFLwn;1EI|=_M4.ni|<w8MWO!2V&SYTK8[ghPI9Nx{38Uc.D*(LlL');
define('SECURE_AUTH_KEY',  '% -norcuW-P=u`7W]YPLFe_#bC~vF*9C,~#^k1:Su05dtx>`x5rZjC_=PU!(<^n9');
define('LOGGED_IN_KEY',    '}3Dx_G]J-{M_If1;3_?0dEOto4g_IS~$3&*Ng?n8/MDNkjYnQ5(alV5L0J>%<4DQ');
define('NONCE_KEY',        'B669xGG&-qf:hBw*uzpVC)Xv5[7Q/.jH%)]2pEFTWd[Jg)*:2Vg2)=rvzzN?M7? ');
define('AUTH_SALT',        'KPk|--(=VfU,d2K#l8_>14 E_mLta[#vPgISKP#6Z@b<Ap&Ly/LfSZHx(/C^VYm4');
define('SECURE_AUTH_SALT', '>~e>*oy`]LESD!)A>k&qMQl06oS}}`v]fE+v}V}c>4pf7kyI8TM Y5 gI!sK$ei7');
define('LOGGED_IN_SALT',   ',FmV7g/4`?Va}Pj9bx$f{{1*T`51,=cM/mL^}@m]v^WY-VETm;%onXEhxji_jAX|');
define('NONCE_SALT',       'c~~|9a473Hnj%h]S`xHWn,pYcTc_O8th)KW[Pi.a 2x~F/1:eIxxy:j(:>|k9:?D');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 * 
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');
