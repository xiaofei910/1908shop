<form>
	文章标题：<input type="text" name="atitle" value="{{$query['atitle']??''}}">
	<input type="submit" value="搜索">
</form>
<table border="1px">
	<thead>
	<tr>
		<td>编号</td>
		<td>文章标题</td>
		<td>文章分类</td>
		<td>文章重要性</td>
		<td>是否显示</td>
		<td>添加日期</td>
		<td>操作</td>
	</tr>
	</thead>
	<tbody>
	@foreach($data as $k=>$v)
	<tr>
		<td>{{$v->a_id}}</td>
		<td>{{$v->atitle}}</td>
		<td>{{$v->type}}</td>
		<td>{{$v->vital==1?'普通':'置顶'}}</td>
		<td>{{$v->is_no==1?'√':'×'}}</td>
		<td>{{date('Y-m-d H:i:s',$v->time)}}</td>
		<td><a href="javascript:void(0)" onclick="del('{{$v->a_id}}')">删除</a>|
			<a href="{{url('/article/edit/'.$v->a_id)}}">修改</a></td>
	</tr>
	@endforeach
	<tr>
	<td colspan="7">{{$data->appends($query)->links()}}</td>
	</tr>
	</tbody>
</table>

<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript">
	//ajax分页
	$(document).on('click','.pagination a',function(){
		var url=$(this).attr('href');
		if(!url){
			return;
		}
		$.get(url,function(result){
			// alert(result);
			$('tbody').html(result);
		});
		return false;
	});

	function del(id){
		if(!id){
			return;
		}
		if(confirm('是否要删除此条信息')){
			//ajax删除
			$.get('/article/destroy/'+id,function(result){
				if(result.code=='00000'){
					location.reload();
				}
			},
			'json',
			)
		}
	}
</script>