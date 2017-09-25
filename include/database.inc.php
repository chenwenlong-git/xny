<?php
define ('DB_TYPE','mysql');
define ('DB_HOST','localhost');
if(1) { //Fred
define ('DB_USER','root');
define ('DB_PWD','111111');
$s=isset($_GET['dname']) ? 'qis': 'secbc';
if($s=='secbc'){
	define ('DB_NAME','secbc');
}else{
	define ('DB_NAME','qis');
}
}else { //Zdm
define ('DB_USER','lq');
define ('DB_PWD','123');
define ('DB_NAME','secbc');
}

//define ('DB_CHARSET','GB2312');
define ('DB_CHARSET','UTF8');
define ('DB_PREFIX','bc_');
?>