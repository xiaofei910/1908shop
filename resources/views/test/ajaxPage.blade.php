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