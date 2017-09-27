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
    <link rel="stylesheet" href="../../public/css/webuploader.css">
<!--    <link rel="stylesheet" href="../../external/uploadify/uploadify.css">-->
    <script src="/js/project.js"></script>
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <style>
        .form-group2 {
            margin-bottom: 5px;
        }

        .form-group2 label {
            text-align: right;
            min-width: 85px;
            margin-right: 5px;
        }

        .QP-img label {
            text-align: right;
            min-width: 85px;
            margin-right: 5px;
        }

        .form-inline {
            margin-bottom: 20px;
        }
        .log-ul,.log-detail{
            float: left;
            padding-left: 0;
        }
        .log-ul li{
            list-style: none;
            float: left;
            margin-bottom: 0;
            padding: 5px 10px;
            min-width: 80px;
            width: 80px;
            text-align: center;
        }
        .log-box{
            float: left;
            width: 100%;
            display: block;
        }
        .log-active{
            background: #8c8c8c;
        }
        .hide{
            display: none;
        }
        .show{
            display: block;
        }
        .safe-log{
            border-top: 1px solid #989191;
        }
        .log-detail{
            height: 200px;
            max-height: 200px;
            overflow: auto;
            width: 100%;
        }
        .temp-import{
            float: right;
            margin-right: 60px;
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
                        <a href="#">可追溯数据</a>
                    </li>
                </ul>
            </div>
            <!-- 表单 -->
            <h4>可追溯数据录入</h4>
            <div class="navbar navbar-default"><span class="navbar-brand">车辆信息记录</span></div>
            <form class="form-inline QP-order" role="form">
                <div class="commondata form-group">
                    <label for="firstname">车辆信息记录表：</label>
                    <input type="text" class="form-control CarModels" id="" placeholder="请选择车辆信息记录表文件导入" attr="CarModels" title="车辆信息记录">
                </div>
                <div class="form-group">
                    <input type="file" id="inputfile">
                </div>
                <div class="form-group temp-import">
                    <button type="button">标准模板文件导出</button>
                </div>
            </form>
            <div class="navbar navbar-default"><span class="navbar-brand">上海数据平台车辆录入信息</span></div>
            <form class="form-inline QP-order" role="form">
                <div class="commondata form-group">
                    <label for="firstname">上海数据平台车辆录入信息表：</label>
                    <input type="text" class="form-control CarModels" id="" placeholder="请选择上海数据平台车辆录入信息录入表文件导入" attr="CarModels" title="上海数据平台车辆录入信息表">
                </div>
                <div class="form-group">
                    <input type="file" id="inputfile">
                </div>
                <div class="form-group temp-import">
                    <button type="button">标准模板文件导出</button>
                </div>
            </form>
            <div class="navbar navbar-default"><span class="navbar-brand">关键重要零部件厂家出厂检验报告</span></div>
            <form class="form-inline QP-order" role="form">
                <div class="commondata form-group">
                    <label for="firstname">检验报告图片：</label>
                    <input type="text" class="form-control CarModels" id="" placeholder="请选择关键重要零部件厂家出厂检验报告文件导入" attr="CarModels" title="关键重要零部件厂家出厂检验报告">
                </div>
                <div class="form-group">
                    <input type="file" id="inputfile">
                </div>
                <div class="form-group temp-import">
                    <button type="button">标准模板文件导出</button>
                </div>
            </form>
            <div class="safe-log clearfix">
                <div class="log-box">
                    <ul class="log-ul clearfix">
                        <li  style="margin-right: 5px;" class="log-active">录入日志</li>
                        <li>错误</li>
                    </ul>
                </div>
                <div class="log-detail">
                    <div class="success-log">
                    </div>
                    <div class="error-log" style="display: none">
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
    //日志切换
    $(".log-ul li").click(function () {
        $(this).addClass("log-active");
        $(this).siblings().removeClass("log-active");
        var index=$(this).index();
        $(".log-detail div").eq(index).show().siblings().hide();
    })
</script>
</body>
</html>
