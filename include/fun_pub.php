<?php
//*****************************************
//  FileName:fun_pub.php
//  Copyright(c) 2015
//  Author: Freddie
//*****************************************

//404 error
function fnCatchError() 
{
	header('HTTP/1.1 404 Not Found');
	header("status: 404 Not Found");
	header("Location: /error.html");
	exit;
}

/*************************
@Para:
ResCode
0 - Normal
1 - Error
ResStri
...
**************************/
function JsonRespond($Code,$String)
{
	$err = array("ResCode"=>$Code, "ResStri"=>$String);//Code and string
	echo json_encode($err);
}

//check refer
function fnChkRefer() {
	if(	!isset($_SERVER['HTTP_REFERER']) || 
		$_SERVER['HTTP_REFERER']=='' || 
		strpos($_SERVER['HTTP_REFERER'],MT_BLOG_HOST)===false) {//stripos
		//fnCatchError();
		echo "Request refused!";
		exit;
	}
}

function CheckSpecial($str)
{
	if(preg_match('/[\'\\\\<>|;&#"=()]/',$str))
		return TRUE;
}

//-----------------------------
//过滤标签(HTML)：strip_tags()
//转义mysql特殊字符：mysql_real_escape_string()
//引号转义：addslashes()
//转义HTML：htmlspecialchars()
//’"\和NULL字符转意
//-----------------------------
function add_slashes($data)
{
	if(!get_magic_quotes_gpc()) //注意：只对POST/GET/cookie过来的数据增加转义，其它方法请使用addslashes直接转义
		return is_array($data)?array_map('addslashes',$data):addslashes($data);
	return $data;
}

function CheckMatch($source,$para)
{
	if($para=="[username]" )
		$para="/^[.\w\x{4e00}-\x{9fa5}]+$/u";
		
	if($para=="[password]" )
		$para="/^[\w]+$/";
		
	if($para=="[email]" )
		$para="/^([0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-\w]*\.)+[a-zA-Z]*)$/";
			//"/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/"
	if($para=="[homepage]" )
		$para="/^[a-zA-Z]+:\/\/[a-zA-Z0-9\-\.\&\?\/]+\/*$/";
	
	return preg_match($para,$source);//返回匹配次数 0 or 1
}

//SPAM URL编码
function fnEncodeUrlForSpam($url)
{
	$eurl='';
	$len=strlen($url);
	if($len>0)	{
		$eurl='{MT_BLOG_HOST}/exec/redirect.php?u=';
		for($i=0;$i<$len;$i++)	{
			$eurl .=$url[$i].mt_rand(0,9);
		}
	}
	return $eurl;
}

function GetExtension($file)
{
	$ext=strrchr($file,".");//return .jpg
	$format=strtolower($ext);
	return $format;
}

function GetItsThumb($srcf)
{
	$srcf = str_replace(MT_BLOG_HOST,'',$srcf);//Clear host address	
	$nail=dirname($srcf).'/thumb-'.basename($srcf);
	if(file_exists(ABSPATH.$nail)) {
		return $nail;
	}
	return $srcf;
}

