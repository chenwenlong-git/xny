<?php
session_start();
require_once '../include/function.php';
require_once '../include/config.inc.php';
require_once '../include/class.phpmailer.php';
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$act = strip_tags(trim($_REQUEST['act']));
$token = 123456;
switch ($act) {
    case "uploadify"://打印模版的创建
        $f = 'ap_' . time() . '_' . strtoupper(substr(md5(rand()), 0, 4)) . '.png';
        $ymd = date('Ym', time());
        $targetFolder = "./uploads/$ymd/";

        if (!file_exists($targetFolder)) {
            mkdir($targetFolder);
        }
        if (!empty($_FILES)) {
            $tempFile = $_FILES['Filedata']['tmp_name'];
            $targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
            $targetFile = rtrim($targetPath, '/') . '/' . $f;

            // Validate the file type
            $fileTypes = array('jpg', 'jpeg', 'gif', 'png'); // File extensions
            $fileParts = pathinfo($_FILES['Filedata']['name']);

            if (in_array($fileParts['extension'], $fileTypes)) {
                move_uploaded_file($tempFile, $targetFile);
                echo base_url("uploads/$ymd") . '/' . $f;
                outData(1, "增加成功", base_url("uploads/$ymd") . '/' . $f);
            } else {
                echo 'Invalid file type.';
            }
        }
        if ($rel) outData(1, "增加成功");

        outData(2, "操作有误");

    //录入安全数据
    case "safeDateAdd":
//        if (!isset($_SESSION['uName'])) outData(2, "你还没有权限");
//        print_r($_POST);exit;
        $arr = array();
        if ($_POST["tableName"]) {
            $tableName = json_decode($_POST["tableName"]);
            $title = json_decode($_POST["title"]);
            $val = json_decode($_POST["val"]);
            foreach ($val as $k => $v) {
                if (!$v) {
                    outData(2, $title[$k]."不能为空",$tableName[$k]);
                }
                $arr[$tableName[$k]] = $v;
            }
            if (!preg_match('/^(?!(?:\d+|[a-zA-Z]+)$)[\da-zA-Z]{17}$/', $arr["VinCode"])) {
                outData('2', 'Vin码请输入17位字母和数字的组合', 'VinCode');
            }
            $type = isset($_POST["type"]) ? $_POST["type"] : 0;
            $temp = $db->find("select * from com_datasafe where VinCode='" . $arr["VinCode"] . "' and Type='" . $type . "'");
            if($temp){
                outData('2', 'Vin码已存在，请重新输入', 'VinCode');
            }
            $arr["RegTime"] = date("Y-m-d H:i:s");
            $arr["ModTime"] = date("Y-m-d H:i:s");
//        print_r($arr);exit;
            $arr["Type"] = $type;
            $rel = $db->save("com_datasafe", $arr);
            if ($type == 0) {
                if ($rel) outData(1, "QP单增加成功");

            } else {
                if ($rel) outData(1, "检测线数据增加成功");

            }
            outData(2, "操作失败");
        }
        outData(2, "操作有误");

    //检索VIN码
    case "checkVinCode":
//        if (!isset($_SESSION['uName'])) outData(2, "你还没有权限");
//        print_r($_POST);exit;
        $arr = array();
        if ($_POST["VinCode"]) {
            if (!preg_match('/^(?!(?:\d+|[a-zA-Z]+)$)[\da-zA-Z]{17}$/', $_POST["VinCode"])) {
                outData('2', 'Vin码请输入17位字母和数字的组合', 'VinCode');
            }
            $temp = $db->find("select * from com_datasafe where VinCode='" . $_POST["VinCode"] . "'");
            if($temp){
                outData('2', 'Vin码已存在，请重新输入', 'VinCode');
            }else{
                outData('1', 'Vin码可用', 'VinCode');
            }
            outData(2, "操作失败");
        }
        outData(2, "请输入Vin码");

    //录入出厂前数据
    case "addFactoryData":
//        if (!isset($_SESSION['uName'])) outData(2, "你还没有权限");
//        print_r($_POST);exit;
        $arr = array();
        if ($_POST) {
            $OrderNum = $_POST["OrderNum"]?$_POST["OrderNum"]:"";
            $Url = $_POST["Url"]?$_POST["Url"]:"";
            $type=$_POST["type"]?$_POST["type"]:"";
            $name="";$fieldName="";
            if($type==1){
                $name="配置单";
                $fieldName="ConfigUrl";
            }else if($type==2){
                $name="BOM单";
                $fieldName="BOMUrl";
            }else{
                $name="合同";
                $fieldName="ContractUrl";
            }
            if(!$OrderNum){
                outData(2, "订单号不能为空");
            }
            if(!$Url){
                outData(2, $name."文档为空,请选择文档导入！");
            }

//            if (!preg_match('/^(?!(?:\d+|[a-zA-Z]+)$)[\da-zA-Z]{17}$/', $arr["VinCode"])) {
//                outData('2', 'Vin码请输入17位字母和数字的组合', 'VinCode');
//            }
            $arr["ModTime"] = date("Y-m-d H:i:s");
            $arr[$fieldName]=$Url;
            $temp = $db->find("select * from com_factorydata where OrderNum='" . $OrderNum . "'");
            if($temp){//修改
                if($temp[$fieldName]){
                    outData(2, "订单号对应".$name."已存在，请修改");
                }else{
                    $relUpdate = $db->update("com_factorydata", $arr, "OrderNum=".$OrderNum);
                    if($relUpdate){
                        outData(1, $name."增加成功");
                    }else{
                        outData(2, $name."增加失败");
                    }
                }

            }else{
                $arr["OrderNum"]=$OrderNum;
                $arr["RegTime"] = date("Y-m-d H:i:s");
                $rel = $db->save("com_factorydata", $arr);
                if ($rel) {
                    if ($rel) outData(1, $name."增加成功");

                } else {
                    outData(2, $name."增加失败");

                }
            }
            outData(2, "操作失败");
        }
        outData(2, "操作有误");

    //检索订单号
    case "checkOrderNum":
//        if (!isset($_SESSION['uName'])) outData(2, "你还没有权限");
//        print_r($_POST);exit;
        $arr = array();
        if ($_POST["OrderNum"]) {
//            if (!preg_match('/^(?!(?:\d+|[a-zA-Z]+)$)[\da-zA-Z]{17}$/', $_POST["VinCode"])) {
//                outData('2', 'Vin码请输入17位字母和数字的组合', 'VinCode');
//            }
            $temp = $db->find("select * from com_factorydata where OrderNum='" . $_POST["OrderNum"] . "'");
            if($temp){
                $resName="";
                if($temp["ContractUrl"]&&$temp["ConfigUrl"]&&$temp["BOMUrl"]){
                    outData('2', '该订单号已存在，请重新输入订单号！');
                }else{
                    if(!$temp["ContractUrl"]){
                        $resName.="合同文档,";
                    }
                    if(!$temp["ConfigUrl"]){
                        $resName.="配置单,";
                    }
                    if(!$temp["BOMUrl"]){
                        $resName.="BOM单,";
                    }
                    outData('3', '该订单号已存在，其'.$resName.'未录入！');
                }
            }else{
                outData('1', 'Vin码可用', 'VinCode');
            }
            outData(2, "操作失败");
        }
        outData(2, "请输入Vin码");
    default:
        return;
}

?>