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
<center><h3>分类列表</h3></center>
<table class="table table-striped">
	
	<thead>
		<tr>
			<th>ID</th>
			<th>分类名称</th>
			<th>分类描述</th>
			<th>父类id</th>
			<th>操作</th>
		</tr>
	</thead>
	<tbody>
		@foreach($info as $k=>$v)
		<tr>
			<td>{{$v->cate_id}}</td>
			<td>{{str_repeat('----|',$v->level)}}{{$v->cate_name}}</td>
			<td>{{$v->cate_desc}}</td>
			<td>{{$v->pid}}</td>
			<td>
				<a href="{{url('/category/edit/'.$v->cate_id)}}" class="btn btn-info">编辑</a>
				<a href="javascript:void(0)" onclick="del('{{$v->cate_id}}')" class="btn btn-danger">删除</a>
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
			//ajax删除
			$.get('/category/destroy/'+id,function(result){
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