//if($OldThumb!='' && $OldThumb!=$log_Thumb && file_exists(ABSPATH.$OldThumb))
//	@unlink(ABSPATH.$OldThumb);
function GetDisThumb($thumbsrc)
{	
	if($thumbsrc!='')
		return $thumbsrc;///upload/2014/01/123.jpg
	return ('/images/thumb-default.jpg');
}
//create thumb
//Example: ("http://localhost/2.jpg",100,100); -- NOT SUPPORT!!
//Example: ("/upload/2014/03/2.jpg",100,100); -- ONLY SUPPORT LOCAL FILE!!
//return: "/upload/2014/03/thumb_2.jpg"
/*
	$path = "/srv/html/abc.jpg";
	$file = basename($path);        // $file = "abc.jpg"
	$file = basename($path,".jpg"); // $file = "abc"
	$path = "http://123.com/html/abc.jpg";
	$dir = dirname($path);        // $dir = "http://123.com/html", or /srv/html
*/
function fnCreateThumb($srcf,$new_width,$new_height)//deprecated now!!!
{
	$cut=true;//cut is default
	$absfile = ABSPATH.$srcf;

	$InfArr = @getimagesize($absfile);//do not need gdlib
	if($InfArr==false) {
		echo "Error: getimagesize(".$sfile.")";
		return "";
	}
	
	if($InfArr[0]<=$new_width && $InfArr[1]<=$new_height) {//Do not create
		//@copy($sfile,ABSPATH.$dstimg);//just copy
		//return $dstimg;
		return $srcf;
	}
	
	//0- width, 1-height, 2- type
	//type: 1=GIF，2=JPG，3=PNG，4=SWF，5=PSD，6=BMP，7=...16 see more: http://php.net/getimagesize/)
	$tpID = $InfArr[2];
	switch($tpID) {
		case 1://GIF
		$im=@imagecreatefromgif($absfile);
		break;
		case 2://JPG
		$im=@imagecreatefromjpeg($absfile);
		break;
		case 3://PNG
		$im=@imagecreatefrompng($absfile);
		break;
		default:
		echo "Error: image type id(".$tpID.")";
		return "";
		break;		
	}	
	if(empty($im)) {
		echo "Error: create image(".$sfile.")";
		return '';
	}
	//$spic = str_replace(MT_BLOG_HOST,'',$sfile);//truncate path
	$dstimg=dirname($srcf).'/thumb-'.basename($srcf);
	
	$width=@imagesx($im);
	$height=@imagesy($im);

	$ratio = $width/$height;
	$n_ratio = $new_width/$new_height;
	if($cut) {//cut
		if($ratio>=$n_ratio) {//高度优先
			$newimg = imagecreatetruecolor($new_width,$new_height);
			@imagecopyresampled($newimg, $im, 0, 0, 0, 0, $new_width,$new_height, (($height)*$n_ratio), $height);
		}
		if($ratio<$n_ratio) {//宽度优先
			$newimg = imagecreatetruecolor($new_width,$new_height);
			@imagecopyresampled($newimg, $im, 0, 0, 0, 0, $new_width, $new_height, $width, (($width)/$n_ratio));
		}
	}else {//not cut
		if($ratio>=$n_ratio) {
			$newimg = imagecreatetruecolor($new_width,($new_width)/$ratio);
			@imagecopyresampled($newimg, $im, 0, 0, 0, 0, $new_width, ($new_width)/$ratio, $width, $height);
		}
		if($ratio<$n_ratio) {
			$newimg = imagecreatetruecolor(($new_height)*$ratio,$new_height);
			@imagecopyresampled($newimg, $im, 0, 0, 0, 0, ($new_height)*$ratio, $new_height, $width, $height);
	   }
	}
	//@imagecopyresized($im_s,$im,0,0,0,0,$newwidth,$newheight,$width,$height);改成imagecopyresampled，不会失真
	switch($tpID) {
		case 1://GIF
		@imagegif($newimg,ABSPATH.$dstimg);
		break;
		case 2://JPG
		@imagejpeg($newimg,ABSPATH.$dstimg);
		break;
		case 3://PNG
		@imagepng($newimg,ABSPATH.$dstimg);
		break;
		default:
		break;
	}	
	@imagedestroy($im);
	@chmod(ABSPATH.$dstimg,0777);
	return $dstimg;	
}

function fnGetThemeTpl($filename)
{	
	$f=ABSPATH.'/themes/default/'.$filename.'.html';
	return file_get_contents($f);
}

//写文件
function fnWriteCache($savefile,$content)
{	
	$e=explode('/',$savefile);//dirname 
	$pathlevel=count($e)-1;
	
	if($pathlevel>0) {//检查路径是否创建
		$deti=ABSPATH;
		for($i=0;$i<$pathlevel;$i++) {
			if($e[$i]!='') {
				$deti .= '/'.$e[$i];
				if(!is_dir($deti))
					@mkdir($deti, 0777) or die("创建".$deti."目录失败");
			}
		}
	}	
	$deti =ABSPATH.$savefile;
	if(!file_put_contents($deti,$content,LOCK_EX))	{
		echo "写入文件错误！".$savefile;
		exit;
	}
}

function fnGetMicroTime()//获取当前精确时间   
{    
	//microtime返回返回格式为“msec sec”的字符串，其中 sec 是当前的 Unix 时间戳，msec 是微秒部分。
	//本函数仅在支持 gettimeofday() 系统调用的操作系统下可用
	list($usec, $sec)=explode(" ",microtime());//以空格为标记分割字符串到数组    
	return ((float)$usec + (float)$sec);
}

//获取IP
function fnGetIp()
{
	if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
		$ip=getenv("HTTP_CLIENT_IP");
	else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
		$ip=getenv("HTTP_X_FORWARDED_FOR");
	else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
		$ip=getenv("REMOTE_ADDR");
	else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
		$ip=$_SERVER['REMOTE_ADDR'];
	else
		$ip="unknown";
   return($ip);
}

