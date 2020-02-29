<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<script type="text/javascript" src="/static/js/jquery.min.js"></script>
	<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
	<center>
		<h3>编辑页面</h3>
		<form action="{{url('/article/update/'.$data->a_id)}}" method="post" enctype="multipart/form-data">
			@csrf
			<table>
				<tr>
					<td>文章标题</td>
					<td><input type="text" name="atitle" value="{{$data->atitle}}"><font color="red">{{$errors->first('atitle')}}</font></td>
				</tr>
				<tr>
					<td>文章分类</td>
					<td><input type="text" name="type" value="{{$data->type}}"><font color="red">{{$errors->first('type')}}</font></td>
				</tr>
				<tr>
					<td>文章重要性</td>
					<td>
						<input type="radio" name="vital" value="1" @if($data->vital==1) checked @endif>普通
						<input type="radio" name="vital" value="2" @if($data->vital==2) checked @endif>置顶
						<font color="red">{{$errors->first('vital')}}</font>
					</td>
				</tr>
				<tr>
					<td>是否显示</td>
					<td>
						<input type="radio" name="is_no" value="1" @if($data->is_no==1) checked @endif>显示
						<input type="radio" name="is_no" value="2" @if($data->is_no==2) checked @endif>不显示
						<font color="red">{{$errors->first('is_no')}}</font>
					</td>
				</tr>
				<tr>
					<td>文章作者</td>
					<td><input type="text" name="author" value="{{$data->author}}"><b style="color:red">*</b></td>
				</tr>
				<tr>
					<td>作者email</td>
					<td><input type="text" name="email" value="{{$data->email}}"></td>
				</tr>
				<tr>
					<td>关键字</td>
					<td><input type="text" name="keyword" value="{{$data->keyword}}"></td>
				</tr>
				<tr>
					<td>网页描述</td>
					<td><textarea name="content" cols="30" rows="10">{{$data->author}}</textarea></td>
				</tr>
				<tr>
					<td>上传文件</td>
					<td><input type="file" name="img" value="{{$data->img}}"></td>
				</tr>
				<tr>
					<td></td>
					<td><img src="{{env('UPLOAD_URL')}}{{$data->img}}" width="150px" height="100px"></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" value="编辑">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" value="重置"></td>
				</tr>
			</table>
		</form>
	</center>
</body>
<script type="text/javascript">
	//ajax表单令牌
	$.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
	var a_id ="{{$data->a_id}}";
	//阻止表单提交
	$('input[type="button"]').click(function(){
		var atitleflag=true;
		$('input[name="atitle"]').next().html('');
		// alert(123);
		// 标题验证
		var atitle=$('input[name="atitle"]').val();
		var reg=/^[\u4e00-\u9fa50-9a-zA-Z_]+$/;
		if(!reg.test(atitle)){
			$('input[name="atitle"]').next().html('文章标题由中文、字母、数字、下滑线组成且不能为空');
			return;
		}
		//验证唯一性
		$.ajax({
			type:'post',
			url:"/article/checkOnly",
			data:{atitle:atitle,a_id:a_id},
			async:false,
			dataType:'json',
			success:function(result){
				// console.log(result);
				if(result.count>0){
					$("input[name='atitle']").next().html('标题已存在');
					atitleflag=false;
				}
			}
		});
		// alert(atitleflag);
		if(!atitleflag){
			return;
		}
		//验证作者
		var author=$('input[name="author"]').val();
		var reg=/^[\u4e00-\u9fa50-9a-zA-Z_]{2,12}$/;
		// alert(reg.test(author));
		if(!reg.test(author)){
			$('input[name="author"]').next().html('文章作者由中文、数字、字母、下滑线组成2-12位之间，且不能为空');
			return;
		}
		// alert('ok');
		//form提交
		$('form').submit();
	});
	//验证文章作者
	$('input[name="author"]').blur(function(){
		$(this).next().html('');
		var author=$(this).val();
		// console.log(author);
		var reg=/^[\u4e00-\u9fa50-9a-zA-Z_]{2,12}$/;
		// alert(reg.test(author));
		if(!reg.test(author)){
			$(this).next().html('文章作者由中文、数字、字母、下滑线组成2-12位之间，且不能为空');
			return;
		}
	});
	//验证文章的标题
	$("input[name='atitle']").blur(function(){
		//清空错误信息
		$(this).next().html('');
		var atitle=$(this).val();
		// console.log(atitle);
		var reg=/^[\u4e00-\u9fa50-9a-zA-Z_]+$/;
		// alert(reg.test(atitle));
		if(!reg.test(atitle)){
			$(this).next().html('文章标题由中文、字母、数字、下滑线组成且不能为空');
			return;
		}
		//验证唯一性
		$.ajax({
			type:'post',
			url:"/article/checkOnly",
			data:{atitle:atitle,a_id:a_id},
			dataType:'json',
			success:function(result){
				// console.log(result);
				if(result.count>0){
					$("input[name='atitle']").next().html('标题已存在');
				}
			}
		});
	})

</script>