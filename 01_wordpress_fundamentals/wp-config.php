<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', '01_wordpress_fundamentals' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         'w%lCzy+j0%AeCqzbsN,rmA9B/u*_KrE:$eUX ?PTr&#~,|;!D2As..MV08ayTggM' );
define( 'SECURE_AUTH_KEY',  'I(I<ZmZb6eD6&Omu(8Dtk:VR{^=ror#d[-lb,f,KSc61C9XHf]OpqEAU5W~;vH}f' );
define( 'LOGGED_IN_KEY',    '}-`1nb:lBTvEHA<)P@OKz}ha[y%_jaV6IA2<0[rkPU4lJn*!wwpXJGa4qZr/DZzH' );
define( 'NONCE_KEY',        '}Moq|Re:tq4HX)@Z=TeOT=$Blfh1qI]{..FM)>W&EP#>~h@ ew HrbZN}c3cyo6&' );
define( 'AUTH_SALT',        'KKKjkbpzr,.]E]_NM9T#`aEI&iIYqTb9*enCy,:zyW|6czvm616Z92Lu.Q1,o^`y' );
define( 'SECURE_AUTH_SALT', 'DKB5V_M--i$^~$v^LVn7,#y2JHJ{R3L^.u`hgNh $Yt=`L}]UP}V,5CtK3+?,-d{' );
define( 'LOGGED_IN_SALT',   'hi(A)dHK0iy1V=K5e@Nf,len8kB1 !Q(K:#:$mtJKJ$cN(#Gq|Neef^dq&U?Uq<r' );
define( 'NONCE_SALT',       '/Gs7E9BxjCd2( pqN=WncRXUU/gi(aR#Y!Z=Ar [q3h%sL^ NfzBShjE,0ucb?*X' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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
