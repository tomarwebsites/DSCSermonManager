<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'TEST');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         '?lm-Y*ArVkx)^Mxeo^rx*XM}7$3xoOe0L0~+ FxDy)H!=Z<;Nlo`mrHKDSx^Icq`');
define('SECURE_AUTH_KEY',  ',w]wea9A7Y__!@-Sz,P74B_awPmy:*JQjy$[UDID#x+|L!I%^kF8U&88uh{UyLOR');
define('LOGGED_IN_KEY',    'Q/@=63A6<)lU{O=[w!r6k90pujMXA-]s^=vA#G41BZEfgzLd+f(ZM_n>ERMI3ke ');
define('NONCE_KEY',        'L3Eqa}fK>!B7,5t=OL{,GUO>W-_16Ns$S,;(ziN}ur5!EKx?yPsEp,`#6?{G=mVU');
define('AUTH_SALT',        'gHIoB7o`.s7/cv<xp%Oq~8wX{~6; PLp=@)$Xb11H9P|8`S4MSX?G.8Gjp2G&X6e');
define('SECURE_AUTH_SALT', '#[,to,O11L.w+@EG9iWelt5IM`ES=vY@$M|me!cps&lygcaMPmk.`>1?o/oC,B4-');
define('LOGGED_IN_SALT',   'IT<t7[(ylREym ]j4X_^5n`B$Q$e1x09fa^%nx-a/s{f?,?9l}H8VlmIX<!{Uw;|');
define('NONCE_SALT',       '!s =>S>r<H,(vurwA%)3Q@w -B;?SQ5Wy]Q.aZ=z%-L)?0:+pQ{i{E0K=M^rp=n,');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'dsc_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
