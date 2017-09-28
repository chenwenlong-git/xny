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
    <script src="../../public/js/jquery-1.11.1.min.js"></script>
    <script src="../../public/js/bootstrap.min.js"></script>
    <script src="/js/project.js"></script>
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
                           <input type="text" class="form-control OrderNum" id="OrderNum" placeholder="请输入订单号">
                    </div>
                    <div class="form-group">
                        <button type="button" onclick="SE.checkOrderNum();" class="op-botton btn btn-primary btn-sm">检索</button>
                    </div>
                    <div class="check-info" style="display: none;margin-bottom: -10px;margin-top: 10px;margin-left: 92px;">
                    </div>
                </form>
                <div class="navbar navbar-default"><span class="navbar-brand">合同--技术协议</span></div>
                <form class="form-inline" role="form">
                    <div class="form-group">
                        <label for="firstname">合同文档</label>
                           <input type="text" class="form-control factor-doc1 ContractUrl" id="ContractUrl"
                           placeholder="请输入文档">
                    </div>
                    <div class="form-group">
                        <input type="file" class="inputs" multiple="multiple" accept="application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document" >
                    </div>
                </form>
                <div id='desti' style="display:flex;flex-direction: row"><iframe src='https://view.officeapps.live.com/op/view.aspx?src=http://wat.eworder.com/a.docx&wdStartOn=1' width='1200px' height='588px' style="display: none" frameborder='0'></iframe></div>
                <button type="button" class="btn btn-primary btn-sm" onclick="file_submit(0)">提交</button> <br><br>

                <div class="navbar navbar-default"><span class="navbar-brand">配置单</span></div>
                <form class="form-inline" role="form">
                    <div class="form-group">
                        <label for="firstname">配置单</label>
                           <input type="text" class="form-control factor-doc2 ConfigUrl" id="ConfigUrl" placeholder="请输入订单号">
                    </div>
                    <div class="form-group">
                        <input type="file" class="inputs_two" multiple="multiple" accept="application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document" >
                    </div>
                </form>
                <div id='desti_two' style="display:flex;flex-direction: row"><iframe src='https://view.officeapps.live.com/op/view.aspx?src=http://wat.eworder.com/a.docx&wdStartOn=1' width='1200px' height='588px' style="display: none" frameborder='0'></iframe></div>
                <button type="button" class="btn btn-primary btn-sm" onclick="file_submit(1)">提交</button> <br><br>
                <div class="navbar navbar-default"><span class="navbar-brand">BOM单</span></div>
                <form class="form-inline" role="form">
                    <div class="form-group">
                        <label for="firstname">BOM单</label>
                           <input type="text" class="form-control factor-doc3 BOMUrl" id="BOMUrl" placeholder="请输入订单号">
                    </div>
                    <div class="form-group">
                        <input type="file" class="inputs_three" multiple="multiple">
                    </div>
                </form>
                    <div id='desti_three' style="display:flex;flex-direction: row"><iframe src='https://view.officeapps.live.com/op/view.aspx?src=http://wat.eworder.com/a.docx&wdStartOn=1' width='1200px' height='588px' style="display: none" frameborder='0'></iframe></div>
                    <button type="button" class="btn btn-primary btn-sm" onclick="file_submit(2)">提交</button> <br><br>
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

/*<!--     <script src="public/js/bootstrap.min.js"></script>
    <script src="public/js/jquery-1.11.1.min.js"></script> -->*/
<!--     <script src="public/js/wx.js"></script> -->
    <script>

    </script>
    <script>
        $(document).ready(function () {
        var this_;
        var val1="";var val2="";var val3="";
            $(".inputs").change(function () {
                this_="inputs";
                var fil = this.files;
                console.log(fil);
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
        function file_submit(Type){
            var _confirm=confirm("您确定要提交吗？");
            if(_confirm){
                SE.addFactoryData(Type);
            }
        }
    </script>
</body>
</html>
