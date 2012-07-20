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
define('DB_NAME', 'blogtest');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         'YzlapttNXe+2:-7|yUKYv+.hUxZVaF^ZX; vL`2`p/1}7$ue=bzwcFu09Fd)nEdR');
define('SECURE_AUTH_KEY',  '7d~sUG*!@>:o8< K?Q<bg8m$&|%-)d40z[*ig4X~Wowcw@oI$,jK.=+Z(*ff8w]D');
define('LOGGED_IN_KEY',    '!r@UB.SVn~;+`n$AF?>M;u6dZ_v+YI0|DG6B5OsMFtY|e7LQzuA0u^4Muf-SLi-t');
define('NONCE_KEY',        'UoqdGE>k(u3TY#SiZ_FQc| cd;LiG]_yGt) #%.7}>e`gS<x2$-t_bcks+J7[Cfi');
define('AUTH_SALT',        '@EyKTX&(+s!D%QZ(GG^,Fx]hhI?/)R5jJTg~rGVS(:*#]$p+-=&;a4]tz-BA3N$ ');
define('SECURE_AUTH_SALT', 'C9r9KdhZ>|[B}`%S!7+mYA^0IH(qY{W=kOI&M`- A/MP+_sMQb-o&e>*VC:XPxU%');
define('LOGGED_IN_SALT',   'bWRJ%:;-}A7<RpXz5LF<AJyMyS# W#S|<+pDF9op;O;ZtY9z&K&;<{|0Zdx;fhU{');
define('NONCE_SALT',       '^u/6X{Te_,*1=@%|{Nb= 0x<LD]N:koTz57iGvK?M^Nw8!NVX-Ju[d]K;Kp@&1$3');

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
