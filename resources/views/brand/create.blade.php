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
<center><h3>添加品牌</h3></center>
<form class="form-horizontal" role="form" action="{{url('/brand/store')}}" method="post" enctype="multipart/form-data">
	@csrf
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">品牌名称</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="firstname" name="b_name"
				   placeholder="请输入品牌名称">
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">品牌Log</label>
		<div class="col-sm-10">
			<input type="file" name="b_log">
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">品牌网址</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="lastname" name="b_url"
				   placeholder="请输入品牌网址">
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">品牌描述</label>
		<div class="col-sm-10">
			<textarea name="b_desc"></textarea>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button type="submit" class="btn btn-default">添加</button>
		</div>
	</div>
</form>

</body>
</html>