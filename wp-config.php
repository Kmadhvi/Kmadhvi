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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'demo_site' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

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
define('AUTH_KEY',         'kq*{~6=I1TSrK%|#N&0Ski|Fv5H|X*-2,|eU.%Dg6fX71Lr6N[Bh+_xY.8pF+JS4');
define('SECURE_AUTH_KEY',  '9G8-|_I9eJ=EdxV{Q@j3l.u$vvhPh210cxm$t4OM^->X0,qw^M-ZnO8(>%JuOK7,');
define('LOGGED_IN_KEY',    'EDkegKt^(#3Ltz/,x+afv-yW[FZJwG{x[z@CxJz0Wa[a}iy_#~dj($L1po>yxkyM');
define('NONCE_KEY',        '@rBA{Gu&}7+wc$Ff&&P|FvZm#Z(-Nc^O?ck.7|IYFMVMg/yBT(jiuK# g szA8rG');
define('AUTH_SALT',        ' w,rb*7Qd}&gqO#58:*rB+HN1j7FgWUW&-*qWoX<6J@&[m-F~I?!_|L5:~j;Rf[~');
define('SECURE_AUTH_SALT', '&%+6!PAGj|$UPKj9DW_>(^N@}+]TAm`@Vwp}0EjN~1?~04:b|/lD+=6%s<.J(H]V');
define('LOGGED_IN_SALT',   'R]0@cdphATQ6,lmC_^qRV/*C~pu &J(zYa#G_{~@np}-k|C$9gtT]#zc#4!+3i#]');
define('NONCE_SALT',       's{L+-|hZg)|b6i+;0Y c<OrAqmMQ$S2u<Yx0@?g -:EKT/a%xeT- W0U8^-Ol5$>');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'Mhgfdgf_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', true );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
