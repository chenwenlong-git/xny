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
    <link rel="stylesheet" href="../../external/uploadify/uploadify.css">
    <script src="/js/project.js"></script>
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
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
                <div class="commondata form-group2">
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
                    <input type="text" class="form-control ImgUrl inputs_0" id="qpurl" placeholder="请选择QP单图片导入" attr="ImgUrl" title="QP单(图)" readonly="readonly">
                    <div id="uploadimg">
                        <div id="fileList" class="uploader-list"></div>
                        <div id="imgPicker">选择图片</div>
                    </div>
                </div>
                <div class="form-group2">
                    <button type="button" class="btn btn-primary btn-sm" onclick="SE.safeDateAdd(0);">提交</button>
                </div>
            </form>
            <div class="navbar navbar-default"><span class="navbar-brand">检测线数据</span></div>
            <form class="form-inline line-data" role="form">
                <div class="commondata2 form-group QP-img">
                    <label for="firstname">检测线数据：</label>
                    <input type="text" class="form-control ImgUrl inputs_1" id="jcxurl" placeholder="请选择检测线数据图片导入" attr="ImgUrl" title="检测线数据" readonly="readonly">
                    <div id="uploadimg">
                        <div id="fileList2" class="uploader-list2"></div>
                        <div id="imgPicker2">选择图片</div>
                    </div>
                </div>
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
<script src="../../public/js/jquery-1.11.1.min.js"></script>
<script src="../../public/js/bootstrap.min.js"></script>
<script src="../../public/js/webuploader.js"></script>


