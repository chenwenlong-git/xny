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

    //上传车辆录入信息表
    case "TraceDataCar":
          //define('ROOT_PATH', dirname(dirname(__FILE__)) . '');
		if (isset($_SESSION['UsrId'])) { $UsrId=$_SESSION['UsrId']; }else{ $UsrId=0; }
	    $name = 'newcel';
        require_once ROOT_PATH . 'include/Uploader.class.php';
        require_once ROOT_PATH . 'external/PHPExcel/Classes/PHPExcel.php'; 
        $arr = array(
            ".xls",
            ".xlsx",
            ".csv"
        );
        $config = array(
            //  "pathFormat" =>"/upimage/".date("Y-m-d H:i:s"),
            "pathFormat" => "uploads/xlsx/" . time(),
            "maxSize" => 2048000,
            "allowFiles" => $arr
        );
        $up = new Uploader('newcel', $config);
		$img = $up->getFileInfo();
        if(empty($img["url"])){
            outData(2, "请先导入EXCEL");
        }
        $filename = ROOT_PATH ."uploads/xlsx/".$img['title'];
        $filename = str_replace('\\', '/', $filename);
        $info=pathinfo($filename);

        if($info['extension']!="xlsx"&&$info['extension']!="xls"){
            outData(2, "导入文件格式不对，请导入xlsx或xls格式的表格");
        }
        // Check prerequisites
        if (!file_exists($filename)) {
            outData(2,"上传失败！");
        }else{
			$filename=substr($filename,-30);
			$filename1=substr($filename,-28);
			$filename= "http://".$_SERVER['HTTP_HOST'].$filename;
 
             /**对excel里的日期进行格式转化*/ 
			function GetData($val){ 
			$jd = GregorianToJD(1, 1, 1970); 
			$gregorian = JDToGregorian($jd+intval($val)-25569); 
			return $gregorian;/**显示格式为 “月/日/年” */ 
			} 

			$filePath = "../".$filename1; 

			$PHPExcel = new PHPExcel(); 

			/**默认用excel2007读取excel，若格式不对，则用之前的版本进行读取*/ 
			$PHPReader = new PHPExcel_Reader_Excel2007(); 
			if(!$PHPReader->canRead($filePath)){ 
			$PHPReader = new PHPExcel_Reader_Excel5(); 
			if(!$PHPReader->canRead($filePath)){ 
			echo 'no Excel'; 
			return ; 
			} 
			} 

			$PHPExcel = $PHPReader->load($filePath); 
			/**读取excel文件中的第一个工作表*/ 
			$currentSheet = $PHPExcel->getSheet(0); 
			/**取得最大的列号*/ 
			$allColumn = $currentSheet->getHighestColumn(); 
			/**取得一共有多少行*/ 
			$allRow = $currentSheet->getHighestRow(); 
			/**从第二行开始输出，因为excel表中第一行为列名*/ 
             $y=0;
			  for($currentRow = 2;$currentRow <= $allRow;$currentRow++){
				  /**从第A列开始输出*/
				  $i=0;
				  $arr=array();
				  for($currentColumn = 'A'; $currentColumn !=$allColumn; $currentColumn++){ //大于26列
					 if($i>25){
					   $num =ord($currentColumn)+$i;
					 }else{
						$num =ord($currentColumn);
					 }
					 $val = $currentSheet->getCellByColumnAndRow($num - 65,$currentRow)->getValue(); /*ord()将字符转为十进制数*/
					 if($currentColumn == 'P' || $currentColumn == 'R' || $currentColumn == 'BB' || $currentColumn == 'CL' ) {
						$arr[$i]=GetData($val); 
		             }else{
		                $arr[$i]=iconv('utf-8','utf-8', $val); 
		             }
					 if($currentColumn=="B"){
					    $Remarks=$val;
					 }
					 if($currentColumn=="C"){
					    $ClientInfo=$val;
					 }
					 if($currentColumn=="D"){
					    $PaperNumber=$val;
					 }
					 if($currentColumn=="E"){
					    $ClientNumber=$val;
					 }
					 if($currentColumn=="F"){
					    $OperatingLine=$val;
					 }
					 if($currentColumn=="G"){
					    $License=$val;
					 }
					 if($currentColumn=="H"){
					    $SerialNumber=$val;
					 }

					  $i++;
				  }
			   $jsoninfo =json_encode($arr,JSON_UNESCAPED_UNICODE); // 转义字符串
		       $data = array(
				    "UsrId" =>$UsrId,
				    "Remarks" =>$Remarks,
				    "ClientInfo" =>$ClientInfo,
				    "PaperNumber" =>$PaperNumber,
				    "ClientNumber" =>$ClientNumber,
				    "OperatingLine" =>$OperatingLine,
				    "License" =>$License,
				    "SerialNumber" =>$SerialNumber,
				    "FileInfo" =>$filename1,
                    "OtherData" =>$jsoninfo
                );
               $rel = $db->save("com_traceldata", $data);
                  $y++;
			   }
		     if ($rel) outData(1, "上传成功！");

             outData(2, "上传失败！");
		}

   //上传上海车辆录入信息表
      case "TraceDatashCar":
		if (isset($_SESSION['UsrId'])) { $UsrId=$_SESSION['UsrId']; }else{ $UsrId=0; }
	    $name = 'newcel';
        require_once ROOT_PATH . 'include/Uploader.class.php';
        require_once ROOT_PATH . 'external/PHPExcel/Classes/PHPExcel.php'; 
        $arr = array(
            ".xls",
            ".xlsx",
            ".csv"
        );
        $config = array(
            "pathFormat" => "uploads/xlsx/" . time(),
            "maxSize" => 2048000,
            "allowFiles" => $arr
        );
        $up = new Uploader('newcel', $config);
		$img = $up->getFileInfo();
        if(empty($img["url"])){
            outData(2, "请先导入EXCEL");
        }
        $filename = ROOT_PATH ."uploads/xlsx/".$img['title'];
        $filename = str_replace('\\', '/', $filename);
        $info=pathinfo($filename);

        if($info['extension']!="xlsx"&&$info['extension']!="xls"){
            outData(2, "导入文件格式不对，请导入xlsx或xls格式的表格");
        }
        // Check prerequisites
        if (!file_exists($filename)) {
            outData(2,"上传失败！");
        }else{
			$filename=substr($filename,-30);
			$filename1=substr($filename,-28);
			$filename= "http://".$_SERVER['HTTP_HOST'].$filename;
 
             /**对excel里的日期进行格式转化*/ 
			function GetData($val){ 
			$jd = GregorianToJD(1, 1, 1970); 
			$gregorian = JDToGregorian($jd+intval($val)-25569); 
			return $gregorian;/**显示格式为 “月/日/年” */ 
			} 

			$filePath = "../".$filename1; 

			$PHPExcel = new PHPExcel(); 

			/**默认用excel2007读取excel，若格式不对，则用之前的版本进行读取*/ 
			$PHPReader = new PHPExcel_Reader_Excel2007(); 
			if(!$PHPReader->canRead($filePath)){ 
			$PHPReader = new PHPExcel_Reader_Excel5(); 
			if(!$PHPReader->canRead($filePath)){ 
			echo 'no Excel'; 
			return ; 
			} 
			} 

			$PHPExcel = $PHPReader->load($filePath); 
			/**读取excel文件中的第一个工作表*/ 
			$currentSheet = $PHPExcel->getSheet(0); 
			/**取得最大的列号*/ 
			$allColumn = $currentSheet->getHighestColumn(); 
			/**取得一共有多少行*/ 
			$allRow = $currentSheet->getHighestRow(); 
			/**从第二行开始输出，因为excel表中第一行为列名*/ 
             $y=0;
			  for($currentRow = 4;$currentRow <= $allRow;$currentRow++){
				  /**从第A列开始输出*/
				  $i=0;
				  $arr=array();
				  for($currentColumn = 'A'; $currentColumn !=$allColumn; $currentColumn++){ //大于26列
					 if($i>25){
					   $num =ord($currentColumn)+$i;
					 }else{
						$num =ord($currentColumn);
					 }
					 $val = $currentSheet->getCellByColumnAndRow($num - 65,$currentRow)->getValue(); /*ord()将字符转为十进制数*/
		             if($currentColumn == 'H' || $currentColumn == 'E' || $currentColumn == 'F'  ) {
						$arr[$i]=GetData($val); 
		             }else{
		                $arr[$i]=iconv('utf-8','utf-8', $val); 
		             }
					 if($currentColumn=="B"){
					    $Remarks=$val;
					 }
					 if($currentColumn=="C"){
					    $VinCode=$val;
					 }

					  $i++;
				  }
			   $jsoninfo =json_encode($arr,JSON_UNESCAPED_UNICODE); // 转义字符串
		       $data = array(
				    "UsrId" =>$UsrId,
				    "Remarks" =>$Remarks,
				    "VinCode" =>$VinCode,
				    "FileInfo" =>$filename1,
                    "OtherData" =>$jsoninfo
                );
			   if($Remarks!=""){  //B列数据不为空的才写进数据
               $rel = $db->save("com_tracelshdata", $data);
			   }
                  $y++;
			   }
		     if ($rel) outData(1, "上传成功！");

             outData(2, "上传失败！");
		}

    //上传上海车辆录入信息表
     case "PartsReport":
       if (isset($_SESSION['UsrId'])) { $UsrId=$_SESSION['UsrId']; }else{ $UsrId=0; }
       $allimgarr=json_decode($_POST['allimgarr']);
	   foreach($allimgarr as $k=>$v){
         $FileInfo=substr($v,5);
	     $data = array(
				    "UsrId" =>$UsrId,
				    "FileInfo" =>$FileInfo
             );
	      $rel = $db->save("com_partsreport", $data);
	   }
	    if ($rel) outData(1, "上传成功！");

             outData(2, "上传失败！");
    default:
        return;
}

?>