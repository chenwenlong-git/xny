var SE={};

SE.inviteId = [];
window._overlay_pass = null;


//打印模版创建
SE.ptpl =function(){
	var width=$(".width").val();
	var height=$(".height").val();
	var href=$(".href").val();
	var num=$(".num").val();  
	num=num.substring(1);
	var arr=num.split("-");
	count= arr.length;
	var i=0;
	var val="";
	var left="";
	var top="";
	var fsize="";
	var ffamily="";
	for(i;i<count;i++){	
		 val+="|-|"+$(".inp"+arr[i]+">.in").val();
		 left+="-"+$(".inp"+arr[i]+">.in").offset().left;
		 top+="-"+$(".inp"+arr[i]+">.in").offset().top;
		 fsize+="-"+$(".inp"+arr[i]+">.in").css("font-size").replace("px","");
		 ffamily+="-"+$(".inp"+arr[i]+">.in").css("font-family");
	}
	$.ajax({
		type: 'POST',
		url: "/ajax.php?act=ptpl",
		dataType: 'json',
		async:false,
		data: {		
			count:count,
			val:val,
			left:left,
			top:top,
			fsize:fsize,
			ffamily:ffamily,
			width:width,
			height:height,
			href:href
			
		},
		success: function(e) {
				if(e.code==1){		
					alert(e.message);
				}
				else{						
					alert(e.message);			
				}		
		}
	});			
	
	
}



//得到用户资料信息
SE.seluser =function(page){
		page=page || 1;
		$.ajax({
		type: 'POST',
		url: "/ajax.php?act=seluser",
		dataType: 'json',
		async:false,
		data: {		
			page:page
			
		},
		success: function(e) {
				if(e.code==1){		
					var stringHtml = "<tr class='tr_tit'><td>用户名</td><td>手机号码</td><td>邮箱地址</td><td>注册时间</td></tr>";
					$.each(e.data,function(i,v){
							stringHtml+="<tr><td>"+v['uName']+"</td>";
							stringHtml+="<td>"+v['Mobile']+"</td>";
							stringHtml+="<td>"+v['Email']+"</td>";		
							stringHtml+="<td>"+v['RegTime']+"</td></tr>";					
					})					
					$(".alluseryinfo").html(stringHtml);				
					$(".totel").html("总记录数"+e.message[0]['num']+"条");						
					$(".tcdPageCode").createPage({
						pageCount:e.message[1]['sum'],//总页数
						current:page, //当前页
						backFn:function(p){ //p点击的页面
							SE.seluser(p);
							
						}
					});
					
				}
				else{						
					alert(e.message);			
				}		
		}
	});		
	

}

//修改用户信息
SE.chinfo = function(){
	var phone=$('.phone').val();
	var email=$('.email').val();
	var VendAddr=$('.VendAddr').val();
	var Contacter=$('.Contacter').val();
	var VendTelphone=$('.VendTelphone').val();
	var VendIntro=$('.VendIntro').val();
	var VendInvitCode=$('.VendInvitCode').val();
	var Name=$('.Name').val();
		$.ajax({
		type: 'POST',
		url: "ajax.php?act=chinfo",
		dataType: 'json',
		async:false,
		data: {		
			phone:phone,
			email:email,
			VendAddr:VendAddr,
			Contacter:Contacter,
			VendTelphone:VendTelphone,
			VendIntro:VendIntro,
			VendInvitCode:VendInvitCode,
			Name:Name
		},
		success: function(e) {
				if(e.code==1){		
					alert(e.message);
				}
				else{						
					alert(e.message);			
				}		
		}
	});			
}

