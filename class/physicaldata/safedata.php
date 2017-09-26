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
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <style>
        .form-group2{
            margin-bottom: 5px;
        }
        .form-group2 label{
            text-align: right;
            min-width: 85px;
            margin-right: 5px;
        }
        .QP-img label{
            text-align: right;
            min-width: 85px;
            margin-right: 5px;
        }
        .form-inline{
            margin-bottom: 20px;
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
                        <a href="#">安全数据</a>
                    </li>
                </ul>
            </div>
            <!-- 表单 -->
            <h4>安全数据录入</h4>
            <form class="form-inline" role="form">
                <div class="form-group">
                    <label for="firstname">Vin码</label>
                    <input type="text" class="form-control vincode" id="vincode"
                           placeholder="请输入Vin码(17位字母数字组合)" autocomplete="on">
                </div>
                <div class="form-group">
                    <button class="op-botton" type="button">检索</button>
                </div>
            </form>
            <div class="navbar navbar-default"><span class="navbar-brand">QP单</span></div>
            <form class="form-inline" role="form">
                <div class="form-group2">
                    <label for="firstname">车型：</label>
                    <input type="text" class="form-control" id="firstname"
                           placeholder="请输入车型编号">
                </div>
                <div class="form-group2">
                    <label for="firstname">生产流水号：</label>
                    <input type="text" class="form-control" id="firstname"
                           placeholder="请输入生产流水号">
                </div>
                <div class="form-group2">
                    <label for="firstname">电机号：</label>
                    <input type="text" class="form-control" id="firstname"
                           placeholder="请输入电机号">
                </div>
                <div class="form-group QP-img">
                    <label for="firstname">QP单(图)：</label>
                    <input type="text" class="form-control" id="firstname"
                           placeholder="请选择QP图片导入">
                </div>
                <div class="form-group">
                    <input type="file" id="inputfile">
                </div>
                <div class="form-group2">
                    <button>提交</button>
                </div>
            </form>
            <div class="navbar navbar-default"><span class="navbar-brand">检测线数据</span></div>
            <form class="form-inline" role="form">
                <div class="form-group2">
                    <label for="firstname">车型：</label>
                    <input type="text" class="form-control" id="firstname"
                           placeholder="请输入车型编号">
                </div>
                <div class="form-group2">
                    <label for="firstname">生产流水号：</label>
                    <input type="text" class="form-control" id="firstname"
                           placeholder="请输入生产流水号">
                </div>
                <div class="form-group2">
                    <label for="firstname">电机号：</label>
                    <input type="text" class="form-control" id="firstname"
                           placeholder="请输入电机号">
                </div>
                <div class="form-group QP-img">
                    <label for="firstname">检测线数据：</label>
                    <input type="text" class="form-control" id="firstname"
                           placeholder="请选择检测线数据图片导入">
                </div>
                <div class="form-group">
                    <input type="file" id="inputfile">
                </div>
                <div class="form-group2">
                    <button>提交</button>
                </div>
            </form>
            <div class="">
                <ul>
                    <li>录入日志</li>
                    <li>错误</li>
                </ul>
            </div>
            <div class="" role="">
                <div class="">
                    <label for="firstname">录入日志</label>
                </div>
                <div class="form-group">
                    <label for="firstname">错误</label>
                </div>
            </div>

        </div>
    </div>
</div>
<script src="../../public/js/jquery-1.11.1.min.js"></script>
<script src="../../public/js/bootstrap.min.js"></script>
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
</script>
</body>
</html>
