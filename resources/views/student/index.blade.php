<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<style type="text/css">
		ul li{
			list-style:none,
			color:red;
		}
</style>
</head>
<body>
	<form>
	<input type="text" name="sname" value="{{$sname}}" placeholder="请输入名字....">
	<input type="text" name="class" value="{{$class}}" placeholder="请输入班级....">
	<input type="submit" value="搜索">
</form>
<table border="1px">
	<tr>
		<td>ID</td>
		<td>学生姓名</td>
		<td>年龄</td>
		<td>班级</td>
		<td>成绩</td>
		<td>头像</td>
		<td>操作</td>
	</tr>
	@foreach($info as $k=>$v)
	<tr>
		<td>{{$v->sid}}</td>
		<td>{{$v->sname}}</td>
		<td>{{$v->sex==1?'男':'女'}}</td>
		<td>{{$v->class}}</td>
		<td>{{$v->grade}}</td>
		<td><img src="{{env('UPLOAD_URL')}}{{$v->head}}" width="50px" height="50px"></td>
		<td><a href="{{url('/student/destroy/'.$v->sid)}}">删除</a>
			<a href="{{url('/student/edit/'.$v->sid)}}">编辑</a>
		</td>
	</tr>
	@endforeach
</table>
{{$info->appends(['sname'=>$sname,'class'=>$class])->links()}}
</body>
</html>