//所有用户基本信息
SE.alluserinfo =function(page,n){
	    val=$('.alluser option:selected').val();
		role =val;
		page =page || 1;	
		$.ajax({
		type: 'GET',
		url: "../ajax.php?act=alluserinfo",
		dataType: 'json',
		async:false,
		data: {		
			page:page,		
			role:role
		},
		success: function(e) {
				if(e.code==1){		
					var stringHtml = "<tr class='tr_tit'><td>用户名</td><td>手机号码</td><td>邮箱地址</td><td>注册时间</td></tr>";
					$.each(e.data,function(i,v){
							stringHtml+="<tr><td>"+v['uName']+"</td>";
							stringHtml+="<td>"+v['Mobile']+"</td>";
							stringHtml+="<td>"+v['Email']+"</td>";		
							stringHtml+="<td>"+v['RegTime']+"</td></tr>";					
					})					
					$(".alluseryinfo").html(stringHtml);				
					$(".totel").html("总记录数"+e.message[0]['num']+"条");						
					$(".tcdPageCode").createPage({
						pageCount:e.message[1]['sum'],//总页数
						current:page, //当前页
						backFn:function(p){ //p点击的页面
							SE.alluserinfo(p);
							
						}
					});
							
				}
				else{						
					alert(e.message);
					window.open('../login.php','_top');
				}		
		}
	});		
}	





//普通用户登陆显示信息
SE.showuserinfo =function(){		
		$.ajax({
		type: 'POST',
		url: "../ajax.php?act=showuserinfo",
		dataType: 'json',
		async:false,
		data: {				
		},
		success: function(e) {
				if(e.code==1){				
				var	la ="<tr class='tr_tit'><td>最新产品</td><td>最热产品</td></tr>";			
					la +="<tr><td>"+e.data['new']+"</td><td>"+e.data['hot']+"</td></tr>";			
					$(".userauthinfo").html(la);	
					
				var li ="<tr class='tr_tit'><td colspan='2'>基本资料</td></tr>"
					li +="<tr class='tr_tit'><td>用户名</td><td>"+e.data['name']+"</td></tr>";
					li +="<tr class='tr_tit'><td>注册邮箱</td><td>"+e.data['Email']+"</td></tr>";
					li +="<tr class='tr_tit'><td>注册手机</td><td>"+e.data['Mobile']+"</td></tr>";
					li +="<tr class='tr_tit'><td>是否授权</td><td>"+e.data['PrivilLevel']+"</td></tr>";	
					li +="<tr class='tr_tit'><td>授权厂商</td><td>"+e.data['VendName']+"</td></tr>";		
					
					$(".userinfo").html(li);	
							
				}
				else{						
					alert(e.message);
					window.open('../login.php','_top');
				}		
		}
	});		
}	



//厂家登陆显示信息
SE.showveninfo =function(page){	
    page = page || 1;
	$.ajax({
		type: 'GET',
		url: "../ajax.php?act=showveninfo",
		dataType: 'json',
		data: {
			page:page					
		},
		success: function(e) {
			if(e.code=1){
				var stringHtml = "<tr class='tr_tit'><td>产品名称</td><td>产品编号 </td><td>模板编号</td><td>查询次数</td><td>产品上线时间</td></tr>";
					$.each(e.data.list,function(i,v){
							stringHtml+="<tr><td>"+v['ProName']+"</td>";
							stringHtml+="<td>"+v['ProPN']+"</td>";	
							stringHtml+="<td>"+v['TplID']+"</td>";								
							stringHtml+="<td>"+v['QtyCount']+"</td>";		
							stringHtml+="<td>"+v['RegTime']+"</td></tr>";					
					})					
				$(".veninfo").html(stringHtml);
				
				$(".totel").html("总记录数"+e.message+"条");						
				$(".tcdPageCode").createPage({
					pageCount:e.data.pageCount,//总页数
					current:page, //当前页
					backFn:function(p){ //p点击的页面
						SE.showveninfo(p);
					}
				});
			}
			else{					
					alert(e.message);
					window.open('../login.php','_top');
				}	
		}
	});	
}




//二级联动
SE.selPro = function(n){
	var Id =n
	if(Id==0){
		 var li="";
		 li+="<option value ='0'>请选择</option> ";
		 $(".proname").html(li);
		 return;
	}
	$.ajax({
		type: 'POST',
		url: "ajax.php?act=selPro",
		dataType: 'json',
		async:false,
		data: {		
			Id:Id
		},
		success: function(e) {
				if(e.code==1){
					var li="";
					$.each(e.data,function(i,v){
					  li+="<option value ="+v['ProName']+">"+v['ProName']+"</option> ";
					})		
					$(".proname").html(li);
				}				
				else {			
					alert(e.message);
						li+="<option value ='0'>请选择</option> ";
						$(".proname").html(li);
				}			
		}
	});	

}




