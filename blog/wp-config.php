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
define( 'DB_NAME', 'u995723016_tmr_867345' );

/** Database username */
define( 'DB_USER', 'u995723016_root' );

/** Database password */
define( 'DB_PASSWORD', 'Juanchodavid.123' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1' );

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
define( 'AUTH_KEY',         'FBP4{Aa`?w}K*m(?u7ik)HT|)#`lUIg{,F2Jly#M5R&@VJf0>R^0YW_3eWa~,VyK' );
define( 'SECURE_AUTH_KEY',  '6Rwj[Tc9NFVP$Q9^$Z$IZBaqlbvJc%QG6?etT6f^wYI!Eo_=HEg1Fl4cN`~MYr= ' );
define( 'LOGGED_IN_KEY',    '/rUpc5z:gVTpg0L07M$qC-h}{KnnRts0Tq>@mCrSVM5eH1KKAhvqLC+-DG:p._3:' );
define( 'NONCE_KEY',        'Qwa7Ka;N>N=~p64DA7?}@2Cmiusgb62c/PJQy%5u<YeCesxMSXARz`&?(ajOXtCl' );
define( 'AUTH_SALT',        'UiSA+-d7N(YG/P;{Th4-fG8<<D*hs80x0.7KQ,j5S8I{6?ekVaN1SgDs]&n~Q*XW' );
define( 'SECURE_AUTH_SALT', '5td8#p`BMj[}EHpsC%2@Qg-aY[!P+TsqRJ#/1I}`!f=WuP1XZ~NzTHTr4T7yEz^2' );
define( 'LOGGED_IN_SALT',   '):U?Qq0$y:BH81gDa$rt4[j+9,/VDxN11mUuI`eMY44@#5T1zfyi[tO}e85K@3fV' );
define( 'NONCE_SALT',       'Y}Qj e7%ASqgiZ:@/{nx; YfVKD.pp!e{F$ad5Uz#Kjd,*n~EFgrP/qLc+3e9W%0' );

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
