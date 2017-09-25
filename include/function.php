<?php
function outData($code = "",$message = "",$data = "",$jsonp=false){
	  if($jsonp===false) exit(json_encode(array('code' => $code,'message' =>$message,'data'=>$data)));
	  $callback = $this->request->getParameter('callback');
	  if(!ctype_alnum(str_replace("_","",$callback))) return  json_encode(array('code' => -5,'message' =>"非法请求",'data'=>''));
	  if(empty($callback)){
		  exit(json_encode(array('code' => $code,'message' =>$message,'data'=>$data)));
	  }else{
		  $text = json_encode(array('code' => $code,'message' =>$message,'data'=>$data));
		  exit("$callback('$text');");
	  }
  }
 
//编辑器里的图片替换
function embed_images(&$body)
{
    // get all img tags
    preg_match_all('/<img.*?>/', $body, $matches);
    if (!isset($matches[0])) return;
    // foreach tag, create the cid and embed image
    $i = 1;
    foreach ($matches[0] as $img)
    {
        // make cid
        $id = 'img'.($i++);
        // replace image web path with local path
        preg_match('/src="(.*?)"/', $body, $m);
        if (!isset($m[1])) continue;
        $arr = parse_url($m[1]);
        if (!isset($arr['host']) || !isset($arr['path']))continue;
        // add
        $this->AddEmbeddedImage('/home/username/'.$arr['host'].'/public'.$arr['path'], $id, 'attachment', 'base64', 'image/jpg');
        $body = str_replace($img, '<img alt="" src="cid:'.$id.'" style="border: none;" />', $body); 
    }
	return $body;
}
 
 
  
  
  
  
//获取天数去掉周六，周天
function get_days ($date="",$day)
{
    $now = empty($date)?time():strtotime($date);
    $days = array();
    $i = 0;
    while($i<$day)
    {
        $timer = $now+3600*24*$i;
        $num= date("N",$timer)-2; //周一开始

        if($num>=-1 and $num<=3)
        {
            $days[]=date("Y-m-d",$now+3600*24*$i);
        }
        $i++;
    }

 return count($days);  //给数组的长度
}  
 
 
//获取除去休息的天数
function get_somedays ($date="",$day)
{
    $now = empty($date)?time():strtotime($date);
    $days = array();
    $i = 0;
    while($i<$day)
    {
        $timer = $now+3600*24*$i;
        $num= date("N",$timer)-2; //周一开始

       
            $days[]=date("Y-m-d",$now+3600*24*$i);
        
        $i++;
    }

 return $days;  //给数组的长度
}  
  
  
//上一月份，下一月份的时间获出  
function GetMonth($sign="1")  
{  
	
   //得到系统的年月  
    $tmp_date=date("Y-m");  
    //切割出年份  
    $tmp_year=substr($tmp_date,0,4);  
   //切割出月份  
    $tmp_mon =substr($tmp_date,5,2);  
    $tmp_nextmonth=mktime(0,0,0,$tmp_mon+1,1,$tmp_year);  
    $tmp_forwardmonth=mktime(0,0,0,$tmp_mon-1,1,$tmp_year);  
   if($sign==0){  
        //得到当前月的下一个月   
       return $fm_next_month=date("Y-m-d",$tmp_nextmonth);          
   }else{  
        //得到当前月的上一个月   
        return $fm_forward_month=date("Y-m-d",$tmp_forwardmonth);           
   }  
}  
  
  
  
  
//读取文件列表
function showfile($dir){
	$hander=opendir($dir);
	$arr=array();
	while(($file=readdir($hander))!==false){
		if($file!="." && $file!=".."){
			  if(is_file($dir."/".$file)){
				 $arr['file'][]=mb_convert_encoding($file, "UTF-8", "gb2312");  //中文会乱码要转码
			  }
			  if(is_dir($dir."/".$file)){
				 $arr['dir'][]=mb_convert_encoding($file, "UTF-8", "gb2312"); 
			  }
 	  }
	}
	closedir($hander);
	return $arr;
	
} 
  
  
  
//中文名按拼音排序
function getname($data,$name="admin"){
	  //姓名的排序，转成字符串后再转成GBK
	foreach ($data as $key=>$value){
	   $str=$value['name'];
	   if($value['name']!=$name && $value['name']!="admin") $new_array[$key] = iconv('UTF-8', 'GBK', $str);
    }
    asort($new_array); //按字母的小大
  	 foreach ($new_array as $value){
       $data1[] = iconv('GBK', 'UTF-8', $value);
  	 }
	return $data1;
}
  
  
  

