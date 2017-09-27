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
                            <a href="#">性能数据录入</a>
                        </li>
                    </ul>
                </div>
                <!-- 表单 -->

                <form class="form-inline" role="form">
                    <div class="form-group">
                        <label for="firstname">VIN码</label>
                           <input type="text" class="form-control" id="firstname"
                           placeholder="请输入订单号">
                    </div>
                    <div class="form-group">
                        <button>检索</button>
                    </div>
                </form>
                <br> <br>

                <div class="navbar navbar-default"><span class="navbar-brand">电池数据</span></div>
                <form class="form-inline" role="form">
                    <div class="form-group">
                        <label for="firstname">电池数据文件</label>
                           <input type="text" class="form-control" id="firstname"
                           placeholder="请输入文档">

                    </div>
                    <div class="form-group">
                        <input type="file" class="inputs" multiple="multiple">
                    </div>
                    <button >标准模板文件导出</button>
                </form>
                <div id='desti' style="display:flex;flex-direction: row"><iframe src='https://view.officeapps.live.com/op/view.aspx?src=http://wat.eworder.com/a.docx&wdStartOn=1' width='1200px' height='588px' style="display: none" frameborder='0'></iframe></div>
                <button type="button" class="btn btn-primary btn-sm" onclick="file_submit()">提交</button> <br><br>
                <form class="form-inline" role="form">
                    <div class="form-group">
                        <label for="firstname">截屏图片</label>
                           <input type="text" class="form-control" id="firstname"
                           placeholder="请输入">
                    </div>
                    <div class="form-group">
                        <input type="file" class="input_two" multiple="multiple">
                    </div>
                </form>
                <div id='desti_two' style="display:flex;flex-direction: row"><iframe src='https://view.officeapps.live.com/op/view.aspx?src=http://wat.eworder.com/a.docx&wdStartOn=1' width='1200px' height='588px' style="display: none" frameborder='0'></iframe></div>
                <button type="button" class="btn btn-primary btn-sm" onclick="file_submit()">提交</button> <br><br>

                <div class="navbar navbar-default"><span class="navbar-brand">系统数据</span></div>
                <form class="form-inline" role="form">
                    <div class="form-group">
                        <label for="firstname">系统数据文件</label>
                           <input type="text" class="form-control" id="firstname"
                           placeholder="请输入订单号">
                    </div>
                    <div class="form-group">
                        <input type="file" class="inputs_three" multiple="multiple">
                    </div>
                    <button >标准模板文件导出</button>
                </form>
                <div id='desti_three' style="display:flex;flex-direction: row"><iframe src='https://view.officeapps.live.com/op/view.aspx?src=http://wat.eworder.com/a.docx&wdStartOn=1' width='1200px' height='588px' style="display: none" frameborder='0'></iframe></div>
                <button type="button" class="btn btn-primary btn-sm" onclick="file_submit()">提交</button> <br><br>
                <form class="form-inline" role="form">
                    <div class="form-group">
                        <label for="firstname">截屏图片</label>
                           <input type="text" class="form-control" id="firstname"
                           placeholder="请输入">
                    </div>
                    <div class="form-group">
                        <input type="file" class="input_four" multiple="multiple">
                    </div>
                </form>
                <div id='desti_four' style="display:flex;flex-direction: row"><iframe src='https://view.officeapps.live.com/op/view.aspx?src=http://wat.eworder.com/a.docx&wdStartOn=1' width='1200px' height='588px' style="display: none" frameborder='0'></iframe></div>
                <button type="button" class="btn btn-primary btn-sm" onclick="file_submit()">提交</button> <br><br>

                <!-- 录入日志和错误之间的切换 -->
                <ul id="myTab" class="nav nav-tabs">
                    <li class="active">
                        <a href="#log" data-toggle="tab">
                             录入日志
                        </a>
                    </li>
                    <li><a href="#err" data-toggle="tab">错误</a></li>

                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade in active" id="log">
                        <p>录入日志</p>
                    </div>
                    <div class="tab-pane fade" id="err">
                        <p>错误显示</p>
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
            $(".inputs_four").change(function () {
            this_="inputs_four";
                var fil = this.files;
                for (var i = 0; i < fil.length; i++) {
                    reads(fil[i]);
                }
            });

        var innerImg=document.getElementById("desti");
        var innerImg_two=document.getElementById("desti_two");
        var innerImg_three=document.getElementById("desti_three");
        var innerImg_four=document.getElementById("desti_three");
        function reads(fil){
        console.log(this_)
            var reader = new FileReader();
            reader.readAsDataURL(fil);
            reader.onload = function()
            {
                if(this_=="inputs"){
                  innerImg.innerHTML+= "<div class='_imgs' style='width:80px;height:80px;text-align:center;position: relative'><button type='button' style='position:absolute;top 0px;right:0px'> &times;</button><img src='../../002.png' class='doubclic'></br><a style='padding-left:10px'>双击后打开</a></div>";
                }
                if(this_=="inputs_two"){
                  innerImg_two.innerHTML+= "<div class='_imgs' style='width:80px;height:80px;text-align:center;position: relative'><button type='button' style='position:absolute;top 0px;right:0px'> &times;</button><img src='../../001.png' class='doubclic'></br><a style='padding-left:10px'>双击后打开</a></div>";

                }
                if(this_=="inputs_three"){
                  innerImg_three.innerHTML+= "<div class='_imgs' style='width:80px;height:80px;text-align:center;position: relative'><button type='button' style='position:absolute;top 0px;right:0px'> &times;</button><img src='../../001.png' class='doubclic'></br><a style='padding-left:10px'>双击后打开</a></div>";

                }
                if(this_=="inputs_three"){
                  innerImg_three.innerHTML+= "<div class='_imgs' style='width:80px;height:80px;text-align:center;position: relative'><button type='button' style='position:absolute;top 0px;right:0px'> &times;</button><img src='../../001.png' class='doubclic'></br><a style='padding-left:10px'>双击后打开</a></div>";

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
