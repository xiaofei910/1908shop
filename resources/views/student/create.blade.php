<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<h3>添加页面</h3>
	<form action="{{url('/student/store')}}" method="post" enctype="multipart/form-data">
		@csrf
		学生姓名：<input type="text" name="sname">
				<!-- 显示单个错误信息 -->
			<font style="color:red">{{$errors->first('sname')}}</font><br>
		性别：<input type="radio" name="sex" value="1" checked>男
		<input type="radio" name="sex" value="2">女
		<font style="color:red">{{$errors->first('sex')}}</font><br>
		班级：<input type="text" name="class"><br>
		成绩：<input type="text" name="grade">
		<font style="color:red">{{$errors->first('grade')}}</font><br>
		头像：<input type="file" name="head"><br>
		<input type="submit" value="添加"><br>
	</form>
</body>
</html>