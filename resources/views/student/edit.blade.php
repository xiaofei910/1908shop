<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<h3>编辑页面</h3>
	<form action="{{url('/student/update/'.$info->sid)}}" method="post" enctype="multipart/form-data">
		@csrf
		学生姓名：<input type="text" name="sname" value="{{$info->sname}}">
				<font style="color:red">{{$errors->first('sname')}}</font><br>
		性别：<input type="radio" name="sex" value="1" @if($info->sex==1) checked @endif>男
		<input type="radio" name="sex" value="2" @if($info->sex==2) checked @endif>女
		<font style="color:red">{{$errors->first('sex')}}</font><br>
		班级：<input type="text" name="class" value="{{$info->class}}"><br>
		成绩：<input type="text" name="grade" value="{{$info->grade}}">
		<font style="color:red">{{$errors->first('grade')}}</font><br>

		头像：<input type="file" name="head" value="{{$info->head}}"><br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="{{env('UPLOAD_URL')}}{{$info->head}}" width="100px" height="100px"><br>
		<input type="submit" value="编辑"><br>
	</form>
</body>
</html>