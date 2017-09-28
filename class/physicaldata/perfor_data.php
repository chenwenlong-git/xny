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
    <link rel="stylesheet" href="../../public/css/wx-web.css">
    <script src="/js/project.js"></script>
    <link rel="stylesheet" href="style.css">
    <!-- 文件上传 -->
    <link rel="stylesheet" href="../../public/css/zyUpload.css">
    <script src="http://www.jq22.com/jquery/jquery-1.10.2.js"></script>
    <script type="text/javascript" src="../../public/js/zyFile.js"></script>
    <script type="text/javascript" src="../../public/js/zyUpload.js"></script>
    <script type="text/javascript" src="../../public/js/jqueryrotate.js"></script>
    <script type="text/javascript" src="../../public/js/index.js"></script>

    <link rel="stylesheet" href="../../public/css/ssi-uploader.css"/>
    <script src="../../public/js/ssi-uploader.js"></script>
<!-- <link rel="stylesheet" href="../../public/css/zyupload-1.0.0.min.css">
<script src="../../public/js/zyupload-1.0.0.min.js"></script> -->
    


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
                           <input type="text" class="form-control" id="VinCode" placeholder="请输入Vin码(17位字母数字组合)" autocomplete="on" title="Vin码">
                    </div>
                </form>
                <div class="navbar navbar-default"><span class="navbar-brand">电池数据</span></div>
                <form class="form-inline" role="form">
                    <div class="form-group">
                        <label for="firstname">电池数据文件</label>
                           <input type="text" class="form-control factor-doc1 BatteryData" id="BatteryData" placeholder="请输入文档">
                    </div>
                    <div class="form-group">
                        <input type="file" class="inputs" multiple="multiple">
                    </div>
                    <button >标准模板文件导出</button>
                </form>
                <div id='desti' style="display:flex;flex-direction: row"><iframe src='https://view.officeapps.live.com/op/view.aspx?src=http://wat.eworder.com/a.docx&wdStartOn=1' width='1200px' height='588px' style="display: none" frameborder='0'></iframe></div>
                <button type="button" class="btn btn-primary btn-sm" onclick="file_submit(0)">提交</button> <br><br>
                <form class="form-inline" role="form">
                    <div class="form-group">
                        <label for="firstname">截屏图片</label>
                           <input type="text" class="form-control factor-doc2 BatteryImgUrl" id="BatteryImgUrl" placeholder="请输入">
                    </div>
                    <div class="form-group">
                        
<!--                         <input type="file"  multiple="multiple" class="inputs_two"> -->
                        <div class="filePicker" class="inputs_two">点击选择文件</div>
                    </div>
                    <div id="demo" class="demo"></div>
                </form>
                <div id='desti_two' style="display:flex;flex-direction: row"><iframe src='https://view.officeapps.live.com/op/view.aspx?src=http://wat.eworder.com/a.docx&wdStartOn=1' width='1200px' height='588px' style="display: none" frameborder='0'></iframe></div>
                <button type="button" class="btn btn-primary btn-sm" onclick="file_submit(1)">提交</button> <br><br>

                <div class="navbar navbar-default"><span class="navbar-brand">系统数据</span></div>
                <form class="form-inline" role="form">
                    <div class="form-group">
                        <label for="firstname">系统数据文件</label>
                           <input type="text" class="form-control factor-doc3 SysData" id="SysData" placeholder="请输入订单号">
                    </div>
                    <div class="form-group">
                        <input type="file" class="inputs_three" multiple="multiple">
                    </div>
                    <button >标准模板文件导出</button>
                </form>
                <div id='desti_three' style="display:flex;flex-direction: row"><iframe src='https://view.officeapps.live.com/op/view.aspx?src=http://wat.eworder.com/a.docx&wdStartOn=1' width='1200px' height='588px' style="display: none" frameborder='0'></iframe></div>
                <button type="button" class="btn btn-primary btn-sm" onclick="file_submit(2)">提交</button> <br><br>
                <form class="form-inline" role="form">
                    <div class="form-group">
                        <label for="firstname">截屏图片</label>
                        <input type="file" multiple id="ssi-upload"/>
                           <!-- <input type="text" class="form-control factor-doc4 SysImgUrl" id="SysImgUrl" placeholder="请输入"> -->
