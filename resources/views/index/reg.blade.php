    @extends('layouts.shop')

    @section('title', '注册')
   
 
   @section('content')

     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>会员注册</h1>
      </div>
     </header>
     <div class="head-top">
      <img src="/static/index/images/head.jpg" />
     </div><!--head-top/-->
     <form action="{{url('reg/regdo')}}" method="post" class="reg-login">
      @csrf
      <h3>已经有账号了？点此<a class="orange" href="{{url('/login')}}">登陆</a></h3>
      <h3 style="color:red">{{session('msg')}}</h3>
      <div class="lrBox">
       <div class="lrList"><input type="text" id="tel"  name="tel" placeholder="输入手机号码或者邮箱号" /><b style="color:red"></b></div>
       <div class="lrList2"><input type="text" name="code" id="sms" placeholder="输入短信验证码"/><b style="color:red"></b><button type="button">获取验证码</button> </div>
       <div class="lrList"><input type="password" id="pwd" name="pwd" placeholder="设置新密码（6-18位数字或字母）" /><b style="color:red"></b></div>
       <div class="lrList"><input type="password" id="pwd2" name="pwd2" placeholder="再次输入密码" /><b style="color:red"></b></div>
      </div><!--lrBox/-->
      <div class="lrSub">
       <input type="button" id="but" value="立即注册" />
      </div>
     </form><!--reg-login/-->
  @endsection
  <script type="text/javascript" src="/static/js/jquery.min.js"></script>
  <script type="text/javascript">
    $(function(){
      //提交
      $('#but').click(function(){
        var flag=true;
        $('#firstname').next().html('');
        //手机号验证
        var tel=$('#tel').val();
        var reg=/^1[3589]\d{9}$/;
        if(!reg.test(tel)){
          $('#tel').next().html('手机号格式不正确，且不能为空');
          return;
        }
        //手机号唯一性
        $.ajax({
          type:'post',
          url:"/reg/checkOnly",
          data:{'_token':'{{csrf_token()}}',tel:tel},
          async:false,
          dataType:'json',
          success:function(result){
            if(result.count>0){
              $("#tel").next().html('该手机号已注册过了！');
              flag=false;
            }
          }
        });
        if(!flag){
          return;
        }
      
        //验证密码
        var pwd=$('#pwd').val();
        var reg=/^[0-9a-zA-Z_]{2,18}$/;
        if(!reg.test(pwd)){
          $('#pwd').next().html('密码长度为2到18位之间，且不为空');
          return;
        }
        // alert('ok');
        // 确认密码
        var pwd2=$('#pwd2').val();
        if(pwd!=pwd2){
          $('#pwd2').next().html('确认密码与密码不一致');
          return;
        }
        
        //form提交
      $('form').submit();
      })
      //手机号验证
      $('button').click(function(){
      // alert(123);return false;
        var tel=$('#tel').val();
        var reg=/^1[3589]\d{9}$/;
        if(!reg.test(tel)){
          $('#tel').next().html('手机号格式不正确，且不能为空');
          return;
        }
        $.get('/send',{tel:tel},function(result){
            alert(result.font);
            // console.log(result);
        },'json');
      })
      //验证密码
      $('#pwd').blur(function(){
        $(this).next().html('');
        var pwd=$('#pwd').val();
        var reg=/^[0-9a-zA-Z_]{2,18}$/;
        if(!reg.test(pwd)){
          $('#pwd').next().html('密码长度为2到18位之间，且不为空');
          return;
        }
      });
      //确认密码
      $('#pwd2').blur(function(){
        $(this).next().html('');
        var pwd=$('#pwd').val();
        // console.log(password1);return false;
        var pwd2=$('#pwd2').val();
        if(pwd!=pwd2){
          $(this).next().html('确认密码与密码不一致');
          return;
        }
      });
    })
    
  </script>