//截取编码为UTF8字符串
function fnSubstr($str, $start, $len=NULL) 
{ 
	$code="utf-8";
	if($code='utf-8')
	{ 
		//if (function_exists("mb_substr")) 
		//{ 				
		//	return mb_substr($str, $start, $length, "utf-8"); 
		//} 
		preg_match_all("/./u", $str, $ar); 	
		if(func_num_args()>= 3) 
		{ 
			if (count($ar[0])>$len)//如果第一个数组长度就大于将要读取的长度
				return join("",array_slice($ar[0],$start,$len)); 

			$end=func_get_arg(2); 
			return join("",array_slice($ar[0],$start,$end)); 
		}
		else
			return join("",array_slice($ar[0],$start)); 
	}
	else
	{ 
		$strlen=strlen($str);
		for ( $i=0; $i < $strlen; $i++ )
		{ 
			if ( $i >= $start && $i < ( $start+$len ) )
			{ 
				if ( ord(substr($str, $i, 1)) > 129 )
					$tmpstr .= substr($str, $i, 2);
				else
					$tmpstr .= substr($str, $i, 1);
			}
			if ( ord(substr($str, $i, 1)) > 129 ) 
				$i++;
		}
		if ( strlen($tmpstr) < $strlen and $other ) 
			$tmpstr .= "...";
		return $tmpstr;
	}
}

//格式页面导航，参数：总记录，当前页，每页数
//$nRow>0;
//$curPage>0
//$perPage>0
function fnPageFormat($nRows,$curPage,$perPage) {
	
	$url=$_SERVER["REQUEST_URI"];
	$purl=parse_url($url);
	$urladd="?page";//default
	if(isset($purl["query"])) {//query string
		$oldq=$purl["query"];
		$newq=preg_replace("/^page=\d+($|&)/","",$oldq);
		$newq=preg_replace("/&page=\d+/","",$newq);		
		$url=str_replace($oldq,$newq,$url);
		
		if($newq!='')
			$urladd="&page";
		else
			$url=substr($url,0,-1);//remove `?`
	}
	
	$totalp=intval($nRows/$perPage)+($nRows%$perPage==0?0:1);//total pages >0
	if($curPage<5) {//Max display clicks 9
		$ifrom=1;
		$ito=9;
	}else if(($totalp-$curPage)>=0 && ($totalp-$curPage)<5) {
		$ifrom=$totalp-9;
		$ito=$totalp;
	}else {
		$ifrom=$curPage-4;
		$ito=$curPage+4;	
	}
	if($ifrom<1)//exceed?
		$ifrom=1;
	if($ito>$totalp)//exceed?
		$ito=$totalp;	
		
	$pPage=$curPage-1;
	if($curPage==1){
		$pnavstr='<a>上一页</a>';
	}else{
		$pnavstr='<a id="pnav_lst" href="'.$url.$urladd.'='.$pPage.'" target=_self>上一页</a>';
	}
	for($i=$ifrom;$i<=$ito;$i++) {
		if($i==$curPage)
			$pnavstr.='<span id="pnav_curp">['.$i.']</span>';
		else {
			if($i=='1')//first page
				$pnavstr.='<a id="pnav_lst" href="'.$url.'" target=_self>['.$i.']</a>';
			else
				$pnavstr.='<a id="pnav_lst" href="'.$url.$urladd.'='.$i.'" target=_self>['.$i.']</a>';
		}
	}
	
	if($totalp>1)
		$pnavstr.='<a id="pnav_lst" href="'.$url.$urladd.'='.$totalp.'" target=_self>[»]</a>';		
	else
		$pnavstr.='<a id="pnav_lst" href="'.$url.'" target=_self>[»]</a>';

	return $pnavstr;
}

//*********************************************************
	
//解析替换模板
function fnParseTpl($reparr=array(),$content)
{	
	foreach($reparr as $krp=>$vrp)
		$content=str_replace("{".$krp."}",$vrp,$content);

	return $content;
}

function fnGetNickName($author_id)
{
	global $dbobj;

	$sqlstr = "SELECT mem_Nickname FROM ".TB_SEC_USER." WHERE Id='".$author_id."' LIMIT 0,1"; 
	$stmt = $dbobj->mydb_query($sqlstr);
	if($row = $stmt->fetch())
		return $row['uNick'];
	return '';
}


