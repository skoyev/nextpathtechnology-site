<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache

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
define('DB_NAME', 'selfimq5_wordpress71d');

/** MySQL database username */
define('DB_USER', 'selfimq5_word71d');

/** MySQL database password */
define('DB_PASSWORD', 'sLjVGUb9tVjq');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY', '-sdAyJPd)C(efS/|AzkF*^y|sS^YrH-&o;M{&@m[vdiH/GYn{cX[_m?]k&|SA%<qN{%DT?XY*@_U@$D&hS-[^%FOnY|Mv=fdtu/udt{/[MPh[=cJ[lh%]/QIiENNlP_(');
define('SECURE_AUTH_KEY', 's+sSt^pDg}%a{]NvR@>CxIL;y!iIcPO}W}nGtiMn>avW{;y<hx}rH[raHwDSIkE/xMypdodzg<G?FiM^Zxm)!f+LaAzrqeFRYx=z%V[@}i%TPFIXgwpDll}EKj!{)JnL');
define('LOGGED_IN_KEY', 'Y)I=rNHX>-mgm(Ld>=YVx}ihKsOopXqqRK!xUM-uGtXHtHdOLxfl}Un%Jt_Xjf%_UOJV-sxqP[XZRA(ZUqR[d+jh{WMP;g{muwYZhK%dtZPQGeXzr(;^fSD]QLOlTcw@');
define('NONCE_KEY', '*W-C$)FLcSBVL^]/hyaXVqypLdF>LbnJZuAWn^IWt/er/MBr(S<i|GnT+FEM>?/d_U%>@fmwk&[v?$[|^LMWYrf]z{YChjkG[$BxU?-E[lnnCyaowF;_@}vL]b)e<$<l');
define('AUTH_SALT', 'U_gmrzGbU[rA^/XTiMj&W%VE&U[mojd)p>lD|J{]QkX{-SWST$SjJ/B{-nYxhw*rAkf_H(gPwWTwl%pd&N@DAkF;^*c)u=mzW?-/Z!ngjKkd++[=|]OIFVaWO{};R<+;');
define('SECURE_AUTH_SALT', '}S;&?|P|s|ZAwWEcj|G}Oeckb=yQGonjcY%otO+cYmV$u*&tPl^CcohLQFaUY}ZDkG](]Lpx*KSe<F/MiX@D-hhtWnr<ptXd>(p=QVk)u)Gf){aqNDdjUHXFi)OjYX|k');
define('LOGGED_IN_SALT', 'O}_l?k*+g/]Qp?fvK{w;|fujBqte[/vT[Bg!sF^=}j=BRrt]UcJ%!PX_r+!dPJtAyvMFH[dEEqQFw?/[d(o^{OvA>SQ%oA&BBGlyRL(XWyKeN%)ay[%*NhXVnN$ta_p+');
define('NONCE_SALT', ')-pGkY<i=u;&}>)[jF]B&j|Dgx)pqobU!hlZ-H]Xf-&La>SX}JLMSEZ?(Di^N(sOt+HXwfu++?gu;F<pGc@b%G;HS[TgXB]v@|>X;_EcMAY$(M/g[f=HX)pOcarFVa_j');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_psso_';

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

/**
 * Include tweaks requested by hosting providers.  You can safely
 * remove either the file or comment out the lines below to get
 * to a vanilla state.
 
if (file_exists(ABSPATH . 'hosting_provider_filters.php')) {
	include('hosting_provider_filters.php');
} */