<!--                            <input type="text" class="form-control SysImgUrl factor-doc4" id="SysImgUrl"
placeholder="请输入"> -->
                    </div>
                    <div class="form-group">
                        <input type="file" class="inputs_four" multiple="multiple">
                    </div>
                    <div id="zyupload" class="zyupload"></div>  
                </form>
                <div id='desti_four' style="display:flex;flex-direction: row"><iframe src='https://view.officeapps.live.com/op/view.aspx?src=http://wat.eworder.com/a.docx&wdStartOn=1' width='1200px' height='588px' style="display: none" frameborder='0'></iframe></div>
                <button type="button" class="btn btn-primary btn-sm" onclick="file_submit(3)">提交</button> <br><br>

                <!-- 录入日志和错误之间的切换 -->
                <ul id="myTab" class="nav nav-tabs">
                    <li class="active">
                        <a href="#log" data-toggle="tab" class="op-log">
                             录入日志
                        </a>
                    </li>
                    <li><a href="#err" data-toggle="tab" class="op-err">错误</a></li>

                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade in active" id="log">
                    </div>
                    <div class="tab-pane fade" id="err">
                    </div>
                </div>
            </div>

        </div>
    </div>

<script src="../../public/js/bootstrap.min.js"></script>
<script src="../../public/js/webuploader.js"></script>
    <script>
        $(document).ready(function () {
        var this_;
            var val1="";var val2="";var val3="";var val4="";
            $(".inputs").change(function () {
                this_="inputs";
                var fil = this.files;
                for (var i = 0; i < fil.length; i++) {
                    reads(fil[i]);
                    val1 += fil[i].name + ";";
                }
                $(".factor-doc1").val(val1);

            });
            $(".inputs_two").change(function () {
                this_="inputs_two";
                var fil = this.files;
                for (var i = 0; i < fil.length; i++) {
                    reads(fil[i]);
                    val2 += fil[i].name + ";";
                }
                $(".factor-doc2").val(val2);
            });
            $(".inputs_three").change(function () {
                this_="inputs_three";
                var fil = this.files;
                for (var i = 0; i < fil.length; i++) {
                    reads(fil[i]);
                    val3 += fil[i].name + ";";
                }
                $(".factor-doc3").val(val3);
            });
            $(".inputs_four").change(function () {
                this_="inputs_four";
                var fil = this.files;
                for (var i = 0; i < fil.length; i++) {
                    reads(fil[i]);
                    val4 += fil[i].name + ";";
                }
                $(".factor-doc4").val(val4);
            });

        var innerImg=document.getElementById("desti");
        var innerImg_two=document.getElementById("desti_two");
        var innerImg_three=document.getElementById("desti_three");
        var innerImg_four=document.getElementById("desti_four");
        function reads(fil){
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
                  innerImg_three.innerHTML+= "<div class='_imgs' style='width:80px;height:80px;text-align:center;position: relative'><button type='button' style='position:absolute;top 0px;right:0px'> &times;</button><img src='../../001.png' class='doubclic'></br><a style='padding-left:10px'>双击后打开</a></div>";

                }
                if(this_=="inputs_four"){
                    innerImg_four.innerHTML+= "<div class='_imgs' style='width:80px;height:80px;text-align:center;position: relative'><button type='button' style='position:absolute;top 0px;right:0px'> &times;</button><img src='../../001.png' class='doubclic'></br><a style='padding-left:10px'>双击后打开</a></div>";

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
        function file_submit(Type){
            var _confirm=confirm("您确定要提交吗？");
            if(_confirm){
                SE.addPerforData(Type);
            }
        }
    </script>
<!--     上传系统文件图片 -->
<script type="text/javascript">
    $('#ssi-upload').ssi_uploader({url:'#',maxFileSize:6,allowed:['jpg','gif','txt','png','pdf']});
</script>
    <script src="../../bootstrap.min.js"></script>
</body>
</html>