//php系统函数验证
function getphpfun($funName) 
{
	return (true == function_exists($funName)) ? "Support" : "Not Support";
}

//获取php配置信息
function getphpcfg($varname) 
{
	switch($res = get_cfg_var($varname)) {
		case 0:
		return "Off";break;
		case 1:
		return "On";break;
		default:
		return $res;break;
	}
}

//上传文件函数
function fnUploadFile($orifile,$tmpfile,$bRename=false)
{
	$utime=date('U');//Unix timestamp
	//Dir
	$savedir = '..'.MT_UPLOAD_DIRECTORY.'/'.date("Y",$utime)."/";
	if(!is_dir($savedir))
		@mkdir($savedir, 0777) or die("Create ".$savedir." Directory Failed!");
	$savedir .= date("m",$utime)."/";//e.g 05 12
	if(!is_dir($savedir))
		@mkdir($savedir, 0777) or die("Create ".$savedir." Directory Failed!");

	$orifile = strtolower($orifile);
	$ext  = GetExtension($orifile);//extension
	$desfile = $savedir.$orifile;
	
	if(@!is_uploaded_file($tmpfile) || @!move_uploaded_file($tmpfile ,$desfile)) {//上传文件
		@unlink($tmpfile);
		echo "Error: upload file.";//Try to check upload_max_filesize=2M in php.ini
		return "";
	}
	
	if($bRename) {//rename file
		do {
			$newname=date("YmdHis",$utime).mt_rand(1000,9999).$ext;
		}while(file_exists($savedir.$newname));//try a new name
		if(!rename($desfile,$savedir.$newname))	{				
			@unlink($desfile);
			echo "Error: rename file.";
			return "";
		}
	}
	else
		$newname=$orifile;
	
	return array($newname,$utime);
}

//格式化文件大小
function fnCustFileSize($filesize) 
{
	if($filesize >= 1073741824) 
		$filesize = round($filesize/1073741824,2).' Gb';
	elseif($filesize >= 1048576) 
		$filesize = round($filesize/1048576,2).' Mb';
	elseif($filesize >= 1024) 
		$filesize = round($filesize/1024, 2).' Kb';
	else 
		$filesize = $filesize.' Bytes';
	return $filesize;
}

//字符串检查替换
function fnTransferHTML($source,$para)
{	
	//&->&amp;	"->&quot;	<->&lt;		>->&gt;
	if(stristr($para,"[htmlspecial]"))
		$source=htmlspecialchars($source);
			 
	if(stristr($para,"[space]"))
		$source=str_replace(" ","&nbsp;",$source);
		
	if(stristr($para,"[enter]"))
	{
		$source=str_replace("\r","<br/>",$source);
		$source=str_replace("\n","<br/>",$source);
	}

	if(stristr($para,"[vbTab]"))
		$source=str_replace("\t","&nbsp;&nbsp;",$source);
		
	if(stristr($para,"[no-php]"))
	{
		$patterns =array("<?","?>");
		$replace=array("&lt;?","?&gt;");
		$source=preg_replace($patterns,$replace,$string); 
	}
	
	if(stristr($para,"[filename]") )
	{
		$patterns =array("/","\\",":","?","*","\"","<",">","|"," ","");  
		$source=preg_replace($patterns,'', $string); 
	}
	
	if(stristr($para,"[normalname]") )
	{
		$patterns =array("$","(",")","*","+",",","[","]","{","}","?","\\","^","|",":","\"","'","");
		$source=preg_replace($patterns,'',$string); 
	}
	
	if(stristr($para,"[textarea]"))
	{
		$patterns =array("&","%","<",">");
		$replace=array("&amp;","&#037;","&lt;","&gt;",);
		$source=preg_replace($patterns,$replace,$string); 
	}
	
	if(stristr($para,"[wapnohtml]") )
	{
		$patterns =array("<br/>","<br>","(<[^>]*)|([^<]*>)","(\r\n|\n)");
		$replace=array(vbCrLf,vbCrLf,'','<br/>');
		$source=preg_replace($patterns,$replace,$string); 
	}

	if(stristr($para,"[nbsp-br]") )
	{
		$pattern=array("&lt;$|&lt;b$|&lt;br$|&lt;br/$","^br/&gt;|^r/&gt;|^/&gt;|^&gt;","&lt;br/&gt;","&amp;nbsp;");
		$replace=array('','','<br/>',' ');
		$source=preg_replace($patterns,$replace,$string); 
	}
	
	if(stristr($para,"[upload]"))
	{
		$source=str_replace("src=\"/upload/",'src="'.MT_BLOG_HOST.MT_UPLOAD_DIRECTORY."/",$source);
		$source=str_replace("href=\"/upload/","href=\"".MT_BLOG_HOST.MT_UPLOAD_DIRECTORY."/",$source);
		$source=str_replace("value=\"/upload/","value=\"".MT_BLOG_HOST.MT_UPLOAD_DIRECTORY."/",$source);
		$source=str_replace("href=\"http:///upload/","href=\"".MT_BLOG_HOST.MT_UPLOAD_DIRECTORY."/",$source);
		$source=str_replace("(this.nextSibling,'upload/","(this.nextSibling,'".MT_BLOG_HOST.MT_UPLOAD_DIRECTORY."/",$source);
	}
	return $source;
}


