<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8"> 
	<title>Bootstrap 实例 - 水平表单</title>
	<link rel="stylesheet" href="/static/css/bootstrap.min.css">  
	<script src="/static/js/jquery.min.js"></script>
	<script src="/static/js/bootstrap.min.js"></script>
</head>
<body>
<center><h3>外来人口编辑</h3></center>
<form class="form-horizontal" role="form" action="{{url('/people/update/'.$info->p_id)}}" method="post" enctype="multipart/form-data">
	@csrf
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">名字</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="firstname" name="username" value="{{$info->username}}"
				   placeholder="请输入名字">
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">年龄</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="lastname" name="age" value="{{$info->age}}"
				   placeholder="请输入年龄">
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">身份证号</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="lastname" name="card" value="{{$info->card}}"
				   placeholder="请输入身份证号">
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">是否是湖北人</label>
		<div class="radio">
		    <label>
		        <input type="radio" name="is_hubei" id="optionsRadios1" value="1" @if($info->is_hubei==1) checked @endif> 是
		    </label>
		    <label>
		        <input type="radio" name="is_hubei" id="optionsRadios2" value="2" @if($info->is_hubei==2) checked @endif>否
		     </label>  
		</div>    
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">头像</label>
		<div class="col-sm-10">
			<input type="file" class="form-control" id="lastname" name="head" value="{{$info->head}}" 
				   placeholder="请输入年龄">
				   <img src="{{env('UPLOAD_URL')}}{{$info->head}}" width="150px" height="100px">
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button type="submit" class="btn btn-default">编辑</button>
		</div>
	</div>
</form>

</body>
</html>