<script>
    $(document).ready(function () {
        $("#inputs").change(function () {
            var fil = this.files;
            for (var i = 0; i < fil.length; i++) {
                reads(fil[i]);
            }
        });
    });
    var innerImg = document.getElementById("desti");

    function reads(fil) {
        var reader = new FileReader();
        reader.readAsDataURL(fil);

        reader.onload = function () {
            innerImg.innerHTML += "<img src='../../001.png'></br>";
            innerImg.innerHTML += "<a  style='padding-left:10px'>aaa</a>";
        };
    }

    //QP单上传
    var uploader = WebUploader.create({
        auto: true, // 选完文件后，是否自动上传
        swf: 'js/Uploader.swf', // swf文件路径
        server: '../ajax.php?act=uploadify', // 文件接收服务端
        pick: '#imgPicker', // 选择文件的按钮。可选
        // 只允许选择图片文件。
        accept: {
            title: 'Images',
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/*'
        }
    });
    uploader.on('fileQueued', function (file) {
        var $list = $("#fileList"),
            $li = $(
                '<div id="' + file.id + '" class="file-item thumbnail" style="display: inline-block;margin-right: 15px;"><button onclick="removeData(this);" type="button" style="z-index:999;position:absolute;top 0px;right:0px;top:-1px;"> &times;</button>' +
                '<img>' +
                '<div class="datainfo">' + file.name + '</div>' +
                '</div>'
            ),
            $img = $li.find('img');
        // $list为容器jQuery实例
        $list.append($li);
        // 创建缩略图
        uploader.makeThumb(file, function (error, src) {
            if (error) {
                $img.replaceWith('<span>不能预览</span>');
                return;
            }
            $img.attr('src', src);
        }, 100, 100); //100x100为缩略图尺寸
    });
    // 文件上传过程中创建进度条实时显示。
    uploader.on('uploadProgress', function (file, percentage) {
        var $li = $('#' + file.id),
            $percent = $li.find('.progress span');
        // 避免重复创建
        if (!$percent.length) {
            $percent = $('<p class="progress"><span></span></p>')
                .appendTo($li)
                .find('span');
        }
        $percent.css('width', percentage * 100 + '%');
    });

    // 文件上传成功，给item添加成功class, 用样式标记上传成功。
    uploader.on('uploadSuccess', function (file, res) {
        $('#' + file.id).addClass('upload-state-done');
        $('#' + file.id).find(".datainfo").html(res.data);
        var time=new Date().toLocaleString(); //获取当前时间
        if(res.code==1){
            $("#log").prepend("<p style='color:green;'>"+res.message+"  "+time+"</p>");
            $(".op-log").click();
        } else{
            $("#err").prepend("<p style='color:red;'>"+res.message+"  "+time+"</p>");
            $(".op-err").click();
        }
        var dataname="";
        $('.datainfo').each(function () {
            dataname+=$(this).html()+";";
        });
        console.log(dataname);
        $(".inputs_0").val(dataname);
    });

    // 文件上传失败，显示上传出错。
    uploader.on('uploadError', function (file) {
        var $li = $('#' + file.id),
            $error = $li.find('div.error');

        // 避免重复创建
        if (!$error.length) {
            $error = $('<div class="error"></div>').appendTo($li);
        }

        $error.text('上传失败');
    });

    // 完成上传完了，成功或者失败，先删除进度条。
    uploader.on('uploadComplete', function (file) {
        $('#' + file.id).find('.progress').remove();
    });
    uploader.on('fileDequeued', function (file) {

        fileCount--;
        removeFile(file);

    });


    //检测线数据上传
    var uploader1 = WebUploader.create({
        auto: true, // 选完文件后，是否自动上传
        swf: 'js/Uploader.swf', // swf文件路径
        server: '../ajax.php?act=uploadify', // 文件接收服务端
        pick: '#imgPicker2', // 选择文件的按钮。可选
        // 只允许选择图片文件。
        accept: {
            title: 'Images',
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/*'
        }
    });
    uploader1.on('fileQueued', function (file) {
        var $list = $("#fileList2"),
            $li = $(
                '<div id="' + file.id+"_2" + '" class="file-item thumbnail" style="display: inline-block;margin-right: 15px;"><button onclick="removeData(this);" type="button" style="z-index:999;position:absolute;top 0px;right:0px;top:-1px;"> &times;</button>' +
                '<img>' +
                '<div class="datainfo2">' + file.name + '</div>' +
                '</div>'
            ),
            $img = $li.find('img');
        // $list为容器jQuery实例
        $list.append($li);
        // 创建缩略图
        uploader1.makeThumb(file, function (error, src) {
            if (error) {
                $img.replaceWith('<span>不能预览</span>');
                return;
            }

            $img.attr('src', src);
        }, 100, 100); //100x100为缩略图尺寸
    });
    // 文件上传过程中创建进度条实时显示。
    uploader1.on('uploadProgress', function (file, percentage) {
        var $li = $('#' + file.id+"_2" ),
            $percent = $li.find('.progress span');
        // 避免重复创建
        if (!$percent.length) {
            $percent = $('<p class="progress"><span></span></p>')
                .appendTo($li)
                .find('span');
        }
        $percent.css('width', percentage * 100 + '%');
    });

    // 文件上传成功，给item添加成功class, 用样式标记上传成功。
    uploader1.on('uploadSuccess', function (file, res) {
        $('#' + file.id+"_2").addClass('upload-state-done');
        $('#' + file.id+"_2").find(".datainfo2").html(res.data);
        var time=new Date().toLocaleString(); //获取当前时间
        if(res.code==1){
            $("#log").prepend("<p style='color:green;'>"+res.message+"  "+time+"</p>");
            $(".op-log").click();
        } else{
            $("#err").prepend("<p style='color:red;'>"+res.message+"  "+time+"</p>");
            $(".op-err").click();
        }
        var dataname="";
        $('.datainfo2').each(function () {
            dataname+=$(this).html()+";";
        });
        console.log(dataname);
        $(".inputs_1").val(dataname);
    });
    // 文件上传失败，显示上传出错。
    uploader1.on('uploadError', function (file) {
        var $li = $('#' + file.id+"_2"),
            $error = $li.find('div.error');

        // 避免重复创建
        if (!$error.length) {
            $error = $('<div class="error"></div>').appendTo($li);
        }

        $error.text('上传失败');
    });

    // 完成上传完了，成功或者失败，先删除进度条。
    uploader1.on('uploadComplete', function (file) {
        $('#' + file.id+"_2").find('.progress').remove();
    });
    uploader1.on('fileDequeued', function (file) {

        fileCount--;
        removeFile(file);

    });


    //日志切换
    $(".log-ul li").click(function () {
        $(this).addClass("log-active");
        $(this).siblings().removeClass("log-active");
        var index = $(this).index();
        $(".log-detail div").eq(index).show().siblings().hide();
    })

    $("#fileList").on('click', 'button', function () {
        var _close = confirm("确定要删除吗？");
        if (_close) {
            $(this).parent().remove();
        }
    })

    $(".inputs").change(function () {
        this_ = "inputs";
        var fil = this.files;
        console.log(fil);
        for (var i = 0; i < fil.length; i++) {
            reads(fil[i]);
            val1 += fil[i].name + ";";
        }
        $(".factor-doc1").val(val1);

    });

    function removeData(e) {
        var _close = confirm("确定要删除吗？");
        if (_close) {
            $(e).parent().remove();
        }
    }
</script>
</body>
</html>
