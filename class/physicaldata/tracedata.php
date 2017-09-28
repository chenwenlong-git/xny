<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>万象信息管理</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="上海万象 万象信息管理">
	<script src="../../js/jquery-1.11.3.min.js"></script>
    <!--     <link id="bs-css" href="css/bootstrap-cerulean.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="../../public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../public/css/bootstrap-cerulean.min.css">
    <link rel="stylesheet" href="../../public/css/wx-app.css">
    <link rel="stylesheet" href="../../public/css/webuploader.css">
<!--    <link rel="stylesheet" href="../../external/uploadify/uploadify.css">-->
    <script src="../../js/project.js"></script>
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	<link rel="stylesheet" type="text/css" href="../../external/uploadimg/css/common.css" />
	<link rel="stylesheet" type="text/css" href="../../external/uploadimg/css/style.css" />

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
                <div class="commondata form-group">
                    <label for="firstname">车辆信息记录表：</label>
                </div>
				 <div class="form-group">
                    <input type="file"  class="carinfo" id="carinfo">
                </div>
				<button onclick="SE.TraceDataCar()">提交</button>
                <div class="form-group temp-import">
                    <button type="button">标准模板文件导出</button>
                </div>
            <div class="navbar navbar-default"><span class="navbar-brand">上海数据平台车辆录入信息</span></div>
                <div class="commondata form-group">
                    <label for="firstname">上海数据平台车辆录入信息表：</label>
                </div>
                <div class="form-group">
                    <input type="file" class="shanghaicarinfo" id="shanghaicarinfo">
                </div>
				<button onclick="SE.TraceDatashCar()">提交</button>
                <div class="form-group temp-import">
                    <button type="button">标准模板文件导出</button>
                </div>
            <div class="navbar navbar-default"><span class="navbar-brand">关键重要零部件厂家出厂检验报告</span></div>
                 <div class="commondata form-group">
                    <label for="firstname">检验报告图片：</label>
                </div>
			 <a class="btn" id="btn">上传图片</a>  最大500KB，支持jpg，gif，png格式。
			 <ul id="ul_pics" class="ul_pics clearfix"></ul>
              <button onclick="SE.PartsReport()">提交</button>
                <div class="form-group temp-import">
                    <button type="button">标准模板文件导出</button>
                </div>
            <div class="safe-log clearfix">
                <div class="log-box">
                    <ul class="log-ul clearfix">
                        <li  style="margin-right: 5px;" class="log-active">录入日志</li>
                        <li>错误</li>
                    </ul>
                </div>
                <div class="log-detail">
                    <div class="success-log">
					  <ul>
					     
					  </ul>
                    </div>
                    <div class="error-log" style="display: none">
						<ul>

					    </ul>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
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

<script type="text/javascript" src="../../external/uploadimg/js/plupload.full.min.js"></script>
<script type="text/javascript">
			var uploader = new plupload.Uploader({ //创建实例的构造方法
				runtimes: 'html5,flash,silverlight,html4', //上传插件初始化选用那种方式的优先级顺序
				browse_button: 'btn', // 上传按钮
				url: "../../external/uploadimg/ajax.php", //远程上传地址
				flash_swf_url: 'plupload/Moxie.swf', //flash文件地址
				silverlight_xap_url: 'plupload/Moxie.xap', //silverlight文件地址
				filters: {
					max_file_size: '500kb', //最大上传文件大小（格式100b, 10kb, 10mb, 1gb）
					mime_types: [ //允许文件上传类型
						{
							title: "files",
							extensions: "jpg,png,gif,ico"
						}
					]
				},
				multi_selection: true, //true:ctrl多文件上传, false 单文件上传
				init: {
					FilesAdded: function(up, files) { //文件上传前
						if ($("#ul_pics").children("li").length > 30) {
							alert("您上传的图片太多了！");
							uploader.destroy();
						} else {
							var li = '';
							plupload.each(files, function(file) { //遍历文件
								li += "<li id='" + file['id'] + "'><div class='progress'><span class='bar'></span><span class='percent'>0%</span></div></li>";
							});
							$("#ul_pics").append(li);
							uploader.start();
						}
					},
					UploadProgress: function(up, file) { //上传中，显示进度条
						var percent = file.percent;
						$("#" + file.id).find('.bar').css({
							"width": percent + "%"
						});
						$("#" + file.id).find(".percent").text(percent + "%");
					},
					FileUploaded: function(up, file, info) { //文件上传成功的时候触发
						var data = eval("(" + info.response + ")");
						$("#" + file.id).html("<div class='img'><img src='" + data.pic + "'/></div><p>" + data.name + "</p>");
					},
					Error: function(up, err) { //上传出错的时候触发
						alert(err.message);
					}
				}
			});
			uploader.init();
</script>

</body>
</html>