//显示质量分析的结果
SE.fenrel=function(){
	$.ajax({
		type: 'POST',
		url: "ajax.php?act=datasel",
		dataType: 'json',
		async:false,
		data: {		
			proname:proname,
			fen:fen,
			login_item:login_item,
			bgtime:bgtime,
			endtime:endtime
		},
		success: function(e) {
				if(e.code==1){
					//alert(e.message);
					SE.inviteId=e.data;
				//window.open('/data_anal.php');
					window.location.href="/data_anal.php";	
				}				
				else {			
					//window.location.href="data_anal.php";	
					alert(e.message);		
				}			
		}
	});	
}






//质量查询
SE.datasel=function(){
	var proname =$(".proname option:selected").html();
	var fenhtml =$(".fen option:selected").html();
	var fen =$(".fen option:selected").val();
	var login_item = $("input[name='rd']:checked").val();
	var bgtime =$("#bgtime").val();
	var endtime=$("#endtime").val();
	$.ajax({
		type: 'POST',
		url: "ajax.php?act=datasel",
		dataType: 'json',
		async:false,
		data: {		
			proname:proname,
			fen:fen,
			login_item:login_item,
			bgtime:bgtime,
			endtime:endtime
		},
		success: function(e) {
				if(e.code==1){
					//alert(e.message);
					SE.inviteId=e.data;
				//window.open('/data_anal.php');
					window.location.href="/data_anal.php";	
				}				
				else {			
					//window.location.href="data_anal.php";	
					alert(e.message);		
				}			
		}
	});
}


//通过邮件找回重置密码
SE.emcode=function(){
	var pas =$(".pas").val();
	var rpas =$(".rpas").val();
	var username =$(".username").val();
	var keypas=$(".keypas").val();
	$.ajax({
		type: 'POST',
		url: "ajax.php?act=emcode",
		dataType: 'json',
		async:false,
		data: {		
			pas:pas,
			rpas:rpas,
			username:username,
			keypas:keypas
		},
		success: function(e) {
				if(e.code==1){
					alert(e.message);			
					window.open('/index.html','_top');
				}				
				else {				
					alert(e.message);		
				}			
		}
	});
}

//忘记密码邮件找回
SE.sendemail=function(){
	var ename =$(".ename").val();
	var useremail =$(".useremail").val();
	
	$.ajax({
		type: 'POST',
		url: "ajax.php?act=sendemail",
		dataType: 'json',
		async:false,
		data: {		
			ename:ename,
			useremail:useremail
		},
		success: function(e) {
				if(e.code==1){
					alert(e.message);		
					window.open('/index.html','_top');
				}				
				else {				
					alert(e.message);		
				}			
		}
	});
}



//退出登陆
SE.layout=function(){
	alert(22);
	$.ajax({
		type: 'POST',
		url: "ajax.php?act=layout",
		dataType: 'json',
		async:false,
		data: {		
		},
		success: function(e) {
				if(e.code==1){		
					window.open('/index.html','_top');
				}				
				else {				
					alert(e.message);		
				}			
		}
	});

}




//修改密码
SE.chcode=function(){
	var oldpas=$(".oldpas").val();
	var pas=$(".pas").val();
	var rpas=$(".rpas").val();	
	$.ajax({
		type: 'POST',
		url: "ajax.php?act=chcode",
		dataType: 'json',
		async:false,
		data: {
			old:oldpas,
			pas:pas,
			rpas:rpas
		},
		success: function(e) {
				if(e.code==1){		
					alert(e.message);
					$(".oldpas").val("");
					$(".pas").val("");
					$(".rpas").val("");
				}
				else if(e.code==3){
					alert(e.message);
					window.location.href='/login.php';		
				}
				
				else {				
					alert(e.message);		
				}
				
		}

	});

}

//弹窗
SE.findPassDialog = function(){
	_overlay_pass = $.dialog({
		title:'找回密码',//'',
		content:"<div class='find'>&nbsp&nbsp&nbsp用户名:<input type='text' class='ename'><div style='width:20px;height:20px;'></div>邮箱地址:<input type='text' class='useremail'></div>",
		height:170,
		width:420,
		cancel:function(){return true;},
		close: function(){
			this.hide();
			return false;
		},
		ok:function(){
			SE.sendemail();
			return false;
		}
	});
	
}






