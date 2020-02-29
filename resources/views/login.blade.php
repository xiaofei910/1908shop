<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8"> 
	<title>登录</title>
	<link rel="stylesheet" href="/static/css/bootstrap.min.css">  
	<script src="/static/js/jquery.min.js"></script>
	<script src="/static/js/bootstrap.min.js"></script>
</head>
<body>
<center><h3>登录</h3></center>
<!--显示所有错误信息-->
<!-- @if($errors->any())
<div class='alert alert-danger'>
	<ul>
		@foreach($errors->all() as $error)
		<li>{{$error}}</li>
		@endforeach
	</ul>
</div>
@endif -->
<center><b style="color:red">{{session('msg')}}</b></center>
<form class="form-horizontal" role="form" action="{{url('/admin/logindo')}}" method="post" enctype="multipart/form-data">
	@csrf
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">用户名</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="firstname" name="user_name"
				   placeholder="请输入名字">
				   <!-- 显示单个错误信息 -->
			<b style="color:red">{{$errors->first('username')}}</b>
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">密码</label>
		<div class="col-sm-10">
			<input type="password" class="form-control" id="lastname" name="pwd"
				   placeholder="请输入密码">
				   <!-- 显示单个错误信息 -->
			<b style="color:red">{{$errors->first('age')}}</b>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button type="submit" class="btn btn-default">登录</button>
		</div>
	</div>
</form>

</body>
</html>