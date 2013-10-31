<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'moya');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'q|:H&/h9,hYa-q2jG9J>nwjfC@[`2n=J}L0g=*f^o}IZ7dy#6!mvmxC&`RTY?b;_');
define('SECURE_AUTH_KEY',  'Xi~g?Z5fr1u.g)hFfuc!^zXIm3DNtTGe_hhH Yv<5Kven[N`KZemIp7`, |%8-Rc');
define('LOGGED_IN_KEY',    '`UxCZqaH@zd#sgb@nb `E}Tq:!py5R0-p=9@S)2}qpe5keiSX~=#>UtT`Xc]&nPS');
define('NONCE_KEY',        '[cw1.H?{bI;$zGF8{m:uCQEPzIUXTl(m5@(NPRC)$rsgH]tO;v<vDDk+I*|Kx@w&');
define('AUTH_SALT',        'N#yKmWq|5?+NnuhC+Zpfw1,g+(:D6,$}Sjpig^Su.s(6:]2L9)Xb/{E]HIOxs`b}');
define('SECURE_AUTH_SALT', 'U7)f|/v-ztqWT`(<QXv{n^ddp#)kZ/wo09HS&|e=1O~m4_iAP$k1elK&z>*wLG)k');
define('LOGGED_IN_SALT',   't&<HJ^a$[d&LV?O 2Ol8;czP2?`EN{78afq[<04*{Z/.VTaj&gRevhCT::Q{G^lZ');
define('NONCE_SALT',       '4unrNEuof!r)vqyY$8%::xt0/?5+xIQ%)qCMA#9k!O#C-Y*N!/`Si4JC ]=;6Z/l');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
