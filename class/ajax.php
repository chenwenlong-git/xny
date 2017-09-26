<?php
session_start();
require_once '../include/function.php';
require_once '../include/config.inc.php';
require_once '../include/syslog.class.php';
require_once '../include/class.phpmailer.php';
$syslogclass = new SysLog();

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$act = strip_tags(trim($_REQUEST['act']));
$token = 123456;
switch ($act) {
    case "uploadify"://打印模版的创建
        $f = 'ap_'.time().'_'.strtoupper(substr(md5(rand()),0,4)).'.png';
        $ymd = date('Ym',time());
        $targetFolder = "./uploads/$ymd/";

        if ( !file_exists( $targetFolder ) ) {
            mkdir( $targetFolder );
        }

        if (!empty($_FILES) ) {
            $tempFile = $_FILES['Filedata']['tmp_name'];
            $targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
            $targetFile = rtrim($targetPath,'/') . '/' . $f;

            // Validate the file type
            $fileTypes = array('jpg','jpeg','gif','png'); // File extensions
            $fileParts = pathinfo($_FILES['Filedata']['name']);

            if (in_array($fileParts['extension'],$fileTypes)) {
                move_uploaded_file($tempFile,$targetFile);
                echo base_url("uploads/$ymd").'/'.$f;
                outData(1, "增加成功");
            } else {
                echo 'Invalid file type.';
            }
        }
        if ($rel) outData(1, "增加成功");

        outData(2, "操作有误");
    default:
        return;
}

?>