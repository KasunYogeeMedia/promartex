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
define( 'DB_NAME', 'promartex_web' );

/** Database username */
define( 'DB_USER', 'promartex_web' );

/** Database password */
define( 'DB_PASSWORD', 'Tr.*d%EYhZC&' );

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
define( 'AUTH_KEY',         'hui7mliesdx0wguuzwbnfcc9ifb4wailcwje0oogwcstf40hgkojbqq4cjm9yjsf' );
define( 'SECURE_AUTH_KEY',  'yiylk5qg68mdtsuw6eqg03jgvmssw6jdmkcsjos9fntkzev0ek6beqtz5xflw6cd' );
define( 'LOGGED_IN_KEY',    'uapbwzreswkpzcvja4xwfbiol1enow2pf37cc9qwxiq4ycsibvpyhpmq3ijgddgb' );
define( 'NONCE_KEY',        'rmzovei6hx1dcdy7voxkmjephwp2epihtkjvuqafh1ubv6fvzq1nsgwp4a5bseyy' );
define( 'AUTH_SALT',        '6cxa1qm868bd7v3y83nq7eptwxfajdwbgrw7hhkrfgwsfq0w9rgvyqoack6sxpwp' );
define( 'SECURE_AUTH_SALT', 'z7f3uodkvmz5fivlsfvxyd98t7ikegmtgfixlxzlo58irqjgsnv7alkfwabxk7mw' );
define( 'LOGGED_IN_SALT',   'rnkoozjotpjotonwysixp1fibbvzqyxwzkxs0dqmcjgfyhuzm042ao2p9wz8wb0m' );
define( 'NONCE_SALT',       'r1yzkwpg2zswo9gaztnac2dmkq7xzmmn8jrdzq7gconmatrm48nhjfkltpqi1al5' );

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
