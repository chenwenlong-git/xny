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

        //取得上传文件信息
        $fileName=$_FILES['file']['name'];
        $fileType=$_FILES['file']['type'];
        $fileError=$_FILES['file']['error'];
        $fileSize=$_FILES['file']['size'];
        $tempName=$_FILES['file']['tmp_name'];//临时文件名
        //定义上传文件类型
        $typeList = array("image/jpeg","image/jpg","image/png","image/gif"); //定义允许的类型
        if($fileError>0){
            //上传文件错误编号判断
            switch ($fileError) {
                case 1:
                    $message="上传的文件超过了php.ini 中 upload_max_filesize 选项限制的值。";
                    break;
                case 2:
                    $message="上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值。";
                    break;
                case 3:
                    $message="文件只有部分被上传。";
                    break;
                case 4:
                    $message="没有文件被上传。";
                    break;
                case 6:
                    $message="找不到临时文件夹。";
                    break;
                case 7:
                    $message="文件写入失败";
                    break;
                case 8:
                    $message="由于PHP的扩展程序中断了文件上传";
                    break;
            }
            outData(2, "文件上传失败：".$message);
        }
        if(!is_uploaded_file($tempName)){
            //判断是否是POST上传过来的文件
            outData(2, "不是通过HTTP POST方式上传上来的");
        }else{
            if(!in_array($fileType, $typeList)){
                outData(2, "上传的文件不是指定类型");
            }else{
                if(!getimagesize($tempName)){
                    //避免用户上传恶意文件,如把病毒文件扩展名改为图片格式
                    outData(2, "上传的文件不是图片");
                }
            }
            if($fileSize>10000000){
                //对特定表单的上传文件限制大小
                outData(2, "上传文件超出限制大小");
            }else{
                //避免上传文件的中文名乱码
                $fileName=iconv("UTF-8", "GBK", $fileName);//把iconv抓取到的字符编码从utf-8转为gbk输出
//                $fileName=str_replace(".", time().".", $fileName);//在图片名称后加入时间戳，避免重名文件覆盖
                $fileName=explode(".",$fileName);
                $fileName=time().".".$fileName[1];
                if(move_uploaded_file($tempName, "../uploads/image/".$fileName)){
                    outData(1, "上传文件成功","$fileName");
                }else{
                    outData(2, "上传文件失败");
                }
            }
        }
    //导入EXCEL文件
    case "importWord":
//        if (!isset($_SESSION['uName'])) outData(2, "你还没有权限");
//        print_r($_FILES);exit;
        //取得上传文件信息
        $fileName=$_FILES['file']['name'];
        $fileType=$_FILES['file']['type'];
        $fileError=$_FILES['file']['error'];
        $fileSize=$_FILES['file']['size'];
        $tempName=$_FILES['file']['tmp_name'];//临时文件名
        //定义上传文件类型
        $typeList = array("application/msword","application/vnd.openxmlformats-officedocument.wordprocessingml.document"); //定义允许的类型
        if($fileError>0){
            //上传文件错误编号判断
            switch ($fileError) {
                case 1:
                    $message="上传的文件超过了php.ini 中 upload_max_filesize 选项限制的值。";
                    break;
                case 2:
                    $message="上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值。";
                    break;
                case 3:
                    $message="文件只有部分被上传。";
                    break;
                case 4:
                    $message="没有文件被上传。";
                    break;
                case 6:
                    $message="找不到临时文件夹。";
                    break;
                case 7:
                    $message="文件写入失败";
                    break;
                case 8:
                    $message="由于PHP的扩展程序中断了文件上传";
                    break;
            }
            outData(2, "文件上传失败：".$message);
        }
        if(!is_uploaded_file($tempName)){
            //判断是否是POST上传过来的文件
            outData(2, "不是通过HTTP POST方式上传上来的");
        }else{
            if(!in_array($fileType, $typeList)){
                outData(2, "上传的文件不是指定类型");
            }
//            else{
//                if(!getimagesize($tempName)){
//                    //避免用户上传恶意文件,如把病毒文件扩展名改为图片格式
//                    outData(2, "上传的文件不是word");
//                }
//            }
            if($fileSize>10000000){
                //对特定表单的上传文件限制大小
                outData(2, "上传文件超出限制大小");
            }else{
                //避免上传文件的中文名乱码
                $fileName=iconv("UTF-8", "GBK", $fileName);//把iconv抓取到的字符编码从utf-8转为gbk输出
//                $fileName=str_replace(".", time().".", $fileName);//在图片名称后加入时间戳，避免重名文件覆盖
                $fileName=explode(".",$fileName);
                $fileName=time().".".$fileName[1];
                if(move_uploaded_file($tempName, "../uploads/file/".$fileName)){
                    $data[0]=$fileName;
                    print_r(__FILE__($fileName));exit;
                    outData(1, "上传文件成功","$fileName");
                }else{
                    outData(2, "上传文件失败");
                }
            }
        }
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

    //录入性能数据
    case "addPerforData":
