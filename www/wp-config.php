<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

/** Determine which configuration is active. */
define( 'DB_CREDENTIALS_PATH', dirname(ABSPATH) ); // cache it for multiple use
define( 'WP_LOCAL_SERVER', file_exists( DB_CREDENTIALS_PATH . '/local-config.php' ) );
define( 'WP_DEV_SERVER', file_exists( DB_CREDENTIALS_PATH . '/dev-config.php' ) );
define( 'WP_STAGING_SERVER', file_exists( DB_CREDENTIALS_PATH . '/staging-config.php' ) );

/** Load the credentials. */
if ( WP_LOCAL_SERVER )
    require DB_CREDENTIALS_PATH . '/local-config.php';
elseif ( WP_DEV_SERVER )
    require DB_CREDENTIALS_PATH . '/dev-config.php';
elseif ( WP_STAGING_SERVER )
    require DB_CREDENTIALS_PATH . '/staging-config.php';
else
    require DB_CREDENTIALS_PATH . '/production-config.php';

/** Set debugging-mode according to your environment setup. */
if ( WP_LOCAL_SERVER || WP_DEV_SERVER ) {

    define( 'WP_DEBUG', true );
    define( 'WP_DEBUG_LOG', true ); // Stored in wp-content/debug.log
    define( 'WP_DEBUG_DISPLAY', true );

    define( 'SCRIPT_DEBUG', true );
    define( 'SAVEQUERIES', true );

} else if ( WP_STAGING_SERVER ) {

    define( 'WP_DEBUG', true );
    define( 'WP_DEBUG_LOG', true ); // Stored in wp-content/debug.log
    define( 'WP_DEBUG_DISPLAY', false );

} else {

    define( 'WP_DEBUG', false );
}

// TODO: Account for whole site in a subdirectory
/** Point WordPress to the subdirectory installation. */
define('WP_SITEURL', 'http://' . $_SERVER['HTTP_HOST'] . '/wordpress');
define('WP_HOME',    'http://' . $_SERVER['HTTP_HOST']);
define('WP_CONTENT_DIR', $_SERVER['DOCUMENT_ROOT'] . '/wp-content');
define('WP_CONTENT_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/wp-content');

/** MySQL settings */
define('DB_NAME', 'your database name');
define('DB_USER', 'your database user');
define('DB_PASSWORD', 'your database password');
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/** Debugging mode */
define('WP_DEBUG', false);

/**
 * Set to false if you don't want WordPress to keep different
 * versions of posts around.
 *
 * false = no post revisions
 * true = way too many post revisions, this is the default that you should not use
 * int = if you want to have revisions enabled you can set a number to limit them
 */
define('WP_POST_REVISIONS', false);

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/** The number of days items are stored in trash. */
define('EMPTY_TRASH_DAYS', 30);

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'your unique keys here');
define('SECURE_AUTH_KEY',  'your unique keys here');
define('LOGGED_IN_KEY',    'your unique keys here');
define('NONCE_KEY',        'your unique keys here');
define('AUTH_SALT',        'your unique keys here');
define('SECURE_AUTH_SALT', 'your unique keys here');
define('LOGGED_IN_SALT',   'your unique keys here');
define('NONCE_SALT',       'your unique keys here');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 *
 * NOTE: This should be changed to something unique for security.
 */
$table_prefix  = 'wp_';

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
    define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
