<?php
//var_dump($_FILES);
$imgarr=array();
foreach($_FILES as $k=>$v){
    $name=strstr($v["name"],".");
    $fileName = time().rand(1,9).rand(1,9).rand(1,9).rand(1,9).rand(1,9).$name;
    move_uploaded_file($v["tmp_name"],"upload/" .$fileName);
    $imgarr[]="upload/" .$fileName;
}
echo '{"code": "2", "message": "上传失败！", "data": ""}';
header("content-type:application/json");
//var_dump($imgarr);
?>