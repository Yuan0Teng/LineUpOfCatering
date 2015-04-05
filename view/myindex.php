<?php
//告诉浏览器此页面的过期时间
header("Expires: Mon, 26 Jul 1970 05:00:00  GMT");
//告诉浏览器此页面的最后更新日期(用格林威治时间表示)也就是当天,目的就是强迫浏览器获取最新资料
header("Last-Modified:" . gmdate("D, d M Y  H:i:s")  . "GMT");
//告诉客户端浏览器不使用缓存
header("Cache-Control:no-cache, must-revalidate");

require_once dirname(__FILE__)."/../controllers/get_data.php";
?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html>
<head lang="en">
    <meta charset="UTF-8">
    <!--控制移动设备缩放-->
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" />

    <title>排队软件12</title>
    <link rel="stylesheet" type="text/css" href="css/base.css" >
    <link rel="stylesheet" type="text/css" href="jqueryMobile/jquery.mobile-1.3.2.min.css">
    <link rel="stylesheet" type="text/css" href="jqueryMobile/jquery.mobile.theme-1.3.2.min.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">

    <script type="text/javascript" src="jqueryMobile/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="jqueryMobile/jquery.mobile-1.3.2.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#nameCheck").eq(0).hide();
        });

        function noticeOne(id){
            if (!confirm("您确认要-提醒-编号为 "+id+" 的顾客吗?")){
                return;
            }
            $.post("../controllers/operator.php",
                {
                    "data":"{ \"id\":"+id+" }",
                    "operator":"notice"
                },
                function(data,status){
                    //alert("原数据"+data+"\n状态：" + status);
                    if(status=="success"){
                        if(data=="true"){
                            alert("提醒成功!");
                            $('#'+id).remove();
                        }else {
                            alert("提醒失败!")
                        }
                    }

                });
        }
        function cancelOne(id){
            if (!confirm("您确认要-取消-编号为 "+id+" 的顾客吗?")){
                return;
            }
            $.post("../controllers/operator.php",
                {
                    "data":"{ \"id\":"+id+" }",
                    "operator":"cancel"
                },
                function(data,status){
                    //alert("原数据"+data+"\n数据：" + data.result + "\n状态：" + status);
                    if(status=="success"){
                        if(data=="true"){
                            alert("取消成功!");
                            $('#'+id).remove();
                        }else {
                            alert("取消失败!")
                        }
                    }
                });
        }
        function addOne(){
            var cstmrLastName = $('#fname').val();
            var LadyOrSir = $('input[name="gender"]:checked').val();
            var cstmrNane = cstmrLastName+LadyOrSir;
            var cellPhone = $('#cellphone').val();
            var size = $('input[name="sizes"]:checked').val();

            if(confirm("姓名:"+cstmrNane+"\n电话:"+cellPhone+"\n规模:"+size) ){
                $.post(
                    "../controllers/operator.php",
                    {
                        "data":'{ "cstmrName" : "' +cstmrNane+'"'
                              +', "cellPhone" : ' +cellPhone
                              +', "size" : '+size+' }',
                        "operator":"add"
                    },
                    function(data,status){
                        //alert("原数据"+data+"\n状态：" + status);
                        if(status=="success"){
                            if(data=="true"){
                                alert("添加成功!");
                                location.reload(true);
                            }else {
                                alert("添加失败!");
                                //alert("原数据"+data+"\n状态：" + status);
                            }
                        }

                    }
                )
            }

        }

        function checkName(){
            var x=$('#fname').val();
            //alert(x);
            if(x==null || x==""){

                $("#nameCheck").eq(0).html("姓氏不能为空!");
                $("#nameCheck").eq(0).css("color","red");
                $("#nameCheck").eq(0).css("margin-left","100px");
                $("#nameCheck").eq(0).show();
                return false;
            }else{
                $("#nameCheck").eq(0).hide();
                return true;
            }
        }
        function checkPhone(){
            var x=$('#cellphone').val();
            if(x==null || x==""){
                $("#phoneCheck").eq(0).html("手机号码不能为空!");
                $("#phoneCheck").eq(0).css("color","red");
                $("#phoneCheck").eq(0).css("margin-left","100px");
                $("#phoneCheck").eq(0).show();
                return false;
            }else if(wrongPhone(x)){
                $("#phoneCheck").eq(0).html("手机号码不合法!");
                $("#phoneCheck").eq(0).css("color","red");
                $("#phoneCheck").eq(0).css("margin-left","100px");
                $("#phoneCheck").eq(0).show();
            }else{
                $("#nameCheck").eq(0).hide();
                return true;
            }
        }

        function wrongPhone(phoneNum){

        }
    </script>
</head>
<body>
    <div data-role="page" >
        <div data-role="content" data-theme="c">
            <div class="left-menu" >
                <div class="menu-ui-top">
                    <h3>五棵松餐厅</h3>
                </div>

                <div class="menu-ui-status">
                    <span><img style='padding-right:10px' src="img/nowait.jpg" height="50px" ></span>
                    <span><img style='padding-right:10px' src="img/wait.jpg" height="50px" ></span>
                    <span><img src="img/stop.png" height="50px" ></span>
                </div>
                <div class="menu-ui-img">
                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                        </ol>

                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox">
                            <div class="item active">
                                <img src="img/t1.jpg" alt="">
                            </div>
                            <div class="item">
                                <img src="img/t2.jpg"  alt="">
                            </div>
                            <div class="item">
                                <img src="img/t3.jpg"  alt="">
                            </div>
                        </div>

                        <!-- Controls -->
                        <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                            <span class="sr-only">Next</span>
                        </a>
                    </div>

                    <div class="menu-ui-add" >
                        <a href="add_mobile.html" data-role="button" data-icon="plus" data-rel="dialog" >添加</a>
                    </div>
                </div>
            </div>
            <div class="right-line" style="background-color: #ffffff">
                    <table class="table table-striped">
                        <tr>
                            <td>队列号</td>
                            <td>手机号</td>
                            <td>先生/女士</td>
                            <td>人数</td>
                            <td align="center">操作</td>
                        </tr>
                            <?php
                            $arr = get_data();
                            foreach ($arr as $row){
                                ?>
                                <tr id="<?php echo $row["id"];?>">
                                    <td><?php echo $row["id"];?></td>
                                    <td><?php echo $row["cell_phone"]?></td>
                                    <td><?php echo $row["cstmr_name"]?></td>
                                    <td><?php echo $row["size"]?></td>
                                    <td align="center">
                                        <button type="button" class="btn btn-primary" onclick="noticeOne(<?php echo $row["id"];?>);">T</button>
                                        <button type="button" class="btn btn-danger"  onclick="cancelOne(<?php echo $row["id"];?>);">X</button>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                    </table>
                <nav>
                    <ul class="pagination">
                        <li><a href="#"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li>
                        <li class="active"><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                        <li><a href="#"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</body>
</html>