function fnChkMember() {
	global $dbobj;		
	//$Id	=$_SESSION['AUTH_ID'];//member ID
	//改原来的程序试试
	$Id=isset($_SESSION['Id']) ? $_SESSION['Id'] : "";
	if(!empty($Id)) {
		$sqlstr="SELECT COUNT(*) FROM ".TB_SEC_USER." WHERE Id='$Id'";// AND uStatus='0'
		$stmt = $dbobj->mydb_query($sqlstr);
		$row = $stmt->fetch();
		$nRows = $row[0];
		if($nRows=='1')
			return;
	}
	unset($_SESSION['AUTH_ID']);
	fnCatchError();
}

//$selID = 0 means null
function GetVendList($selID, $changeFun) {
	global $dbobj;	
	$sqlstr="SELECT * FROM ".TB_SEC_VENDINFO." ORDER BY Id ASC";		
	$stmt = $dbobj->mydb_query($sqlstr);
		$vendop = '<select name="vendop" id="vendop" onchange="'.$changeFun.'">';
		$vendop .='<option value="0">请选择</option>';	
	while($row = $stmt->fetch()) {
		$c_ID	=$row['Id'];
	//	$c_Name	=$row['VendName'];
		$c_Name	=$row['Name'];
		$c_Intro=$row['VendIntro'];
		if($selID == $c_ID)
			$sel = ' selected="selected"';
		else
			$sel = '';
		$vendop .='<option value="'.$c_ID.'"'.$sel.'>'.$c_Name.'</option>';	
	}
	$vendop .= '</select>'; 
	return $vendop;
}

//$selID = 0 means null
function GetTplList($VendID, $selID) {
	global $dbobj;
	$sqlstr="SELECT TplID,TplName FROM ".TB_SEC_DATATPL." WHERE VendID = '$VendID'";

	$stmt = $dbobj->mydb_query($sqlstr);
	$tplop = '<select id="tplop" name="tplop">';
	while($row = $stmt->fetch()) {
		$c_TplID=$row['TplID'];
		$c_TplName=$row['TplName'];
		if($selID == $c_TplID)
			$sel = ' selected="selected"';
		else
			$sel = '';
		$tplop .='<option value="'.$c_TplID.'"'.$sel.'>'.$c_TplName.'</option>';	
	}
	$tplop .= '</select>'; 
	return $tplop;
}

//发送和接收数据包
function fnSendPacket($hosturl,$data) 
{
	$uinfo=parse_url($hosturl);
	if($uinfo['query']) {
		$data .= "&".$uinfo['query'];
	}
	if(!$fsp=@fsockopen($uinfo['host'], (($uinfo['port']) ? $uinfo['port'] : "80"), $errno, $errstr, 3)) {
		return false;
	}
	//echo '<pre>';print_r($uinfo);exit;
	fputs ($fsp, "POST ".$uinfo['path']." HTTP/1.0\r\n");
	fputs ($fsp, "Host: ".$uinfo['host']."\r\n");
	fputs ($fsp, "Content-type: text/xml\r\n");
	//fputs ($fsp, "Content-type: application/x-www-form-urlencoded\r\n");
	fputs ($fsp, "Content-length: ".strlen($data)."\r\n");
	fputs ($fsp, "Connection: close\r\n\r\n");
	fputs ($fsp, $data);
	$http_response='';
	while(!feof($fsp)) {
		$http_response .= fgets($fsp, 128);
	}
	@fclose($fsp);
	//echo htmlspecialchars($http_response).'<br/>';	
	list($resp_headers, $resp_content)=explode("\r\n\r\n", $http_response);//劈开头和内容	
	return $resp_content;
}

?>