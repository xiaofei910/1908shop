<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Author" contect="http://www.webqin.net">
    <title>详情</title>
    <link rel="shortcut icon" href="/static/index/images/favicon.ico" />
    
    <!-- Bootstrap -->
    <link href="/static/index/css/bootstrap.min.css" rel="stylesheet">
    <link href="/static/index/css/style.css" rel="stylesheet">
    <link href="/static/index/css/response.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond./static/index/js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="maincont">
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>产品详情</h1>
      </div>
     </header> 
     访问量：<b style="color:red">{{$num}}</b>
     <div id="sliderA" class="slider">
        @foreach($goodsInfo->goods_imgs as $v)
        <img src="{{env('UPLOAD_URL')}}{{$v}}"/>
        @endforeach
    
     </div>

     <!--sliderA/-->
     <table class="jia-len">
      <tr>
       <th><strong class="orange">{{$goodsInfo->goods_price}}</strong></th>
       <td> 
        <input type="button" value="-" style="width:25px" id='lass'/> 
        <input type="text" value="1" style="width:35px"  id='buy_number'/>
        <input type="button" value="+" style="width:25px" id='add'/>
        <!-- <input type="text" class="spinnerExample buy_number" /> -->
       </td>
      </tr>
      <tr>
       <td>
        <strong>{{$goodsInfo->goods_name}}</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;库存：<strong id="goods_num">{{$goodsInfo->goods_num}}</strong>
        <p class="hui">{{$goodsInfo->goods_desc}}</p>
       </td>

       <td align="right">
        <a href="javascript:;" class="shoucang"><span class="glyphicon glyphicon-star-empty"></span></a>
       </td>
      </tr>
     </table>
     <div class="height2"></div>
     <h3 class="proTitle">商品规格</h3>
     <ul class="guige">
      <li class="guigeCur"><a href="javascript:;">50ML</a></li>
      <li><a href="javascript:;">100ML</a></li>
      <li><a href="javascript:;">150ML</a></li>
      <li><a href="javascript:;">200ML</a></li>
      <li><a href="javascript:;">300ML</a></li>
      <div class="clearfix"></div>
     </ul><!--guige/-->
     <div class="height2"></div>
     <div class="zhaieq">
      <a href="javascript:;" class="zhaiCur">商品简介</a>
      <a href="javascript:;">商品参数</a>
      <a href="javascript:;" style="background:none;">订购列表</a>
      <div class="clearfix"></div>
     </div><!--zhaieq/-->
     <div class="proinfoList">
      <img src="{{env('UPLOAD_URL')}}{{$goodsInfo->goods_img}}" width="636" height="822" />
     </div><!--proinfoList/-->
     <div class="proinfoList">
      暂无信息....
     </div><!--proinfoList/-->
     <div class="proinfoList">
      暂无信息......
     </div><!--proinfoList/-->
     <table class="jrgwc">
      <tr>
       <th>
        <a href="index.html"><span class="glyphicon glyphicon-home"></span></a>
       </th>
       <td><a href="javascript:;" id="addCart">加入购物车</a></td>
      </tr>
     </table>
    </div><!--maincont-->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="/static/index/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/static/index/js/bootstrap.min.js"></script>
    <script src="/static/index/js/style.js"></script>
    <!--焦点轮换-->
    <script src="/static/index/js/jquery.excoloSlider.js"></script>
    <script>
		$(function () {
		 $("#sliderA").excoloSlider();
		});
	</script>
     <!--jq加减-->
    <script src="/static/index/js/jquery.spinner.js"></script>
   <script>
	$('.spinnerExample').spinner({});
	</script>
  </body>
  <script type="text/javascript">
     //给+绑定一个点击事件
        $(document).on('click','#add',function(){
            // alert(1);
            // 获取文本框的购买数量
            var buy_number=parseInt($("#buy_number").val());
            //获取库存的值
            var goods_num=parseInt($("#goods_num").text());
            // console.log(typeof buy_number);
            // console.log(typeof goods_num);
            if(buy_number>=goods_num){
                $("#buy_number").val(goods_num);
            }else{
                var buy_number=buy_number+1;
                $("#buy_number").val(buy_number);
            }
        });
         //给-绑定一个点击事件
        $(document).on('click','#lass',function(){
            // alert(1);
            //获取文本框的购买数量
            var buy_number=parseInt($("#buy_number").val());
            if(buy_number<=1){
                $("#buy_number").val(1);
            }else{
                var buy_number=buy_number-1;
                $("#buy_number").val(buy_number);
            }
        })
        //给文本框绑定一个失去焦点事件
        $(document).on('blur','#buy_number',function(){
            // console.log(1);
            //获取文本框的值(购买数量)
            var buy_number=$("#buy_number").val()
            //获取库存的值   转化为整数
            var goods_num=parseInt($("#goods_num").text());
            var reg=/^\d+$/;
            //判断购买数量为空 
            if(buy_number==''){
                // 文本框的值改为1
                $("#buy_number").val(1);
            }else if(!reg.test(buy_number)){
                // 判断购买数量是否为数字 
                // 文本框的值改为1
                $("#buy_number").val(1);
            }else if(parseInt(buy_number)<1){
                // 判断购买数量小于1
                // 文本框的值改为1
                $("#buy_number").val(1);
            }else if(parseInt(buy_number)>goods_num){
                // 判断购买数量>库存
                // 文本框的值改为最大库存
                $("#buy_number").val(goods_num);
            } 
        })
      $('#addCart').click(function(){
          var buy_number=$('#buy_number').val();
          // console.log(append);
          var goods_id="{{$goodsInfo->goods_id}}";
          // console.log(goods_id);
          $.post(
              "/cart/create",
              {'_token':'{{csrf_token()}}',buy_number:buy_number,goods_id:goods_id},
              function(res){
                // console.log(res);
                if(res=='ok'){
                    alert('加入购物车成功');
                    location.href="{{url('/cart/index')}}";
                }else{
                    alert('加入购物车失败');
                }
              }
          );
      })
  </script>
</html>