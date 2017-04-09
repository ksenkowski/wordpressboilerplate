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

// Include local configuration
if (file_exists(dirname(__FILE__) . '/local-config.php')) {
	include(dirname(__FILE__) . '/local-config.php');
}

// Global DB config
if (!defined('DB_NAME')) {
	define('DB_NAME', 'wordpress');
}
if (!defined('DB_USER')) {
	define('DB_USER', 'root');
}
if (!defined('DB_PASSWORD')) {
	define('DB_PASSWORD', 'root');
}
if (!defined('DB_HOST')) {
	define('DB_HOST', 'localhost');
}

/** Database Charset to use in creating database tables. */
if (!defined('DB_CHARSET')) {
	define('DB_CHARSET', 'utf8');
}

/** The Database Collate type. Don't change this if in doubt. */
if (!defined('DB_COLLATE')) {
	define('DB_COLLATE', '');
}

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '/6T/t u1O .v+01cqFTw;#&!Ss`4^wlc;RI8FiVr(78l}NTv+ZH?{h)9enN|mWW@');
define('SECURE_AUTH_KEY',  'UR).sXiCDX!;krD<RXGJ(~C,R.:!GE$c^${ [tO=RU~(@to/DG$aYJ3hd%hwM#C>');
define('LOGGED_IN_KEY',    '!.}@jt. i#Qj=EsPYdl5p|et^zcaDd1[?3sUn(/tfYC10w?J`mKRQ+OY[M(X*mSc');
define('NONCE_KEY',        'WDtQx^}[{EU4%vJC)m)`[Se4%iTxLVmXiz2,J>Lb:-SE5?xet@[.?iQzdQGfo`qS');
define('AUTH_SALT',        '8p{K;pYnDB:I47T&cJ+[+NV6#r=.o4yFjEQj5fzQBl@OW >HbR`<(6-x!R_L`e/3');
define('SECURE_AUTH_SALT', 'L`:)iuMEv9z#?Umx`mPd/idvAo#G^r8j8)d/*QxZMD|Zq?:hbf6+:%w);JBj+9C!');
define('LOGGED_IN_SALT',   'qGl:v#=s:OF2qu^YL`@G#G?eP(XLQG2KS8AU{eN8WZcte(O(WxiadCPcFCRwLM3&');
define('NONCE_SALT',       '?;Qn0/@Uc6p[4_xog8^ZNREy|~FpSP~WcG6hv4bGtM^.Pke=`A<_6MmwU1~ry`xU');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');


/**
 * Set custom paths
 *
 * These are required because wordpress is installed in a subdirectory.
 */
if (!defined('WP_SITEURL')) {
	define('WP_SITEURL', 'http://localhost:8888/wordpress');
}
if (!defined('WP_HOME')) {
	define('WP_HOME',    'http://localhost:8888/');
}
if (!defined('WP_CONTENT_DIR')) {
	define('WP_CONTENT_DIR', dirname(__FILE__) . '/wp-content');
}
if (!defined('WP_CONTENT_URL')) {
	define('WP_CONTENT_URL', 'http://localhost:8888/wp-content');
}


/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
if (!defined('WP_DEBUG')) {
	define('WP_DEBUG', true);
}

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