//        if (!isset($_SESSION['uName'])) outData(2, "你还没有权限");
//        print_r($_POST);exit;
        $arr = array();
        if ($_POST) {
            $VinCode= $_POST["VinCode"]?$_POST["VinCode"]:"";
            if (!preg_match('/^(?!(?:\d+|[a-zA-Z]+)$)[\da-zA-Z]{17}$/', $VinCode)) {
                outData('2', 'Vin码请输入17位字母和数字的组合', 'VinCode');
            }
            $Url = $_POST["Url"]?$_POST["Url"]:"";
            $type=$_POST["type"]?$_POST["type"]:"";
            $name="";$fieldName="";
            if($type==0){
                $name="电池数据文件";
                $fieldName="BatteryData";
            }else if($type==1){
                $name="电池数据截屏图片";
                $fieldName="BatteryImgUrl";
            }else if($type==2){
                $name="系统数据文件";
                $fieldName="SysData";
            }else{
                $name="系统数据截屏图片";
                $fieldName="SysImgUrl";
            }
            if(!$VinCode){
                outData(2, "VIN码不能为空");
            }
            if(!$Url){
                outData(2, $name."文件为空,请选择文件导入！");
            }

            $arr["ModTime"] = date("Y-m-d H:i:s");
            $arr[$fieldName]=$Url;
            $temp = $db->find("select * from com_datasafe where VinCode='" . $VinCode . "'");
            if($temp){//修改
                if($temp[$fieldName]){
                    outData(2, "该VIN码对应".$name."已存在，请修改");
                }else{
                    $relUpdate = $db->update("com_datasafe", $arr, "VinCode='".$VinCode."'");
                    if($relUpdate){
                        outData(1, $name."增加成功");
                    }else{
                        outData(2, $name."增加失败");
                    }
                }
            }else{
                $arr["VinCode"]=$VinCode;
                $arr["RegTime"] = date("Y-m-d H:i:s");
                $rel = $db->save("com_datasafe", $arr);
                if ($rel) {
                    if ($rel) outData(1, $name."增加成功");

                } else {
                    outData(2, $name."增加失败");

                }
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
            $temp = $db->findAll("select * from com_datasafe where VinCode='" . $_POST["VinCode"] . "'");
            if($temp){
                if(count($temp)==1){
                    if($temp[0]["Type"]==1){
                        outData('3', 'Vin码已存在，其QP单未录入', 'VinCode');

                    }else{
                        outData('3', 'Vin码已存在，其检测线数据未录入', 'VinCode');
                    }
                }else{
                    outData('2', 'Vin码已存在,请重新输入Vin码', 'VinCode');
                }
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
                outData('1', '订单号可用');
            }
            outData(2, "操作失败");
        }
        outData(2, "请输入订单号");
    default:
        return;
}

?>