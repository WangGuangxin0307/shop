<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/style.css"/>
    <link href="assets/css/codemirror.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/ace.min.css" />
    <link rel="stylesheet" href="font/css/font-awesome.min.css" />
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
    <![endif]-->
    <script src="js/jquery-1.9.1.min.js"></script>
    <script src="js/H-ui.js" type="text/javascript"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/typeahead-bs2.min.js"></script>
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/jquery.dataTables.bootstrap.js"></script>
    <script src="assets/layer/layer.js" type="text/javascript" ></script>
    <script src="assets/laydate/laydate.js" type="text/javascript"></script>

    <script src="js/lrtk.js" type="text/javascript" ></script>
    <title>退款管理 - 素材牛模板演示</title>
</head>

<body>
<div class="margin clearfix">
    <div id="refund_style">
        <div class="search_style">

            <form action="index.php?r=order/refund" method="post">
                订单编号：<input type="text" name="order_sn" id="order_sn">
                商品名称：<input type="text" name="commodity" id="commodity">
                <input type="submit" value="搜索">
            </form>
        </div>

        <!--退款列表-->
        <div class="refund_list">
            <table class="table table-striped table-bordered table-hover" id="sample-table">
                <thead>
                <tr>
                    <th width="25px"><label><input type="checkbox" class="ace"><span class="lbl"></span></label></th>
                    <th width="120px">订单编号</th>
                    <th width="250px">产品名称</th>
                    <th width="100px">交易金额</th>
                    <th width="100px">支付时间</th>
                    <th width="100px">退款金额</th>
                    <th width="80px">退款数量</th>
                    <th width="70px">状态</th>
                    <th width="200px">说明</th>
                    <th width="200px">操作</th>
                </tr>
                </thead>
                <?php foreach ($data as $key => $value): ?>
                <tbody>
                <tr>
                    <td><label><input type="checkbox" class="ace"><span class="lbl"></span></label></td>
                    <td><?= $value['order_sn']?></td>
                    <td class="order_product_name">
                        <a href="#"><?= $value['commodity']?></a>
                    </td>
                    <td><?= $value['payment_money']?></td>
                    <td><?= $value['pay_time']?></td>
                    <td><?= $value['payment_money']?></td>
                    <td><?= $value['order_number']?></td>
                    <td class="td-status">
                        <?php if($value['order_status'] == 4){?>
                            <span class="label label-success radius">   代退款 </span>
                        <?php }?>
                        <?php if($value['order_status'] == 6){?>
                            <span class="label label-success radius">   已退款 </span>
                        <?php }?>

                    </td>
                    <td><?= $value['invoice']?></td>
                    <td>
                        <a  href="javascript:;" title="退款" id="<?= $value['order_id']?>"  class="btn btn-xs btn-success">退款</a>
                        <a title="删除" href="javascript:;"  onclick="Order_form_del(this,'1')" class="btn btn-xs btn-warning" >删除</a>
                    </td>
                </tr>
                </tbody>
                <?php endforeach ?>
            </table>

        </div>
    </div>
</div>
<?php
use yii\widgets\LinkPager;


echo LinkPager::widget([
    'pagination' => $pagination
]);
?>
</body>
</html>
<script>
    //订单列表
    jQuery(function($) {
        var oTable1 = $('#sample-table').dataTable( {
            "aaSorting": [[ 1, "desc" ]],//默认第几个排序
            "bStateSave": true,//状态保存
            "aoColumnDefs": [
                //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
                {"orderable":false,"aTargets":[0,2,3,4,5,6,8,9]}// 制定列不参与排序
            ] } );
        //全选操作
        $('table th input:checkbox').on('click' , function(){
            var that = this;
            $(this).closest('table').find('tr > td:first-child input:checkbox')
                .each(function(){
                    this.checked = that.checked;
                    $(this).closest('tr').toggleClass('selected');
                });

        });
    });
    $(".btn").on('click',function () {
        var order_id =$(this).attr("id");
        var title = $(this).attr("title");
        $.ajax({
            url:'index.php?r=order/arefund',
            data:{title:title,order_id:order_id},
            type:'post',
            dataType:'json',
            success:function (res) {
                if (res.code==200){
                    alert(res.msg)
                } else{
                    alert(res.msg)
                }
            }
        })
    });





    //面包屑返回值
    var index = parent.layer.getFrameIndex(window.name);
    parent.layer.iframeAuto(index);
    $('.Refund_detailed').on('click', function(){
        var cname = $(this).attr("title");
        var chref = $(this).attr("href");
        var cnames = parent.$('.Current_page').html();
        var herf = parent.$("#iframe").attr("src");
        parent.$('#parentIframe').html(cname);
        parent.$('#iframe').attr("src",chref).ready();;
        parent.$('#parentIframe').css("display","inline-block");
        parent.$('.Current_page').attr({"name":herf,"href":"javascript:void(0)"}).css({"color":"#4c8fbd","cursor":"pointer"});
        //parent.$('.Current_page').html("<a href='javascript:void(0)' name="+herf+" class='iframeurl'>" + cnames + "</a>");
        parent.layer.close(index);

    });
</script>