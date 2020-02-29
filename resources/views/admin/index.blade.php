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
<center><h3>管理员列表</h3></center>
<table class="table table-striped">
	
	<thead>
		<tr>
			<th>ID</th>
			<th>账号</th>
			<th>手机号</th>
			<th>邮箱</th>
			<th>头像</th>
			<th>添加时间</th>
			<th>操作</th>
		</tr>
	</thead>
	<tbody>
		@foreach($data as $k=>$v)
		<tr>
			<td>{{$v->admin_id}}</td>
			<td>{{$v->username}}</td>
			<td>{{$v->tel}}</td>
			<td>{{$v->email}}</td>
			<td>@if($v->img)<img src="{{env('UPLOAD_URL')}}{{$v->img}}" width="50px" height="50px">@endif {{$v->img}}</td>
			<td>{{date('Y-m-d H:i:s',$v->time)}}</td>
			<td>
				<a href="{{url('/admin/edit/'.$v->admin_id)}}" class="btn btn-info">编辑</a>
				<a href="javascript:void(0)" onclick="del('{{$v->admin_id}}')" class="btn btn-danger">删除</a>
			</td>
		</tr>
		@endforeach
		
	</tbody>
</table>

</body>
<script type="text/javascript">
	function del(id){
		if(!id){
			return;
		}
		if(confirm('是否要删除此条信息')){
			//ajax删除
			$.get('/admin/destroy/'+id,function(result){
				if(result.code=='00000'){
					location.reload();
				}
			},
			'json',
			)
		}
	}
</script>
</html>