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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          'G<g%Mg>kw6hp5vTq+mVtKnBw~n_|%y#^Rn&IVYBU<YaiLXB<DQ[h:SmtO3aMhP)5' );
define( 'SECURE_AUTH_KEY',   ':TzaS| [a%eg8w5`P|8xG9-Fl8N6JLP|vFv4IYDY19FDle&s8hFJWqz~04t(pcMM' );
define( 'LOGGED_IN_KEY',     'B(>%f=lQ%`{21;Rtd>I#Y@vfT;89nG]Q (Kn]5wPwKkErI.%#3P&.AJRcAN}F08x' );
define( 'NONCE_KEY',         'lF2=A<;Du}.dN5Q6}/TZg^?/VD*3,?f3.G}o/XO=l`wUk=Z1EB?E2&@|%|FMlVr&' );
define( 'AUTH_SALT',         '.(I(vp*C3<Q?v2tvZ#)63If22tg8LbO0U+qwFPR{HNZutFbH-K.}1!}2-zr<]NxM' );
define( 'SECURE_AUTH_SALT',  '$-@c5_mU~%(>5ge>UmkK|qC<##)n{{w#WE].(bs7C&*V)qF*q)jg?jAon7BTFJB(' );
define( 'LOGGED_IN_SALT',    '&lOcz=?p5SFCSaOMbH<c0^9,BBSjsO >|(2yhCJq:[-cz3{%lQy)R|rIzlsAe5sK' );
define( 'NONCE_SALT',        '}n^<q~?/hBl^GOYM<#HG&!i/)TVr>~szGaW=([</JVZKGTa9)g5r%QtltSsBc V;' );
define( 'WP_CACHE_KEY_SALT', ']`q/^bi5Ogh;d&*y*(C)fm6+/q?+1PB728BABQo?QqI#(`/mr-pne GF2P*w8&p1' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
