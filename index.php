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
    <link rel="stylesheet" href="public/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/bootstrap-cerulean.min.css">
    <link rel="stylesheet" href="public/css/wx-app.css">
</head>
<body>
<?php require_once 'public/header/header.php';?>

    <div class="ch-container">
        <div class="row">
            <?php require_once 'public/nav/nav.php';?>
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
                
                <!-- <div id="demo">
                                    <div class="wrapper">
                                        <h3>试试输入"百度"</h3>
                                        <div id="search-form"></div>
                                        <div id="message"></div>
                                    </div>
                                </div>       -->                

                <form class="form-inline" role="form">
                    <div class="form-group">
                        <label for="firstname">订单号</label>
                           <input type="text" class="form-control" id="firstname" 
                           placeholder="请输入订单号">                           
                    </div>
                    <div class="form-group">
                        <input type="file" id="inputs" multiple="multiple">                                              
                    </div>
                </form>
                <div id='desti' style="display:flex;flex-direction: row"><iframe src='https://view.officeapps.live.com/op/view.aspx?src=http://wat.eworder.com/a.docx&wdStartOn=1' width='1200px' height='588px' style="display: none" frameborder='0'></iframe></div>
                <button type="button" class="btn btn-primary btn-lg" onclick="file_submit()">提交</button>
                <br> <br>
                <div class="navbar navbar-default"><span class="navbar-brand">合同--技术协议</span></div>
                <form class="form-inline" role="form">
                    <div class="form-group">
                        <label for="firstname">合同文档</label>
                           <input type="text" class="form-control" id="firstname" 
                           placeholder="请输入订单号">                           
                    </div>
                    <div class="form-group">
                        <input type="file" id="inputfile">                         
                    </div>
                </form>
                <div class="navbar navbar-default"><span class="navbar-brand">配置单</span></div>
                <form class="form-inline" role="form">
                    <div class="form-group">
                        <label for="firstname">配置单</label>
                           <input type="text" class="form-control" id="firstname" 
                           placeholder="请输入订单号">                           
                    </div>
                    <div class="form-group">
                        <input type="file" id="inputfile">                         
                    </div>
                </form>
                <div class="navbar navbar-default"><span class="navbar-brand">配置单</span></div>
                <form class="form-inline" role="form">
                    <div class="form-group">
                        <label for="firstname">BOM单</label>
                           <input type="text" class="form-control" id="firstname" 
                           placeholder="请输入订单号">                           
                    </div>
                    <div class="form-group">
                        <input type="file" id="inputfile">                         
                    </div>
                </form>                 

            </div>
        </div>
    </div>
    <script src="public/js/jquery-1.11.1.min.js"></script>
    <script src="public/js/bootstrap.min.js"></script>
    <script src="public/js/nav.js"></script>
    

    <script>
        $(document).ready(function () {
            $("#inputs").change(function () {
                var fil = this.files;
                for (var i = 0; i < fil.length; i++) {
                    reads(fil[i]);
                }
            });
        
        var innerImg=document.getElementById("desti");
        function reads(fil){
            var reader = new FileReader();
            reader.readAsDataURL(fil);

            reader.onload = function()
            {
                innerImg.innerHTML+= "<div class='_imgs' style='width:80px;height:80px;text-align:center;position: relative'><button type='button' style='position:absolute;top 0px;right:0px'> &times;</button><img src='001.png' class='doubclic'></br><a style='padding-left:10px'>双击后打开</a></div>";
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
        //文件提交
        function file_submit(){
            confirm("您确定要提交吗？")
        }
    </script>
</body>
</html>
