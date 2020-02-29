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
<center><h3>外来人口列表</h3></center>
<table class="table table-striped">
	
	<thead>
		<tr>
			<th>ID</th>
			<th>品牌名称</th>
			<th>品牌Log</th>
			<th>品牌网址</th>
			<th>品牌描述</th>
			<th>操作</th>
		</tr>
	</thead>
	<tbody>
		@foreach($data as $k=>$v)
		<tr>
			<td>{{$v->b_id}}</td>
			<td>{{$v->b_name}}</td>
			<td><img src="{{env('UPLOAD_URL')}}{{$v->b_log}}" width="50px" height="50px"></td>
			<td>{{$v->b_url}}</td>
			<td>{{$v->b_desc}}</td>
			<td>
				<a href="{{url('/brand/edit/'.$v->b_id)}}" class="btn btn-info">编辑</a>
				<a href="{{url('/brand/destroy/'.$v->b_id)}}" class="btn btn-danger">删除</a>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>

</body>
</html>