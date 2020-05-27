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
if(!$_SERVER["ENV"]){
    define( 'DB_NAME', '' );
    define( 'DB_USER', 'root' );
    define( 'DB_PASSWORD', 'root' );
    define( 'DB_HOST', 'localhost' );
}
else{
echo('<!-- stage-->');
    define('DB_NAME', $_SERVER["DB_NAME"]);
    define('DB_USER', $_SERVER["DB_USER"]);
    define('DB_PASSWORD', $_SERVER["DB_PASSWORD"]);
    define('DB_HOST', $_SERVER["DB_HOST"]);
    define('WP_HOME', $_SERVER["WP_HOME"]);
    define('WP_SITEURL', $_SERVER["WP_SITEURL"]);
}

// /** The name of the database for WordPress */
// define( 'DB_NAME', 'mazola' );

// /** MySQL database username */
// define( 'DB_USER', 'root' );

// /** MySQL database password */
// define( 'DB_PASSWORD', 'root' );

// /** MySQL hostname */
// define( 'DB_HOST', 'localhost' );



/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '3klFQK<wEED:? HeZ9<NE`L&P6Awm=jN+*-:#c59$/PBe%Xrj1C|;[&^zFyzHU,T');
define('SECURE_AUTH_KEY',  'ok|3;<1p<>aK+Sf+-T0-fCIKL<C@$tL!o7Rre+Lq+km$vY?jCv|)u6+];3;3)vl<');
define('LOGGED_IN_KEY',    't27<53QS4(0w/rV6umNrM$%KWPHo8cL*ZN<] t3c*>v[pa%P*>DVQ]| b-j 7kr<');
define('NONCE_KEY',        'Rq5d 4aS+-*?NV<D-+-WgNG5g|Vm%xOT*cZWhbC`og21t<6y9K]Q) hf%gc*PLc6');
define('AUTH_SALT',        '7$Q=`LlGzR%?|qZ<b=u%v:j9.nGIM@-S8`%ay?+]Ex+;N3,(kNVRNcM|l5Sr J]?');
define('SECURE_AUTH_SALT', 'C}C@R&qts{S|YT=Ox9rp*2P>`ifE=0nMn8G-|&HcX`gkaHug/8758.~%H:+&`x} ');
define('LOGGED_IN_SALT',   'h6*KQ;Y]v|k9,{R@|y,lgNsqKCOP@-Ye>Pi{8A*Ee,iK*c%:PE=D$O)gE|v.SN/A');
define('NONCE_SALT',       'NN7/ZKN05-o>8mnKF<8<(Y+{=+<?fXlZ ^prh3@R%y76[P`%r i`Xc{X/k,K7:3I');


if($_SERVER["ENV"] == "prod"){
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
    define( 'WP_HOME', '');
    define( 'WP_SITEURL', '');
}


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
define( 'WP_DEBUG', false );
define( 'WP_ALLOW_MULTISITE', true );
define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', false);
define('DOMAIN_CURRENT_SITE', 'farmerjohn-dev.eba-54m3ysmu.us-east-1.elasticbeanstalk.com');
define('PATH_CURRENT_SITE', '/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );

