var SE={};

SE.inviteId = [];
window._overlay_pass = null;

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

//上传车辆录入信息表
SE.TraceDataCar = function () {
	var formData = new FormData();
    var obj=$('#carinfo')[0].files[0];
    formData.append('newcel',obj);
   $.ajax({
      url: "../ajax.php?act=TraceDataCar",
      type: 'POST',
	  cache: false,
	  data:formData,
	  dataType: 'json',
	  processData: false,
	  contentType: false,
	  success: function(e){
      if(e.code==1){
		  $(".success-log ul").append("<li>"+e.message+"</li>");
          $(".log-ul li").eq(1).removeClass("log-active");
		  $(".log-ul li").eq(0).addClass("log-active");
		  $(".success-log").show();
          $(".error-log").hide();
         //alert(e.message);
	   }else{
		  $(".log-ul li").eq(0).removeClass("log-active");
		  $(".log-ul li").eq(1).addClass("log-active");
		  $(".success-log").hide();
          $(".error-log").show();
		 $(".error-log ul").append("<li>"+e.message+"</li>");
	    }
	   }
	})


}
//上传上海车辆录入信息表
SE.TraceDatashCar = function () {
	var formData = new FormData();
    var obj=$('#shanghaicarinfo')[0].files[0];
    formData.append('newcel',obj);
   $.ajax({
      url: "../ajax.php?act=TraceDatashCar",
      type: 'POST',
	  cache: false,
	  data:formData,
	  dataType: 'json',
	  processData: false,
	  contentType: false,
	  success: function(e){
      if(e.code==1){
		  $(".success-log ul").append("<li>"+e.message+"</li>");
          $(".log-ul li").eq(1).removeClass("log-active");
		  $(".log-ul li").eq(0).addClass("log-active");
		  $(".success-log").show();
          $(".error-log").hide();
         //alert(e.message);
	   }else{
		  $(".log-ul li").eq(0).removeClass("log-active");
		  $(".log-ul li").eq(1).addClass("log-active");
		  $(".success-log").hide();
          $(".error-log").show();
		  $(".error-log ul").append("<li>"+e.message+"</li>");
	    }
	   }
	})
}

//上传重要零部件厂家出厂检验报告
SE.PartsReport = function () {
	var iv=0;
	var imgarr = [];
	$("#ul_pics li").each(function(i){
       imgarr[iv]=$(this).children("div").children("img").attr("src");
	   iv++;
     });
	var allimgarr=JSON.stringify(imgarr);
    $.ajax({
      url: "../ajax.php?act=PartsReport",
      type: 'POST',
	  cache: false,
	  data: {
            allimgarr: allimgarr
        },
	  dataType: 'json',
	  success: function(e){
      if(e.code==1){
		  $(".success-log ul").append("<li>"+e.message+"</li>");
          $(".log-ul li").eq(1).removeClass("log-active");
		  $(".log-ul li").eq(0).addClass("log-active");
		  $(".success-log").show();
          $(".error-log").hide();
		  $("#ul_pics").html("");
         //alert(e.message);
	   }else{
		  $(".log-ul li").eq(0).removeClass("log-active");
		  $(".log-ul li").eq(1).addClass("log-active");
		  $(".success-log").hide();
          $(".error-log").show();
		  $(".error-log ul").append("<li>"+e.message+"</li>");
	    }
	   }
	})
}
