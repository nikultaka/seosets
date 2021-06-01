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
define( 'DB_NAME', 'clone' );         

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'Testing@123');  

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );   

define('FS_METHOD','direct');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'w{cOeQkjT33thatwLGs Ve:`BEij`Z8H$IH?sF`dY7EbA&7Bz/.WyOg1o4`)=(T(' );
define( 'SECURE_AUTH_KEY',  '#+/-kl2{sN-K(O@jb07]0!|Lb|@!DroCVY2FXBOJeQ}+9@2IKyZTY[Ah9p<~lUnP' );
define( 'LOGGED_IN_KEY',    'v@]PAyfa~+?UK:Ztv7cxjgnkD$Uvj[J>ElU_*H,lR-kzGd8s<w2z&:F.`v>Gd&tm' );
define( 'NONCE_KEY',        '*B1i?K>,=#Y;qgARhEP.sD.C9|U>&(EQB/GyfYFT+[Kog$eJ.uc$F:zz*LJNhA0h' );
define( 'AUTH_SALT',        '&fi6*z^y< 1YvX!D2q1F!8:N+:RSP9kN%(bd]@t3eq:U{#rO.Spb9bwg@2j`/R/U' );
define( 'SECURE_AUTH_SALT', '5fO]p6)fVd~;k2{Kp78Q)8nEj#*<}0dO`z#S}+ _V1n]cSpJNzjN^*%U//A&yA*2' );
define( 'LOGGED_IN_SALT',   '@oZr[o*x^8}wk{F+0qB.VBX0AV17Hy8X?1UsvD~XwGmz^T1X`z|>c~5;Ay%Kcy(O' );
define( 'NONCE_SALT',       'F}]jV&p4&6~lhan{[(X7bw`9)^*qG`i{754JW9UjLHX7VbHH>P=]a.Q@uN?gif/{' );

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
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_DISPLAY', true );
define( 'SCRIPT_DEBUG', true );
define( 'WP_DEBUG_LOG', true );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
