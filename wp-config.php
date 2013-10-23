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
define('DB_NAME', 'ahealthy_survey');

/** MySQL database username */
define('DB_USER', 'ahealthy_yourock');

/** MySQL database password */
define('DB_PASSWORD', 'yourock123!@#');

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
define('AUTH_KEY',         'b$(rDCbxgwpc@{)&JqA7Zq$}za_xz6bp.tn0fL!|(1KT,!M+v,]bH7?uN/Wyd!sD');
define('SECURE_AUTH_KEY',  'MDN<8XvajvRKcHv$81vU?_V`6~U2sMsIg01w>i7;<Jz|b=F7DJ5?e5a|WKy,~_9<');
define('LOGGED_IN_KEY',    'Sna.GFF?KTtrn&CfiUBN3=,Mm}X;J~jCB0toIFy9wDGz`C1)#faXRBMBiT6hkd?X');
define('NONCE_KEY',        '(-}e]%zwhfxtaMV0/X:0`;eTrx#QqVRb|Q r|%Y2gMtPACNG7.FHPq  :[FooL1h');
define('AUTH_SALT',        '-CHMi{Gdn<N14pwv$qFDcf<vye1~quO7/XaKN|]!G`W>{IxZZf.33-|`$IU6C},M');
define('SECURE_AUTH_SALT', '44)/Oor(NV&:;~-HpGQ<Z0lDjb|zbw&se[43}?^q mu5lIzlPvfiw2GR$X5I=Lw!');
define('LOGGED_IN_SALT',   '^h]KSF:gH-Bx$k.v$C #UFPUB4>YY-BofktNqE:z#j;]KWx(WVmqkYit2(RvO}FT');
define('NONCE_SALT',       'vC&|,~4%$a^Ge4`}u0mcO@&JUA~Gw+01^HPXSW+m*(-dI[X?HuQt-H;oS3H0}Y]1');

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