function pst($m){
	$n=isset($_POST[$m]) ? $_POST[$m] : "";	
	return  $n;
}
//导出
function exout($data=array(),$title=array()){
        header("Content-type:application/octet-stream");
		header("Accept-Ranges:bytes");
		header("Content-type:application/vnd.ms-excel");  
		header("Content-Disposition:attachment;filename=".date("Y-m-d").".xls");
		header("Pragma: no-cache");
		header("Expires: 0");	
		if (!empty($title)){
			foreach ($title as $k => $v) {
				$title[$k]=iconv("UTF-8", "GB2312//IGNORE",$v);
			}
			$title= implode("\t", $title);
			echo "$title\n";
		}
		if (!empty($data)){
			foreach($data as $key=>$val){
				foreach ($val as $ck => $cv) {
					$data[$key][$ck]=iconv("UTF-8", "GB2312//IGNORE", $cv);
				}
				$data[$key]=implode("\t", $data[$key]);
				
			}
			echo implode("\n",$data);
		}

}
//excel导出
function excelout($data=array(),$data2=array()){
	  header("Content-type:application/octet-stream");
		header("Accept-Ranges:bytes");
		header("Content-type:application/vnd.ms-excel");  
		header("Content-Disposition:attachment;filename=".date("Y-m-d").".xls");
		header("Pragma: no-cache");
		header("Expires: 0");			
		echo '<table style="border:0.5px solid #000; font-size:15px;font-family:宋体;"><thead><tr><td>时间</td>';
					echo '<td style="border:0.5px solid #000" >发起人</td>';
					echo '<td style="border:0.5px solid #000" >工作任务</td>';
					echo '<td style="border:0.5px solid #000" >任务描述/跟进记录</td>';  
					echo '<td style="border:0.5px solid #000" >计划周期</td>';
					echo '<td  style="border:0.5px solid #000" >实际完成时间</td>';
					echo '</tr></thead><tbody class="showPlaning">';
					foreach($data as $k=>$v){
						echo	"<tr><td style='border:0.5px solid #000'>[wk".$v['weeks']."]".$v['btime']."</td>";
						echo	"<td style='border:0.5px solid #000'>".$v['name']."</td>";
						echo	"<td style='border:0.5px solid #000'>".$v['task']."</td>";
						echo	"<td style='border:0.5px solid #000'>".$v['condi']."-".$v['des']."</td>";
						echo	"<td style='border:0.5px solid #000'>".$v['startime']."-".$v['endtime']."</td>";
						echo  	"<td style='border:0.5px solid #000'>".$v['finishtime']."</td>";
						echo	"</tr>";
					}
					echo '</tbody></table>';
					echo '<table style="border:0.5px solid #000; font-size:15px;font-family:宋体;"><thead><tr><td>时间</td>';
					echo '<td  style="border:0.5px solid #000" >协作人</td>';
					echo '<td  style="border:0.5px solid #000" >协作任务</td>';
					echo '<td  style="border:0.5px solid #000" >任务描述/跟进记录</td>'; 
					echo '<td  style="border:0.5px solid #000" >要求-实际完成时间</td>';
					echo '</thead><tbody class="showPlaning">';			
					foreach($data2 as $k2=>$v2){
						echo	"<tr><td style='border:0.5px solid #000'>[wk".$v2['weeks']."]".$v2['btime']."</td>";
						echo	"<td style='border:0.5px solid #000'>".$v2['obl']."</td>";
						echo	"<td style='border:0.5px solid #000'>".$v2['task2']."</td>";
						echo	"<td style='border:0.5px solid #000'>".$v2['condi']."-".$v2['des']."</td>";
						echo	"<td style='border:0.5px solid #000'>".$v2['ytime']."-".$v2['finishtime']."</td>";
						echo	"</tr>";
					}
				  echo "</tbody></table>";
		
		
		
	/*	
		if (!empty($title)){
			foreach ($title as $k => $v) {
				$title[$k]=iconv("UTF-8", "GB2312//IGNORE",$v);
			}
			$title= implode("\t", $title);
			echo "$title\n";
		}
		if (!empty($data)){
			foreach($data as $key=>$val){
				foreach ($val as $ck => $cv) {
					$data[$key][$ck]=iconv("UTF-8", "GB2312//IGNORE", $cv);
				}
				$data[$key]=implode("\t", $data[$key]);
				
			}
			echo implode("\n",$data);
		}
	*/
}	

  
  
  
//根据用户取模版
function getUser(){
	if(!isset($_SESSION['name'])){
		exit ("<script>window.location.href='error.php'</script>");
	}
	$db = new Mysql();
	$db->connect(DB_HOST,DB_USER,DB_PWD,DB_NAME,DB_CHARSET,1);	
	$name =$_SESSION['name'];
	$data=$db->find("select id,name,groupid,state from ".DB_PREFIX."user where name='".$name."' limit 1");
	$groupid=$data['groupid'];	
	$config=$db->findAll("select * from ".DB_PREFIX."card where groupid=".$groupid);
	//$config=$db->findAll("select * from ".DB_PREFIX."menu where groupid=2");
	//$config=json_encode($config);	
	//if(!defined('CONFIG')) define('CONFIG',$config);
	return $config;
}   
  
