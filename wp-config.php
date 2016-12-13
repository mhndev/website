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
define('DB_NAME', 'mhndevco_uchiha');

/** MySQL database username */
define('DB_USER', 'mhndevco_madara');

/** MySQL database password */
define('DB_PASSWORD', 'a3eilm2s2y20#');

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
define('AUTH_KEY',         'T6+Z;{l(;H5(i,TmNL|k#gz_cA(2B<haptD1WE17y)<Mzm/j1.oc+J;f;O(}PXMg');
define('SECURE_AUTH_KEY',  'BLzBN<Oy0X5z32< _{{$7Vgk4Y48+G-gibs|c#U8*6Vkt?DS-fH_OmY<c2J3(#JN');
define('LOGGED_IN_KEY',    'g`TZR$PG>`odEPP=EFD#Owz@yDAuuPzioI{FXit[zc,TXzZ_ V<]K[1{fvGY+qIn');
define('NONCE_KEY',        ',(b*<.hP.9h^{UFej7 &g<&Q2S37Ta_Rgfk[AP YZ`@g^Bl_WyT8Gc<#9*/v/+f-');
define('AUTH_SALT',        '!t&iSk0pa{h(^qe3:$wl[GSIG9)pF3?=9/%VLOg@vlm8eap**+R/D_=0Z8Ib3oMo');
define('SECURE_AUTH_SALT', ':C4m,C =$Urr[/-VEP0%%uXGR#O1O]{C2.*U7YCY|ufZ%/Qd+I6`R4NNNHS4=]=J');
define('LOGGED_IN_SALT',   'G/XcefE9`7rNOlB=;v[-3WXuv}R:>QJU<#PsbO6Tx>5 NXl&2c}_V;aDiu!A+l)J');
define('NONCE_SALT',       'Wv&cOd8%SVx/,p:$x3-+1i2x0ORs)IH$fu3:^6HPCW!I^zL@B}6=^%sdrkie~?Z-');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'sakura_';

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
