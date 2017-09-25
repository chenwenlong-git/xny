<?php
//*********************************************************
//  File name: s_cfg.php
//  Copyright(c) 2015
//  Author: Freddie
//*********************************************************
//*--------------------------------------
define('DB_CONN_HOST', 'localhost');//host
define('DB_CONN_NAME', 'secbc');//database
define ('DB_USER','ming');
define ('DB_PWD','321');
//--------------------------------------*/


define('DB_CONN_USER', 'ming');
define('DB_CONN_PSWD', '321');


//tables
define('TB_SEC_PNBIND', 	'bc_pnbind');
define('TB_SEC_DATATPL',	'bc_datatpl');
define('TB_SEC_USER',		'bc_usr');
define('TB_SEC_VENDINFO',	'bc_vendor');
define('TB_SEC_CUSTINFO',	'z_custinfo');
define('MT_BLOG_HOST','localhost');
define('MT_CATE_DISP_COUNT','20');

if (!defined('ABSPATH'))
	define('ABSPATH', dirname(dirname(__FILE__)));

require_once(ABSPATH."/include/pdo_mydb.php");

$dcfg = array(	'host' 	=> DB_CONN_HOST, 'port' => '3306',
				'dbname'=> DB_CONN_NAME, 'username'=>DB_CONN_USER,'password' => DB_CONN_PSWD, 
				'options'=>array( 	PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'",
									PDO::ATTR_PERSISTENT => true,
									PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION	)
			 	);

if( ! isset($dbobj) ) {
	$dbobj =new CPDO($dcfg);
	$dbobj -> connect();
}
date_default_timezone_set("Asia/Shanghai");//timezone
?>