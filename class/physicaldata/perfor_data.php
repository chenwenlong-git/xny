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
    <link rel="stylesheet" href="../../public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../public/css/bootstrap-cerulean.min.css">
    <link rel="stylesheet" href="../../public/css/wx-app.css">
    <link rel="stylesheet" href="../../public/css/wx-web.css">
    <script src="/js/project.js"></script>
    <link rel="stylesheet" href="style.css">
    <!-- 文件上传 -->
    <script src="http://www.jq22.com/jquery/jquery-1.10.2.js"></script>
    <!--     上传exel等文件 -->
    <link rel="stylesheet" href="../../public/css/iconfont.css">
    <link href="../../public/css/fileUpload.css" rel="stylesheet" type="text/css">
    <link href="../../public/css/iconfont.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="../../external/uploadify/js/fileUpload.js"></script>
    <script type="text/javascript" src="../../public/js/iconfont.js"></script>
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!--     自动完成  -->
    <style>
        .demo {
            width: 100% !important;
        }
    </style>
</head>
<body>
<?php require_once '../../public/header/header.php'; ?>

<div class="ch-container">
    <div class="row">
        <?php require_once '../../public/nav/nav.php'; ?>
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
                    <label for="firstname">电池数据文件：</label>
                    <!--                    <input type="text" class="form-control factor-doc1 BatteryData" id="BatteryData" placeholder="请选择电池数据文件导入">-->
                </div>
                <button>标准模板文件导出</button>
                <!-- 文件导入处    -->
                <div id="fileUploadContent" class="fileUploadContent"></div>
            </form>
            <form class="form-inline" role="form">
                <div class="form-group">
                    <label for="firstname">截屏图片：</label>
                    <!--                    <input type="text" class="form-control factor-doc2 BatteryImgUrl" id="BatteryImgUrl" placeholder="请选择电池数据截屏图片导入">-->
                </div>
                <!-- 文件导入处    -->
                <div id="fileUploadContent_two" class="fileUploadContent"></div>
            </form>
            <div class="navbar navbar-default"><span class="navbar-brand">系统数据</span></div>
            <form class="form-inline" role="form">
                <div class="form-group">
                    <label for="firstname">系统数据文件：</label>
                    <!--                    <input type="text" class="form-control factor-doc3 SysData" id="SysData" placeholder="请选择系统数据文件导入">-->
                </div>
                <button>标准模板文件导出</button>
                <!-- 文件导入处    -->
                <div id="fileUploadContent_three" class="fileUploadContent"></div>
            </form>
            <button type="button" class="btn btn-primary btn-sm" onclick="SE.perforExcel(1)">提交</button>
            <form class="form-inline" role="form">
                <div class="form-group">
                    <label for="firstname">截屏图片：</label>
                </div>
                <!-- 文件导入处    -->
                <div id="fileUploadContent_four" class="fileUploadContent"></div>
            </form>
            <button type="button" class="btn btn-primary btn-sm" onclick="file_submit(3)">提交</button>
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

    <script src="../../public/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../external/uploadimg/js/plupload.full.min.js"></script>
    <script>
        //文件提交
        function file_submit(Type) {
            var _confirm = confirm("您确定要提交吗？");
            if (_confirm) {
                SE.addPerforData(Type);
            }
        }

        //日志切换
        $(".log-ul li").click(function () {
            $(this).addClass("log-active");
            $(this).siblings().removeClass("log-active");
            var index = $(this).index();
            $(".log-detail div").eq(index).show().siblings().hide();
        })
    </script>
    <script>

        //上传电池数据
        $("#fileUploadContent").initUpload({
            "uploadUrl": "../ajax.php?act=perforExcel",//上传文件信息地址
            "size": 3500,//文件大小限制，单位kb,默认不限制
            "maxFileNumber": 1,//文件个数限制，为整数
            "filelSavePath": "../uploads/xlsx/",//文件上传地址，后台设置的根目录
            "beforeUpload": beforeUploadFun,//在上传前执行的函数
            "onUpload": onUploadFun,//在上传后执行的函数
//		autoCommit:true,//文件是否自动上传
            "fileType": ['xls', 'xlsx', 'csv']//文件类型限制，默认不限制，注意写的是文件后缀
        });

        function beforeUploadFun(opt) {
            console.log(opt);
            var VinCode = $("#VinCode").val();
            opt.otherData = [
                {"name": "VinCode", "value": VinCode},
                {"name": "type", "value": "0"}
            ];
        }

        function onUploadFun(opt, data) {
            var e = [];
            e = JSON.parse(data);
//		uploadTools.uploadError(opt);//显示上传错误
            var time = new Date().toLocaleString(); //获取当前时间
            if (e.code == 1) {
                $("#log").prepend("<p style='color:green;'>" + e.message + "  " + time + "</p>");
                $(".op-log").click();
            } else {
                $("#err").prepend("<p style='color:red;'>" + e.message + "  " + time + "</p>");
                $(".op-err").click();
            }
        }

        //上传电池数据截屏图片
        $("#fileUploadContent_two").initUpload({
            "uploadUrl": "../ajax.php?act=addPerforData",//上传文件信息地址
            "size": 3500,//文件大小限制，单位kb,默认不限制
            "maxFileNumber": 3,//文件个数限制，为整数
            //"filelSavePath":"",//文件上传地址，后台设置的根目录
            "beforeUpload": beforeUploadFun2,//在上传前执行的函数
            "onUpload": onUploadFun2,//在上传后执行的函数
            //autoCommit:true,//文件是否自动上传
            "fileType": ['jpg', 'jpeg', 'png', 'bmp']//文件类型限制，默认不限制，注意写的是文件后缀
        });

        function beforeUploadFun2(opt) {
            var VinCode = $("#VinCode").val();
            opt.otherData = [
                {"name": "VinCode", "value": VinCode},
                {"name": "type", "value": "0"}
            ];
        }

        function onUploadFun2(opt, data) {
            var e = [];
            e = JSON.parse(data);
            var time = new Date().toLocaleString(); //获取当前时间
            if (e.code == 1) {
                $("#log").prepend("<p style='color:green;'>" + e.message + "  " + time + "</p>");
                $(".op-log").click();
            } else {
                $("#err").prepend("<p style='color:red;'>" + e.message + "  " + time + "</p>");
                $(".op-err").click();
            }
        }


        $("#fileUploadContent_three").initUpload({
            "uploadUrl": "../ajax.php?act=perforExcel",//上传文件信息地址
            //"size":350,//文件大小限制，单位kb,默认不限制
            //"maxFileNumber":3,//文件个数限制，为整数
            //"filelSavePath":"",//文件上传地址，后台设置的根目录
            "beforeUpload": beforeUploadFun3,//在上传前执行的函数
            "onUpload":onUploadFun3,//在上传后执行的函数
            //autoCommit:true,//文件是否自动上传
            "fileType": ['xls', 'xlsx', 'csv']//文件类型限制，默认不限制，注意写的是文件后缀
        });

        function beforeUploadFun3(opt) {
            var VinCode = $("#VinCode").val();
            opt.otherData = [
                {"name": "VinCode", "value": VinCode},
                {"name": "type", "value": "1"}
            ];
        }

        function onUploadFun3(opt, data) {
            var e = [];
            e = JSON.parse(data);
//		uploadTools.uploadError(opt);//显示上传错误
            var time = new Date().toLocaleString(); //获取当前时间
            if (e.code == 1) {
                $("#log").prepend("<p style='color:green;'>" + e.message + "  " + time + "</p>");
                $(".op-log").click();
            } else {
                $("#err").prepend("<p style='color:red;'>" + e.message + "  " + time + "</p>");
                $(".op-err").click();
            }
        }

        $("#fileUploadContent_four").initUpload({
            "uploadUrl": "../ajax.php?act=addPerforData",//上传文件信息地址
            //"size":350,//文件大小限制，单位kb,默认不限制
            //"maxFileNumber":3,//文件个数限制，为整数
            //"filelSavePath":"",//文件上传地址，后台设置的根目录
            "beforeUpload": beforeUploadFun4,//在上传前执行的函数
            "onUpload":onUploadFun4,//在上传后执行的函数
            //autoCommit:true,//文件是否自动上传
            "fileType": ['jpg', 'jpeg', 'png', 'bmp']//文件类型限制，默认不限制，注意写的是文件后缀
        });

        function beforeUploadFun4(opt) {
            var VinCode = $("#VinCode").val();
            opt.otherData = [
                {"name": "VinCode", "value": VinCode},
                {"name": "type", "value": "1"}
            ];
        }
        function onUploadFun4(opt, data) {
            var e = [];
            e = JSON.parse(data);
//		uploadTools.uploadError(opt);//显示上传错误
            var time = new Date().toLocaleString(); //获取当前时间
            if (e.code == 1) {
                $("#log").prepend("<p style='color:green;'>" + e.message + "  " + time + "</p>");
                $(".op-log").click();
            } else {
                $("#err").prepend("<p style='color:red;'>" + e.message + "  " + time + "</p>");
                $(".op-err").click();
            }
        }

    </script>
    <script src="../../bootstrap.min.js"></script>
</body>
</html>
