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
define('WP_CACHE', true);
define( 'WPCACHEHOME', __DIR__ . '/wp-content/plugins/wp-super-cache/' );
if ( isset( $_SERVER['HTTP_HOST'] ) ) {
	$jcci_scheme = ( ! empty( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] !== 'off' ) ? 'https' : 'http';
	define( 'WP_HOME', $jcci_scheme . '://' . $_SERVER['HTTP_HOST'] );
	define( 'WP_SITEURL', $jcci_scheme . '://' . $_SERVER['HTTP_HOST'] );
}
define( 'DB_NAME', 'jcci' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         '3H)!{s(ZjhaOvLaPmj$g:{7},F ~(j_CdPt0,!~R26^W&%<Ety:61>(<CJ_*zZh=' );
define( 'SECURE_AUTH_KEY',  '+EJ9|:lL]{-MC $t`0&YYJ}g_[p)|ZzU;ys#I,bFVX*xo96y{nRZEF`Fs9{MmC{=' );
define( 'LOGGED_IN_KEY',    'vz%MDCx3?-3#6Ekin_>z07~3{I.v@ZP+B#ogXtS8OZe7.P$5T/f4;_mm>[fkmP_)' );
define( 'NONCE_KEY',        'q<_=Uv%NmHO+h5<ht#JUAtHK1%li~<xB<NF^aoO^$.$nwm/Q69<*3ua6XX=kW2v-' );
define( 'AUTH_SALT',        '`r:ci^tA49/?{B{e6qmHiNYy(kScP>!SfQeJt#_A CR188c?eE A]+`Zi}FggJa#' );
define( 'SECURE_AUTH_SALT', 'di05}M(3GF~5PFcRSl-4J(/y6v)iswK+n{.g;I DMutBt|~kP/kk7#$r`L6YN8:.' );
define( 'LOGGED_IN_SALT',   'GDim69wh50& G!?&fjl#Q{r|(R6xfQ1fzDDce!eu_`t1LPn?aH1`WfO__kwXQv;%' );
define( 'NONCE_SALT',       '[Q7t#U]Y(A:!5hh)MgE![=$`)Pdv++,Usi;gEl)3WYl2v!V-Cau&-OJH9)d>Ud#x' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', true );

define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );


/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