//登陆
SE.login=function(){
	
	var username=$(".username").val();
	var password=$(".password").val();
	var code=$(".code").val();
	$.ajax({
		type: 'POST',
		url: "ajax.php?act=login",
		dataType: 'json',
		async:false,
		data: {
			username:username,
			password:password,
			code:code
			
		},
		success: function(e) {
				if(e.code==1){					
				    window.open('/customer.php','_top');				
				}
				else{			
					alert(e.message);
					$(".img").attr("src","code.php?act="+Math.random());
				}
		
		}

	});
}
//注册
SE.reg=function(){
	var role=$(".sel option:selected").val();
	var vename=$(".vename").val()
	var person=$(".person").val()
	var mobile=$(".mobile").val()
	var addre=$(".addre").val()
	
	var rusername=$(".rusername").val().replace(/\s/g,'');
	var rpassword=$(".rpassword").val().replace(/\s/g,'');
	var rrpassword=$(".rrpassword").val().replace(/\s/g,'');
	var remail=$(".remail").val().replace(/\s/g,'');
	var rcode=$(".rcode").val().replace(/\s/g,'');
	var codeReg = /^[A-Za-z0-9]{4}$/;
	var phone = $(".phone").val();
	var phoneReg = /^(((17[0-9]{1})|(13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1})|(14[0-9]{1}))+\d{8})$/;
	var mailReg = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/;
	$.ajax({
		type: 'POST',
		url: "ajax.php?act=reg",
		dataType: 'json',
		async:false,
		data: {
			role:role,
			addre:addre,
			mobile:mobile,
			person:person,
			vename:vename,
			phone:phone,
			rusername:rusername,
			rpassword:rpassword,
			rrpassword:rrpassword,
			phone:phone,
			remail:remail,
			rcode:rcode
			
		},
		success: function(e) {
				if(e.code==1){	
					alert(e.message);								
					window.open('/customer.php','_top');					
				}
				else{						
					alert(e.message);
					$(".img").attr("src","code.php?act="+Math.random());
				}	
		}
	});
}


//用户预留信息表
SE.userauthinfo=function(page){
		page = page || 1;	
		$.ajax({
		type: 'GET',
		url: "../ajax.php?act=userauthinfo",
		dataType: 'json',
		async:false,
		data: {	
			page:page				
		},
		success: function(e) {
				if(e.code==1){							
					var li = "<tr class='tr_tit'><td>用户名</td><td>授权权限等级</td><td>权限</td><td>授权人员</td><td>授权或修改信息</td><td>创建时间</td><td>操作</td></tr>";
					$.each(e.data,function(i,v){
							
							li+="<tr><td>"+v['ReservedInfo']+"</td>";
							li+="<td>"+v['PrivilLevel']+"</td>";
							li+="<td>"+v['Auth']+"</td>";
							li+="<td>"+v['AuthoPerson']+"</td>";						
							li+="<td>"+v['Record']+"</td>";
							li+="<td>"+v['Time']+"</td>";
							li+="<td><a href='authoreidt.php?act="+v['Id']+"'>编辑</a>   <a href='javascript:;' onclick='SE.vendel("+v['Id']+",2)'>删除</a></td>";
							
					})			
				$(".useryinfo").html(li);
						
				$(".totel").html("总记录数"+e.message[0]['num']+"条");						
				$(".tcdPageCode").createPage({
					pageCount:e.message[1]['pageCount'],//总页数
					current:page, //当前页
					backFn:function(p){
						SE.userauthinfo(p);
					}
				});	
				}
				else{					
					alert(e.message);
				}		
		}
	});	
}


