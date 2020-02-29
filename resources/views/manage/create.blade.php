<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<center>
		<h3>添加管理</h3>
	<form action="{{url('/manage/store')}}" method="post">
		@csrf
		用户名:<input type="text" name="user_name"><br>
		密码:<input type="password" name="pwd"><br>
		<input type="radio" name="manage" value="1">主管
		<input type="radio" name="manage" value="2" checked>库管员<br>
		<input type="submit" value="添加">
	</form>
</center>
</body>
</html>