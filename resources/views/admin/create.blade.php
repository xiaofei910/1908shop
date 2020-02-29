<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8"> 
	<title>Bootstrap 实例 - 水平表单</title>
	<link rel="stylesheet" href="/static/css/bootstrap.min.css">  
	<script src="/static/js/jquery.min.js"></script>
	<script src="/static/js/bootstrap.min.js"></script>
	<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<center><h3>管理员添加</h3></center>
<form class="form-horizontal" role="form" action="{{url('/admin/store')}}" method="post" enctype="multipart/form-data">
	@csrf
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">账户</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="firstname" name="username" placeholder="请输入账户">
				   <!-- 显示单个错误信息 -->
			<b style="color:red"></b>
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">密码</label>
		<div class="col-sm-10">
			<input type="password" class="form-control" id="password1" name="password" placeholder="请输入密码">
				   <!-- 显示单个错误信息 -->
			<b style="color:red"></b>
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">确认密码</label>
		<div class="col-sm-10">
			<input type="password" class="form-control" id="password2" name="pwd" placeholder="请确认密码">
			<b style="color:red"></b>
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">手机号</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="lastname" name="tel" placeholder="请输入手机号">
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">邮箱</label>
		<div class="col-sm-10">
			<input type="email" class="form-control" id="lastname" name="email" placeholder="请输入邮箱">
		</div> 
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">头像</label>
		<div class="col-sm-10">
			<input type="file" class="form-control" id="lastname" name="img">
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button type="button" id="but" class="btn btn-default">添加</button>
		</div>
	</div>
</form>

</body>
<script type="text/javascript">
	//ajax表单令牌
	$.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
	//阻止表单提交
	$('#but').click(function(){
		var flag=true;
		$('#firstname').next().html('');
		// alert(123);return false;
		var username=$('#firstname').val();
		// console.log(username);return false;
		var reg=/^[0-9a-zA-Z_]{2,12}$/;
		if(!reg.test(username)){
			$('#firstname').next().html('账号由2-12位、数字、字母下划线组成，且不能为空');
			return;
		}
		//验证唯一性
		$.ajax({
			type:'post',
			url:"/admin/checkOnly",
			data:{username:username},
			async:false,
			dataType:'json',
			success:function(result){
				// console.log(result);
				if(result.count>0){
					$("#firstname").next().html('账号已存在');
					flag=false;
				}
			}
		});
		// alert(atitleflag);
		if(!flag){
			return;
		}
		//验证密码
		var password1=$('#password1').val();
		var reg=/^[0-9a-zA-Z_]{2,18}$/;
		if(!reg.test(password1)){
			$('#password1').next().html('密码长度为2到18位之间，且不为空');
			return;
		}
		// alert('ok');
		// 确认密码
		var password2=$('#password2').val();
		if(password1!=password2){
			$('#password2').next().html('确认密码与密码不一致');
			return;
		}
		//form提交
		$('form').submit();
	});
	//验证密码
	$('#password1').blur(function(){
		$(this).next().html('');
		var password1=$('#password1').val();
		var reg=/^[0-9a-zA-Z_]{2,18}$/;
		if(!reg.test(password1)){
			$('#password1').next().html('密码长度为2到18位之间，且不为空');
			return;
		}
	});
	$('#password2').blur(function(){
		$(this).next().html('');
		var password1=$('#password1').val();
		// console.log(password1);return false;
		var password2=$('#password2').val();
		if(password1!=password2){
			$(this).next().html('确认密码与密码不一致');
			return;
		}
	});
	$("#firstname").blur(function(){
		//清空错误信息
		$(this).next().html('');
		var username=$(this).val();
		// console.log(username);return false;
		var reg=/^[0-9a-zA-Z_]{2,12}$/;
		// alert(reg.test(username));return false;
		if(!reg.test(username)){
			$(this).next().html('账号由2-12位、数字、字母下划线组成，且不能为空');
			return;
		}
		
		//验证唯一性
		$.ajax({
			type:'post',
			url:"/admin/checkOnly",
			data:{username:username},
			dataType:'json',
			success:function(result){
				// console.log(result);
				if(result.count>0){
					$("#firstname").next().html('账号已存在');
				}
			}
		});
	})

</script>
</html>