//厂商信息
SE.veninfo=function(page){	
		page = page || 1;	
		$.ajax({
		type: 'GET',
		url: "../ajax.php?act=veninfo",
		dataType: 'json',
		async:false,
		data: {
			page:page		
		},
		success: function(e) {
				if(e.code==1){		
					var ll="";		
					var VendIntro="";	
					var li = "<tr class='tr_tit'><td width='12%' align='left'>厂商名称</td><td width='25%' align='left'>厂商简介</td><td width='11%'>手机号码</td><td width='10%'>邮箱地址</td><td width='10%'>注册时间</td><td width='5%'>是否审批</td><td width='7%'>权限</td><td width='10%'>用户预留信息</td><td width='8%'>操作</td> </tr>";
					$.each(e.data,function(i,v){
							li+="<tr><td>"+v['Name']+"</td>";
							if(v['VendIntro'].length>=30){
							  VendIntro=v['VendIntro'].substring(0,30)+"..."
							}else{
								VendIntro=v['VendIntro']
							}
							li+="<td class='vendtro' onmouseover='mover(event,"+i+")' onmouseout='mout(event,"+i+")' style='cursor:pointer'>"+VendIntro+"</td>";
						    ll+="<div class='mousover"+i+"' style='word-break:break-all;width:400px;background:#FFC;display:none;position:fixed;z-index:200' >"+v['VendIntro']+"</div>"
							
							li+="<td>"+v['Phone']+"</td>";
							li+="<td>"+v['Email']+"</td>";
							li+="<td>"+v['RegTime']+"</td>";
							if(v['State']==1){
								li+="<td>是</td>";
							}else{
								li+="<td>否</td>";
							}
							if(v['Auth']==""){
							li+="<td>---</td>";
							}else{
								li+="<td>"+v['Auth']+"</td>";
							}
							li+="<td><a href='vendauthor.php?vid="+v['Id']+"'>查看</a></td>";
							li+="<td><a href='eidt.php?act="+v['Id']+"'>审批</a>   <a href='javascript:;' onclick='SE.vendel("+v['Id']+",0)'>删除</a></td></tr>";
					   
					})			
				$(".useryinfo").html(li);	
				$(".useryinfo").append(ll);					
				$(".totel").html("总记录数"+e.message[0]['num']+"条");						
				$(".tcdPageCode").createPage({
					pageCount:e.message[1]['pageCount'],//总页数
					current:page, //当前页
					backFn:function(p){
						SE.veninfo(p);
					}
				});		
				}
				else{					
					alert(e.message);
				}		
		}
	});	
}

//鼠标移进去显示内容
function mover(e,i){
   h=setTimeout(function(){
   var x=e.pageX+20
   var y=e.pageY
	$(".mousover"+i+"").show();
	$(".mousover"+i+"").css({"left":x,"top":y});
	},1000)
};
//鼠标移出显示内容
function mout(e,i){
	clearTimeout(h);
	$(".mousover"+i+"").hide();
};


//删除
SE.vendel=function(n,venau){
		var sure=confirm("确认删除吗?\n绑定的模板和产品也会删除，一旦删除不可恢愎");
		if(!sure) return;
		var venid=n;
		var venau=venau;
		$.ajax({
		type: 'POST',
		url: "../ajax.php?act=vendel",
		dataType: 'json',
		async:false,
		data: {
			venid:venid,
			venau:venau
					
		},
		success: function(e) {
				if(e.code==1){				
					alert(e.message);
					if(e.data==1) window.location.href='/vendor/vendor.php';	
					if(e.data==2) window.location.href="/vendor/vendauthor.php";
				
				}
				else{					
					alert(e.message);
				}		
		}
	});	
	
}

//厂商修改信息
SE.veneidt=function(){
		var prodect="";
		var data_anal="";
		var order="";
		var email='';
		var dash='';
		var isprodect=$(".prodect").is(":checked");
		if(isprodect) prodect=$(".prodect").attr("value");
		
		var isdata_anal=$(".data_anal").is(":checked");
		if(isdata_anal) data_anal=$(".data_anal").attr("value");
		
		var isorder=$(".order").is(":checked");
		if(isorder) order=$(".order").attr("value");
		
		var isemail=$(".email").is(":checked");
		if(isemail) email=$(".email").attr("value");
		
		var isdash=$(".dash").is(":checked");
		if(isdash) dash=$(".dash").attr("value");
		
		var auth = prodect+data_anal+order+email+dash;
		
		var approval=$(".approval option:selected").val();
		var venname=$(".venname").val();
	//	var veninfo=$(".veninfo").val();
	//	var whether=$(".whether").val();
	//	var phone=$(".phone").val();
	//	var email=$(".email").val();
	//	var regtime=$(".regtime").val();	
		var venid=$(".venid").val();
		$.ajax({
		type: 'POST',
		url: "../ajax.php?act=veneidt",
		dataType: 'json',
		async:false,
		data: {
			approval:approval,
			auth:auth,
			venname:venname,
			venid:venid
					
		},
		success: function(e) {
				if(e.code==1){				
					alert(e.message);
					window.location.href="vendor.php";
				
				}
				else{					
					alert(e.message);
					// window.open('/customer.php','_top');
				}		
		}
	});	
}

