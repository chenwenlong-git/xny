<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
<!--     让页面具备记忆功能 -->
    <!-- <meta http-equiv="Content-Type" content="index.php; charset=UTF-8"> -->
    <!-- <meta name="save" content="history"> -->
    <title>万象信息管理</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="上海万象 万象信息管理">
    <!--     <link id="bs-css" href="css/bootstrap-cerulean.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="../../public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../public/css/bootstrap-cerulean.min.css">
    <link rel="stylesheet" href="../../public/css/wx-app.css">
    <script src="http://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!--     <link rel="stylesheet" href="public/css/autocomplete.css">
<link rel="stylesheet" href="style.css"> -->
            <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
            <![endif]-->
<!--     自动完成  -->

</head>
<body>
<?php require_once '../../public/header/header.php';?>

    <div class="ch-container">
        <div class="row">
            <?php require_once '../../public/nav/nav.php';?>
            <div id="content" class="col-sm-10 col-lg-10">
                <div>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">首页</a>
                        </li>
                        <li>
                            <a href="#">出厂前数据录入</a>
                        </li>
                    </ul>
                </div>
                <!-- 表单 -->

                <form class="form-inline" role="form">
                    <div class="form-group">
                        <label for="firstname">订单号</label>
                           <input type="text" class="form-control" id="firstname"
                           placeholder="请输入订单号">
                    </div>
                    <div class="form-group">
                        <button>检索</button>
                    </div>
                </form>
                <br> <br>

                <div class="navbar navbar-default"><span class="navbar-brand">合同--技术协议</span></div>
                <form class="form-inline" role="form">
                    <div class="form-group">
                        <label for="firstname">合同文档</label>
                           <input type="text" class="form-control" id="firstname"
                           placeholder="请输入文档">
                    </div>
                    <div class="form-group">
                        <input type="file" class="inputs" multiple="multiple">
                    </div>
                </form>
                <div id='desti' style="display:flex;flex-direction: row"><iframe src='https://view.officeapps.live.com/op/view.aspx?src=http://wat.eworder.com/a.docx&wdStartOn=1' width='1200px' height='588px' style="display: none" frameborder='0'></iframe></div>
                <button type="button" class="btn btn-primary btn-sm" onclick="file_submit()">提交</button> <br><br>

                <div class="navbar navbar-default"><span class="navbar-brand">配置单</span></div>
                <form class="form-inline" role="form">
                    <div class="form-group">
                        <label for="firstname">配置单</label>
                           <input type="text" class="form-control" id="firstname"
                           placeholder="请输入订单号">
                    </div>
                    <div class="form-group">
                        <input type="file" class="inputs_two" multiple="multiple">
                    </div>
                </form>
                <div id='desti_two' style="display:flex;flex-direction: row"><iframe src='https://view.officeapps.live.com/op/view.aspx?src=http://wat.eworder.com/a.docx&wdStartOn=1' width='1200px' height='588px' style="display: none" frameborder='0'></iframe></div>
                <button type="button" class="btn btn-primary btn-sm" onclick="file_submit()">提交</button> <br><br>

                <div class="navbar navbar-default"><span class="navbar-brand">BOM单</span></div>
                <form class="form-inline" role="form">
                    <div class="form-group">
                        <label for="firstname">BOM单</label>
                           <input type="text" class="form-control" id="firstname"
                           placeholder="请输入订单号">
                    </div>
                    <div class="form-group">
                        <input type="file" class="inputs_three" multiple="multiple">
                    </div>
                </form>
                    <div id='desti_three' style="display:flex;flex-direction: row"><iframe src='https://view.officeapps.live.com/op/view.aspx?src=http://wat.eworder.com/a.docx&wdStartOn=1' width='1200px' height='588px' style="display: none" frameborder='0'></iframe></div>
                    <button type="button" class="btn btn-primary btn-sm" onclick="file_submit()">提交</button> <br><br>
                <!-- 录入日志和错误之间的切换 -->
                <ul id="myTab" class="nav nav-tabs">
                    <li class="active">
                        <a href="#log" data-toggle="tab">
                             录入日志
                        </a>
                    </li>
                    <li><a href="#err" data-toggle="tab">错误</a></li>
