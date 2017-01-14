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

// ** Heroku Postgres settings - from Heroku Environment ** //
$db = parse_url($_ENV["DATABASE_URL"]);

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', "wordpress");

/** MySQL database username */
define('DB_USER', "postgres");

/** MySQL database password */
define('DB_PASSWORD', "silvia25");

/** MySQL hostname */
if($_SERVER['HTTP_HOST'] == 'localhost'){
	define('DB_HOST', "localhost");
} else{
	define('DB_HOST', "wordpress.ec2-54-245-152-242.us-west-2.compute.amazonaws.com");
}
/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',              getenv('AUTH_KEY'));
define('SECURE_AUTH_KEY',       getenv('SECURE_AUTH_KEY'));
define('LOGGED_IN_KEY',         getenv('LOGGED_IN_KEY'));
define('NONCE_KEY',             getenv('NONCE_KEY'));
define('AUTH_SALT',             getenv('AUTH_SALT'));
define('SECURE_AUTH_SALT',      getenv('SECURE_AUTH_SALT'));
define('LOGGED_IN_SALT',        getenv('LOGGED_IN_SALT'));
define('NONCE_SALT',            getenv('NONCE_SALT'));
//user aws timocabralcarvalho group bucketgroup 
define('AWS_ACCESS_KEY_ID',     "AKIAIWEZHRHPABIH2DPA");
define('AWS_SECRET_ACCESS_KEY', "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");
// https://677914266604.signin.aws.amazon.com/console 
//arn:aws:iam::677914266604:user/timocabral 
/**#@-*/

/**
 * AKIAJKAMMM4T4B4MZ6DQ
qLl7I95wmpwDsP8Rq+wfd/3Vldw0gPDebbeNg56T Hide 
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);
define('FS_METHOD','direct');
/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