//厂商修改预留用户信息
SE.authoreidt=function(){
		var prodect="";
		var data_anal="";
		var order="";
		var VendID=$(".VendID").val();
		var ReservedInfo=$(".ReservedInfo").val();
		var PrivilLevel=$(".PrivilLevel option:selected").val();
		var AuthoPerson=$(".AuthoPerson").val();
		var Record=$(".Record").val();
		var Id=$(".Id").val();

		var isprodect=$(".prodect").is(":checked");
		if(isprodect) prodect=$(".prodect").attr("value");

		var isdata_anal=$(".data_anal").is(":checked");
		if(isdata_anal) data_anal=$(".data_anal").attr("value");

		var isorder=$(".order").is(":checked");
		if(isorder) order=$(".order").attr("value");

		var auth = prodect+data_anal+order;



		$.ajax({
		type: 'POST',
		url: "../ajax.php?act=authoreidt",
		dataType: 'json',
		async:false,
		data: {
			auth:auth,
			VendID:VendID,
			ReservedInfo:ReservedInfo,
			PrivilLevel:PrivilLevel,
			AuthoPerson:AuthoPerson,
			Record:Record,
			Id:Id

		},
		success: function(e) {
				if(e.code==1){
					alert(e.message);
					window.location.href="vendauthor.php";

				}
				else if(e.code==3){
					alert(e.message);
				}
				else{
					alert(e.message);
					 window.open('/customer.php','_top');
				}
		}
	});
}

//录入安全数据
SE.safeDateAdd=function(num){//num=0:QP单，num=1:检测线数据，
	var id=[];
	var val=[];
    var title=[];
	type=num;
    var VinCode=$("#VinCode").val();
    var VinCodeTitle=$("#VinCode").attr("title");
    title.push(VinCodeTitle);
    id.push("VinCode");
    val.push(VinCode);
	if(num==0){
		var numName="QP单中";
        $(".commondata >input").each(function () {
            title.push($(this).attr("title"));
            id.push($(this).attr("attr"));
            val.push($(this).val());
        })
	}else{
        var numName="检测线数据中";
        $(".commondata >input").each(function () {
            title.push($(this).attr("title"));
            id.push($(this).attr("attr"));
                val.push($(this).val());
        })
	}
    // console.log(id);
    // console.log(val);
// return false;
    $.ajax({
        type: 'POST',
        url: "/class/ajax.php?act=safeDateAdd",
        dataType: 'json',
        async:false,
        data: {
            type:type,
            title:JSON.stringify(title),
            tableName:JSON.stringify(id),
            val:JSON.stringify(val)
        },
        success: function(e) {
            var time=new Date().toLocaleString(); //获取当前时间
            // var time=new Date().toLocaleString(); //获取当前时间
            if(e.code==1){
                $("#log").append("<p style='color:green;'>"+e.message+"  "+"  "+time+"</p>");
                $(".op-log").click();
            } else{
                $("#err").append("<p style='color:red;'>"+numName+e.message+"  "+"  "+time+"</p>");
                $(".op-err").click();

            }

        }
    });
}
//录入性能数据
SE.addPerforData=function(type){//type=0:电池数据文件，type=1:电池数据截屏图片，type=2:系统数据文件，type=3:系统数据截屏图片，
    var id=[];
    var val=[];
    var title=[];
    var VinCode=$("#VinCode").val();
    if(type==0){
        var Url=$("#BatteryData").val();
    }else if(type==1){
        var Url=$("#BatteryImgUrl").val();
    }else if(type==2){
        var Url=$("#SysData").val();
    }else{
        var Url=$("#SysImgUrl").val();
    }
    $.ajax({
        type: 'POST',
        url: "/class/ajax.php?act=addPerforData",
        dataType: 'json',
        async:false,
        data: {
            type:type,
            VinCode:VinCode,
            Url:Url
        },
        success: function(e) {
            var time=new Date().toLocaleString(); //获取当前时间
            if(e.code==1){
                $("#log").prepend("<p style='color:green;'>"+e.message+"  "+time+"</p>");
                $(".op-log").click();
            } else{
                $("#err").prepend("<p style='color:red;'>"+e.message+"  "+time+"</p>");
                $(".op-err").click();
            }

        }
    });
}
//检索VIN码
SE.checkVinCode=function(num){//num=0:QP单，num=1:检测线数据，
    var VinCode=$("#VinCode").val();
    $.ajax({
        type: 'POST',
        url: "/class/ajax.php?act=checkVinCode",
        dataType: 'json',
        async:false,
        data: {
            VinCode:VinCode
        },
        success: function(e) {
        	$(".check-info").show();
            var time=new Date().toLocaleString(); //获取当前时间
            if(e.code==1){
                $(".check-info").html("<p style='color:green;'>"+e.message+"</p>");
                $("#log").prepend("<p style='color:green;'>"+e.message+"  "+time+"</p>");
                $(".op-log").click();
            } else if(e.code==3){
                $(".check-info").html("<p style='color:#ff9800;'>"+e.message+"</p>");
                $("#log").prepend("<p style='color:#ff9800;'>"+e.message+"  "+time+"</p>");
                $(".op-log").click();
            }else{
                $(".check-info").html("<p style='color:red;'>"+e.message+"</p>");
                $("#err").prepend("<p style='color:red;'>"+e.message+"  "+time+"</p>");
                $(".op-err").click();
            }

        }
    });
}