<!--                     <li class="dropdown">
    <a href="#" id="myTabDrop1" class="dropdown-toggle"
       data-toggle="dropdown">Java
        <b class="caret"></b>
    </a>
    <ul class="dropdown-menu" role="menu" aria-labelledby="myTabDrop1">
        <li><a href="#jmeter" tabindex="-1" data-toggle="tab">jmeter</a></li>
        <li><a href="#ejb" tabindex="-1" data-toggle="tab">ejb</a></li>
    </ul>
</li> -->
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade in active" id="log">
                        <p>录入日志</p>
                    </div>
                    <div class="tab-pane fade" id="err">
                        <p>错误显示</p>
                    </div>
                    <div class="tab-pane fade" id="jmeter">
                        <p>jMeter 是一款开源的测试软件。它是 100% 纯 Java 应用程序，用于负载和性能测试。</p>
                    </div>
                    <div class="tab-pane fade" id="ejb">
                        <p>Enterprise Java Beans（EJB）是一个创建高度可扩展性和强大企业级应用程序的开发架构，部署在兼容应用程序服务器（比如 JBOSS、Web Logic 等）的 J2EE 上。
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>

/*<!--     <script src="public/js/bootstrap.min.js"></script>
    <script src="public/js/jquery-1.11.1.min.js"></script> -->*/
<!--     <script src="public/js/wx.js"></script> -->
    <script>

    </script>
    <script>
        $(document).ready(function () {
        var this_;
            $(".inputs").change(function () {
                this_="inputs";
                var fil = this.files;
                for (var i = 0; i < fil.length; i++) {
                    reads(fil[i]);
                }
            });
            $(".inputs_two").change(function () {
            this_="inputs_two";
                var fil = this.files;
                for (var i = 0; i < fil.length; i++) {
                    reads(fil[i]);
                }
            });
            $(".inputs_three").change(function () {
            this_="inputs_three";
                var fil = this.files;
                for (var i = 0; i < fil.length; i++) {
                    reads(fil[i]);
                }
            });

        var innerImg=document.getElementById("desti");
        var innerImg_two=document.getElementById("desti_two");
        var innerImg_three=document.getElementById("desti_three");
        function reads(fil){
        console.log(this_)
            var reader = new FileReader();
            reader.readAsDataURL(fil);
            reader.onload = function()
            {
                if(this_=="inputs"){
                  innerImg.innerHTML+= "<div class='_imgs' style='width:80px;height:80px;text-align:center;position: relative'><button type='button' style='position:absolute;top 0px;right:0px'> &times;</button><img src='../../001.png' class='doubclic'></br><a style='padding-left:10px'>双击后打开</a></div>";
                }
                if(this_=="inputs_two"){
                  innerImg_two.innerHTML+= "<div class='_imgs' style='width:80px;height:80px;text-align:center;position: relative'><button type='button' style='position:absolute;top 0px;right:0px'> &times;</button><img src='../../001.png' class='doubclic'></br><a style='padding-left:10px'>双击后打开</a></div>";

                }
                if(this_=="inputs_three"){
                  innerImg_three.innerHTML+= "<div class='_imgs' style='width:80px;height:80px;text-align:center;position: relative'><button type='button' style='position:absolute;top 0px;right:0px'> &times;</button><img src='../../002.png' class='doubclic'></br><a style='padding-left:10px'>双击后打开</a></div>";

                }
            };
        }
        });
        //双击后打开
        $("#desti").on("dblclick","div",function(){
            $("iframe").css("display","block");
            $(this).hide();
        })
        $("#desti").on('click','button',function(){
            var _close=confirm("确定要删除吗？");
            if(_close){
                $(this).parent().remove();
            }
        })
        $("#desti_two").on("dblclick","div",function(){
            $("iframe").css("display","block");
            $(this).hide();
        })
        $("#desti_two").on('click','button',function(){
            var _close=confirm("确定要删除吗？");
            if(_close){
                $(this).parent().remove();
            }
        })
        $("#desti_three").on("dblclick","div",function(){
            $("iframe").css("display","block");
            $(this).hide();
        })
        $("#desti_three").on('click','button',function(){
            var _close=confirm("确定要删除吗？");
            if(_close){
                $(this).parent().remove();
            }
        })
        //文件提交
        function file_submit(){
            confirm("您确定要提交吗？")
        }
    </script>
</body>
</html>
