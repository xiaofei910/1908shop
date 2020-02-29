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
<center><h3>用户管理</h3></center>
<table class="table table-striped">
	
	<thead>
		<tr>
			<th>用户ID</th>
			<th>用户昵称</th>
			<th>用户身份</th>
		</tr>
	</thead>
	<tbody>
		@foreach($user as $k=>$v)
		<tr>
			<td>{{$v->user_id}}</td>
			<td>{{$v->user_name}}</td>
			<td>{{$v->manage==1?'主管':'库管员'}}</td>
			<td>
				<a href="{{url('/manage/create')}}" class="btn btn-info">添加</a>
				<a href="javascript:void(0)" onclick="del('{{$v->user_id}}')" class="btn btn-danger">删除</a>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>

</body>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript">
	function del(id){
		if(!id){
			return;
		}
		if(confirm('是否要删除此条信息')){
			// alert(id);
			//ajax删除
			$.get('/manage/destroy/'+id,function(result){
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