//录入出厂前数据
SE.addFactoryData=function(type){//type=0:合同--技术协议，type=1:配置单，type=1:BOM单，

    var OrderNum=$("#OrderNum").val();
    if(type==0){
        var Url=$("#ContractUrl").val();
	}else if(type==1){
        var Url=$("#ConfigUrl").val();
	}else{
        var Url=$("#BOMUrl").val();
    }
    // var ContractUrl=$("#ContractUrl").val();
    // var ConfigUrl=$("#ConfigUrl").val();
    // var BOMUrl=$("#BOMUrl").val();
    $.ajax({
        type: 'POST',
        url: "/class/ajax.php?act=addFactoryData",
        dataType: 'json',
        async:false,
        data: {
            OrderNum:OrderNum,
            Url:Url,
            type:type
        },
        success: function(e) {
            var time=new Date().toLocaleString(); //获取当前时间
            if(e.code==1){
                $("#log").prepend("<p style='color:green;'>"+e.message+"  "+time+"</p>");
				$(".op-log").click();
            } else{
                $("#err").prepend("<p style='color:red;'>"+e.message+"  "+time+"</p>");
                $(".op-err").click();
            }

        }
    });
}

//检索订单号
SE.checkOrderNum=function(num){//num=0:QP单，num=1:检测线数据，
    var OrderNum=$("#OrderNum").val();
    $.ajax({
        type: 'POST',
        url: "/class/ajax.php?act=checkOrderNum",
        dataType: 'json',
        async:false,
        data: {
            OrderNum:OrderNum
        },
        success: function(e) {
            var time=new Date().toLocaleString(); //获取当前时间
            $(".check-info").show();
            if(e.code==1){
                $(".check-info").html("<p style='color:green;'>"+e.message+"</p>");
                $("#log").prepend("<p style='color:green;'>"+e.message+"  "+time+"</p>");
                $(".op-log").click();
            } else if(e.code==3){
                $(".check-info").html("<p style='color:#ff9800;'>"+e.message+"</p>");
                $("#log").prepend("<p style='color:#ff9800;'>"+e.message+"  "+time+"</p>");
                $(".op-log").click();
            }else{
                $(".check-info").html("<p style='color:red;'>"+e.message+"</p>");
                $("#err").prepend("<p style='color:red;'>"+e.message+"  "+time+"</p>");
                $(".op-err").click();
            }

        }
    });
}