//判断是否有权限
function isauth($id){
	$con=getUser();
		 $add="";
		 $del="";
		 $upd="";
		 $sel="";
		 $groupid=3;  //默认是3用户组
		foreach($con as $k=>$v){
			if($id==$v['carid']){
				if(!strpos($v['auth'], "A")) $add="none";
				if(!strpos($v['auth'], "D")) $del="none";	
				if(!strpos($v['auth'], "U")) $upd="none";
				if(!strpos($v['auth'], "S")) $sel="none";
				$groupid = $v['groupid'];
			} 	
		}	
		$arr=array(
		"add"=>$add,
		"del"=>$del,
		"upd"=>$upd,
		"sel"=>$sel,
		"groupid" =>$groupid
		);
	return $arr;  
	
} 
  

//查找子孙树
function tree($arr,$carid=0,$lev=1){
	 $son=array();  
        foreach($arr as $val){  
            if($val['parentsid']==$carid){  
               $son[]=$val;
			   $val['lev']=$lev;
			   $son=array_merge($son,tree($arr,$val['carid'],$lev+1));
         }  
      }  
      return $son;  
}

//查找家谱树
function fratree($arr,$carid,$lev=1){
	 $son=array();  
        foreach($arr as $val){
				if($val['carid']==$carid){  
				   $son[]=$val;
				   $val['lev']=$lev;
				   $son=array_merge($son,fratree($arr,$val['parentsid'],$lev+1));
				}  
		 
      }  
	 // return $son; 
      return $son; 
	  
}
   
   //翻转数组
	function array_rev($arr){
	  $temp=array();  
      for($i=count($arr)-1;$i>=0;$i--){
         if(is_array($arr[$i])){   //这里判断是否为数组
              $temp1 = array_rev($arr[$i]);  //若为数组则开始调用自身
              $temp[] = $temp1;
              continue;
         }
          $temp[] = $arr[$i];
      }
      return $temp;
  }
  
    //翻转数组
	function array_revvs($arr){
	  $temp=array();  
      for($i=count($arr)-1;$i>=0;$i--){
         // if(is_array($arr[$i])){   //这里判断是否为数组
           //   $temp1 = array_rev($arr[$i]);  //若为数组则开始调用自身
          //    $temp[] = $temp1;
         //     continue;
        //  }
          $temp[] = $arr[$i];
      }
      return $temp;
  }
  
  
  
  
  
//过虑非法字符串,html
function uh($str) 
{ 
    $farr = array( 
        "/\s+/",                                                                       //过滤多余的空白 
        "/<(\/?)(script|i?frame|style|html|body|title|link|meta|\?|\%)([^>]*?)>/isU",  //过滤 <script 等可能引入恶意内容或恶意改变显示布局的代码,如果不需要插入flash等,还可以加入<object的过滤 
        "/(<[^>]*)on[a-zA-Z]+\s*=([^>]*>)/isU",                                      //过滤javascript的on事件 
      
   ); 
   $tarr = array( 
        " ", 
        "＜\\1\\2\\3＞",           //如果要直接清除不安全的标签，这里可以留空 
        "\\1\\2", 
   ); 
}
//例用 $str=preg_replace($farr,$tarr,$str);
  
  
//判断是手机端还是PC端
function isMobile()
{ 
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
    {
        return true;
    } 
    // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset ($_SERVER['HTTP_VIA']))
    { 
        // 找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    } 
    // 脑残法，判断手机发送的客户端标志,兼容性有待提高
    if (isset ($_SERVER['HTTP_USER_AGENT']))
    {
        $clientkeywords = array ('nokia',
            'sony',
            'ericsson',
            'mot',
            'samsung',
            'htc',
            'sgh',
            'lg',
            'sharp',
            'sie-',
            'philips',
            'panasonic',
            'alcatel',
            'lenovo',
            'iphone',
            'ipod',
            'blackberry',
            'meizu',
            'android',
            'netfront',
            'symbian',
            'ucweb',
            'windowsce',
            'palm',
            'operamini',
            'operamobi',
            'openwave',
            'nexusone',
            'cldc',
            'midp',
            'wap',
            'mobile'
            ); 
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
        {
            return true;
        } 
    } 
    // 协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT']))
    { 
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
        {
            return true;
        } 
    } 
    return false;
} 

  
?>