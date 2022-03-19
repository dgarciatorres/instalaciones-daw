<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** Database username */
define( 'DB_USER', 'user' );

/** Database password */
define( 'DB_PASSWORD', 'password' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '(<b`j`cJ})$cOR|9G>[_`:Z$s{&N&quSV)97CGoAF8sTrtpO5S^:tz>GFmjT8B^<' );
define( 'SECURE_AUTH_KEY',  'q53Pn AyF}AZz}40aQFY5M fajzp:)U@KjnP%e!$qeZc<Xh&l^!7Kalf<W{bsbR3' );
define( 'LOGGED_IN_KEY',    '-YpFZHC;[R;/5eW/~o4%3X2YN#,uMqUC&>M[j.N&qv?fvoEM}K8D16t1-eIge`^x' );
define( 'NONCE_KEY',        '^)nlecX[rzD.4=/u%>3jWDbNz%hE8S?V[2Mub )EF/^foDh37Mh@4rxhsH=WF:@?' );
define( 'AUTH_SALT',        '1:,sMHf7A(z?;~Xh,$R#,K81eIR[L.nq}gc$]YsGawyRZVfu0=peH/AflHP`sfEq' );
define( 'SECURE_AUTH_SALT', 'j&wdt)e290wrCie_Q6knmlW/j+ ?buzkJWuVJcW`w]jutU`vUIq6)Jr6EgXDi)q_' );
define( 'LOGGED_IN_SALT',   'NO=l:dW[P$[_]nWM}v]Q1%G0M4I0CsC_;JH<Q$3EOz.?Yim%K3w<@}?C;E#yG|iW' );
define( 'NONCE_SALT',       'c$P)y^QcPVC0Dj9a+9-bJzVlP$gbnh(*nZ,Xb*!aSgPjH(Mu(q7*+DDG(#?xQ21V' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
