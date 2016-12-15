<?php
/** 
 * As configurações básicas do WordPress.
 *
 * Esse arquivo contém as seguintes configurações: configurações de MySQL, Prefixo de Tabelas,
 * Chaves secretas, Idioma do WordPress, e ABSPATH. Você pode encontrar mais informações
 * visitando {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. Você pode obter as configurações de MySQL de seu servidor de hospedagem.
 *
 * Esse arquivo é usado pelo script ed criação wp-config.php durante a
 * instalação. Você não precisa usar o site, você pode apenas salvar esse arquivo
 * como "wp-config.php" e preencher os valores.
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar essas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define('DB_NAME', 'wordpress');

/** Usuário do banco de dados MySQL */
define('DB_USER', 'root');

/** Senha do banco de dados MySQL */
define('DB_PASSWORD', 'silvia25');

/** nome do host do MySQL */
define('DB_HOST', 'localhost');

/** Conjunto de caracteres do banco de dados a ser usado na criação das tabelas. */
define('DB_CHARSET', 'utf8mb4');

/** O tipo de collate do banco de dados. Não altere isso se tiver dúvidas. */
define('DB_COLLATE', '');

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * Você pode alterá-las a qualquer momento para desvalidar quaisquer cookies existentes. Isto irá forçar todos os usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'jT_5&woVZ9CiM_qMy_`T:L>lNTx-K9 ?PxS/rD[gr&_!6;@o[W$13w,hUIu15j,l');
define('SECURE_AUTH_KEY',  'Y,m}u[?of9j~z_}95<lr-KIT6*kX0ztzD-B>&jzf_yRAX}_+L[Vfv2I^X<gtSckK');
define('LOGGED_IN_KEY',    'il}n=pj4lN2LZ=!q]@+;Xf>r3g6p1p}?{oDdVbpVnqzzMIUE9S.CggUY2:sEQ5Wn');
define('NONCE_KEY',        'Z~Ug2ku-5SVCHbn$LRGugz.tBe$=Q^Srf|]!A`R<{kaGx/DmgPg)]7o$E3/AzqD`');
define('AUTH_SALT',        'jfSh*m&`ed=<)u5f@&tFx!v$0_S!@VuHO/f| W#J4$y>;hGv;14(nY~9T5N%GFY>');
define('SECURE_AUTH_SALT', 'MW%Q5se?o,B!%:<yLSDy<Fikh2,t~A]rVZTKyGnj4<%jnBLeNMS#=<%pY11~gB@v');
define('LOGGED_IN_SALT',   'IbaC2y5 VHLRvt8{dBhgYRb4,;r^5A1@QM:qL(`z~.9$1`fubISo%y}x94d2EHrs');
define('NONCE_SALT',       '5z2zoc_BEz&>Nx%uTl}pk?Qtz?@!vCbA#bmA|WU_^)24IYKT s@d^Ji.2$k1C4HF');

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der para cada um um único
 * prefixo. Somente números, letras e sublinhados!
 */
$table_prefix  = 'wp_';


/**
 * Para desenvolvedores: Modo debugging WordPress.
 *
 * altere isto para true para ativar a exibição de avisos durante o desenvolvimento.
 * é altamente recomendável que os desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 */
define('WP_DEBUG', true);
define('FS_METHOD','direct');
/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
	
/** Configura as variáveis do WordPress e arquivos inclusos. */
require_once(ABSPATH . 'wp-settings.php');
