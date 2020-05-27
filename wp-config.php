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
//define( 'DB_NAME', 'lalafoods' );
//
///** MySQL database username */
//define( 'DB_USER', 'lalafoods@1041092glmysql01' );
//
///** MySQL database password */
//define( 'DB_PASSWORD', 'l4l4Fo06s+' );
//
///** MySQL hostname */
//define( 'DB_HOST', '1041092glmysql01.mysql.database.azure.com' );
//
/** The name of the database for WordPress */
//define( 'DB_NAME', 'farmerjohn' );
//// /** MySQL database username */
//define( 'DB_USER', 'root' );
//// /** MySQL database password */
//define( 'DB_PASSWORD', 'root' );
//// /** MySQL hostname */
//define( 'DB_HOST', 'localhost' );
///** Database Charset to use in creating database tables. */
//define( 'DB_CHARSET', 'utf8mb4' );
///** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

if( !$_SERVER["ENV"]){
    define('DB_HOST', 'localhost:3306');
    define('DB_NAME', 'farmerjohn_latest');
    define('DB_USER', 'wordpresstest');
    define('DB_PASSWORD', 'wordpresstest');
    //define('WP_DEBUG', true);

    define( 'WP_HOME', 'http://localhost:150/');
    define( 'WP_SITEURL', 'http://localhost:150');
}
elseif($_SERVER["ENV"] == 'stage') {
	define('DB_NAME', $_SERVER["DB_NAME"]);
	define('DB_USER', $_SERVER["DB_USER"]);
	define('DB_PASSWORD', $_SERVER["DB_PASSWORD"]);
	define('DB_HOST', $_SERVER["DB_HOST"]);
	define( 'WP_HOME', $_SERVER["WP_HOME"]);
	define( 'WP_SITEURL', $_SERVER["WP_SITEURL"]);
}
else{
	//Live server on Azure
	//Begin Really Simple SSL Load balancing fix
	if ((isset($_ENV["HTTPS"]) && ("on" == $_ENV["HTTPS"]))
	|| (isset($_SERVER["HTTP_X_FORWARDED_SSL"]) && (strpos($_SERVER["HTTP_X_FORWARDED_SSL"], "1") !== false))
	|| (isset($_SERVER["HTTP_X_FORWARDED_SSL"]) && (strpos($_SERVER["HTTP_X_FORWARDED_SSL"], "on") !== false))
	|| (isset($_SERVER["HTTP_CF_VISITOR"]) && (strpos($_SERVER["HTTP_CF_VISITOR"], "https") !== false))
	|| (isset($_SERVER["HTTP_CLOUDFRONT_FORWARDED_PROTO"]) && (strpos($_SERVER["HTTP_CLOUDFRONT_FORWARDED_PROTO"], "https") !== false))
	|| (isset($_SERVER["HTTP_X_FORWARDED_PROTO"]) && (strpos($_SERVER["HTTP_X_FORWARDED_PROTO"], "https") !== false))
	|| (isset($_SERVER["HTTP_X_PROTO"]) && (strpos($_SERVER["HTTP_X_PROTO"], "SSL") !== false))
	) {
	$_SERVER["HTTPS"] = "on";
	}
	define('DB_NAME', $_SERVER["DB_NAME"]);
	define('DB_USER', $_SERVER["DB_USER"]);
	define('DB_PASSWORD', $_SERVER["DB_PASSWORD"]);
	define('DB_HOST', $_SERVER["DB_HOST"]);
	define( 'WP_HOME', $_SERVER["WP_HOME"]);
	define( 'WP_SITEURL', $_SERVER["WP_SITEURL"]);

}


/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '?;RZMJ48!&g/6y#N(1Na[8/q(87SXLuW?KZ.}6mM#dsPy$98;O,Bz`~bW!o_PD>0' );
define( 'SECURE_AUTH_KEY',  's)0-M8_Lq-%R`E&N#RU#cMFGrbSm}@jG2Q#*GskI?9]n>KP2B^Y%31(W2:B*s(zj' );
define( 'LOGGED_IN_KEY',    'iZqnLCe%izT,:OWj/bKd:k[R<XL4Tb9f|)4OGSYqU8+xigmXFz3xKL:,8Av*ybBX' );
define( 'NONCE_KEY',        '9F}}6+su `eYlO);B)9MtY<n(s5fk{7VA2N79HEr4p8G<d{37_<DHqqM>mJLJ_wj' );
define( 'AUTH_SALT',        '_A,nb/N(z$K=TGdYaDCc^fv-3S.P-T[@3pcsyD0,0w6#l=neB`t0<vTLw~e(6B(y' );
define( 'SECURE_AUTH_SALT', 'D,5(`5dF1WaSh~fOi(yD<)*OD<[M@NY/bF:fTp_VlR1CIxjUHQ%4Gu;S_ca:J9{D' );
define( 'LOGGED_IN_SALT',   'GJiB?tM,pKifMsV~-u:_^g_$l)75]mX0thK2$_v~zA-5|)AR&?^gzO#8^(-JISjz' );
define( 'NONCE_SALT',       '++GXo(i;bV|(O{jNZOEy0(5.8-y9&qa+J9,0YbL(2jGM}ty27P&{m }Ap;u899dZ' );
/**#@-*/
/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'bsgdv_';
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
define('DISALLOW_FILE_MODS',true);
// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
// !!!!!!!! THESE 2 LINES BELOW CAUSE LOCALHOST TO REDIRECT TO LIVE SITE, COMMENT TO FIX !!!!!!!!!
// define('SUBDOMAIN_INSTALL', false);
/* define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', false);
define('DOMAIN_CURRENT_SITE', 'localhost:150');
define('PATH_CURRENT_SITE', '/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);
 */
// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
/* define('WP_HOME','localhost:8888');
define('WP_SITEURL','localhost:8888');
define('DOMAIN_CURRENT_SITE', 'localhost:8888');
define('PATH_CURRENT_SITE', '/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1); */
/* That's all, stop editing! Happy blogging. */
/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
    define('ABSPATH', dirname(__FILE__) . '/');
/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
/** Sets up 'direct' method for wordpress, auto update without FTP */
define('FS_METHOD','direct');
//Disable File Edits
define('DISALLOW_FILE_EDIT', false);
// /* Multisite */
define( 'WP_ALLOW_MULTISITE', true );