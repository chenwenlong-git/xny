<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>万象信息管理</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="上海万象 万象信息管理">
    <!--     <link id="bs-css" href="css/bootstrap-cerulean.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="../../public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../public/css/bootstrap-cerulean.min.css">
    <link rel="stylesheet" href="../../public/css/wx-app.css">
    <link rel="stylesheet" href="../../public/css/wx-web.css">
    <link rel="stylesheet" href="../../public/css/webuploader.css">
    <script src="/js/project.js"></script>
    <script src="../../public/js/jquery-1.11.1.min.js"></script>
    <script src="../../public/js/bootstrap.min.js"></script>
    <link href="../../public/css/fileUpload.css" rel="stylesheet" type="text/css">
    <link href="../../public/css/iconfont.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="../../external/uploadify/js/fileUpload.js"></script>
    <script type="text/javascript" src="../../public/js/iconfont.js"></script>
    <!--[if lt IE 9]>
    <!--<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>-->
    <![endif]-->

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
                        <a href="#">安全数据</a>
                    </li>
                </ul>
            </div>
            <!-- 表单 -->
            <form class="form-inline" role="form">
                <div class="form-group">
                    <label for="firstname">Vin码</label>
                    <input type="text" class="form-control VinCode" id="VinCode" placeholder="请输入Vin码(17位字母数字组合)" autocomplete="on" title="Vin码">
                </div>
                <div class="form-group checkVinCode">
                    <button class="op-botton btn btn-primary btn-sm" type="button" onclick="SE.checkVinCode();">检索</button>
                </div>
                <div class="check-info" style="display: none;margin-bottom: -10px;margin-top: 10px;margin-left: 92px;">
                </div>
                <div class="commondata form-group2" style="margin-top: 5px;">
                    <label for="firstname">车型：</label>
                    <input type="text" class="form-control CarModels" id="CarModels" placeholder="请输入车型编号" attr="CarModels" title="车型">
                </div>
                <div class="commondata form-group2">
                    <label for="firstname">生产流水号：</label>
                    <input type="text" class="form-control SerialNum" id="SerialNum" placeholder="请输入生产流水号" attr="SerialNum" title="生产流水号">
                </div>
                <div class="commondata form-group2">
                    <label for="firstname">电机号：</label>
                    <input type="text" class="form-control MotorNum" id="MotorNum" placeholder="请输入电机号" attr="MotorNum" title="电机号">
                </div>
            </form>
            <div class="navbar navbar-default"><span class="navbar-brand">QP单</span></div>
            <form class="form-inline QP-order" role="form">

                <div class="commondata form-group QP-img">
                    <label for="firstname">QP单(图)：</label>
                </div>
                <div id="fileUploadContent" class="fileUploadContent"></div>
                <div class="form-group2">
                    <button type="button" class="btn btn-primary btn-sm" onclick="SE.safeDateAdd(0);">提交</button>
                </div>
            </form>
            <div class="navbar navbar-default"><span class="navbar-brand">检测线数据</span></div>
            <form class="form-inline line-data" role="form">
                <div class="commondata2 form-group QP-img">
                    <label for="firstname">检测线数据：</label>
                </div>
                <div id="fileUploadContent_two" class="fileUploadContent"></div>
                <div class="form-group2">
                    <button type="button" onclick="SE.safeDateAdd(1);" class="btn btn-primary btn-sm">提交</button>
                </div>
            </form>
            <div class="safe-log clearfix">
                <div class="log-box">
                    <ul id="myTab" class="nav nav-tabs">
                        <li class="active">
                            <a href="#log" data-toggle="tab" class="op-log">
                                录入日志
                            </a>
                        </li>
                        <li><a href="#err" data-toggle="tab" class="op-err">错误</a></li>
                    </ul>
                </div>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade in active" id="log">
                    </div>
                    <div class="tab-pane fade" id="err">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    //日志切换
    $(".log-ul li").click(function () {
        $(this).addClass("log-active");
        $(this).siblings().removeClass("log-active");
        var index = $(this).index();
        $(".log-detail div").eq(index).show().siblings().hide();
    })


    //上传电池数据
    $("#fileUploadContent").initUpload({
        "uploadUrl": "../ajax.php?act=safeDateAdd",//上传文件信息地址
        "size": 3500,//文件大小限制，单位kb,默认不限制
        "maxFileNumber": 10,//文件个数限制，为整数
        "filelSavePath": "../uploads/xlsx/",//文件上传地址，后台设置的根目录
        "beforeUpload": beforeUploadFun,//在上传前执行的函数
        "onUpload": onUploadFun,//在上传后执行的函数
//		autoCommit:true,//文件是否自动上传
        "fileType": ['jpg', 'jpeg', 'png', 'bmp']//文件类型限制，默认不限制，注意写的是文件后缀
    });

    function beforeUploadFun(opt) {
        var VinCode = $("#VinCode").val();
        var CarModels=$("#CarModels").val();
        var SerialNum=$("#SerialNum").val();
        var MotorNum=$("#MotorNum").val();
        opt.otherData = [
            {"name": "VinCode", "value": VinCode},
            {"name": "CarModels", "value": CarModels},
            {"name": "SerialNum", "value": SerialNum},
            {"name": "MotorNum", "value": MotorNum},
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
        "uploadUrl": "../ajax.php?act=safeDateAdd",//上传文件信息地址
        "size": 3500,//文件大小限制，单位kb,默认不限制
        "maxFileNumber": 10,//文件个数限制，为整数
        //"filelSavePath":"",//文件上传地址，后台设置的根目录
        "beforeUpload": beforeUploadFun2,//在上传前执行的函数
        "onUpload": onUploadFun2,//在上传后执行的函数
        //autoCommit:true,//文件是否自动上传
        "fileType": ['jpg', 'jpeg', 'png', 'bmp']//文件类型限制，默认不限制，注意写的是文件后缀
    });

    function beforeUploadFun2(opt) {
        var VinCode = $("#VinCode").val();
        var CarModels=$("#CarModels").val();
        var SerialNum=$("#SerialNum").val();
        var MotorNum=$("#MotorNum").val();
        opt.otherData = [
            {"name": "VinCode", "value": VinCode},
            {"name": "CarModels", "value": CarModels},
            {"name": "SerialNum", "value": SerialNum},
            {"name": "MotorNum", "value": MotorNum},
            {"name": "type", "value": "1"}
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
</script>
</body>
</html>
