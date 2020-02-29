<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8"> 
	<title>Bootstrap 实例 - 水平表单</title>
	<meta name="csrf-token" content="{{csrf_token()}}">
	<link rel="stylesheet" href="/static/css/bootstrap.min.css">  
	<script src="/static/js/jquery.min.js"></script>
	<script src="/static/js/bootstrap.min.js"></script>

</head>
<body>
<center><h3>编辑分类</h3></center>
<form class="form-horizontal" role="form" action="{{url('/category/update/'.$data->cate_id)}}" method="post" enctype="multipart/form-data">
	@csrf
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">分类名称</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="firstname" name="cate_name"
				   value="{{$data->cate_name}}">
				   <b style="color:red"></b>
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">父级分类</label>
		<div class="col-sm-10">
			<select name="pid">
				<option value="0">顶级分类</option>
				@foreach($info as $k=>$v)
				<option value="{{$v->cate_id}}" {{$v->cate_id==$data->pid?'selected':''}}>{{str_repeat('---',$v->level)}}{{$v->cate_name}}</option>
				@endforeach
			</select>
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">分类描述</label>
		<div class="col-sm-10">
			<textarea name="cate_desc">{{$data->cate_desc}}</textarea>
		</div>
	</div>
<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button type="button" id="but" class="btn btn-default">编辑</button>
		</div>
	</div>
</form>

</body>
<script type="text/javascript">
	$.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
	var cate_id="{{$data->cate_id}}";
	//阻止表单提交
	$('#but').click(function(){
		var flag=true;
		$('#firstname').next().html('');
		// alert(123);
		// 标题验证
		var cate_name=$('#firstname').val();
		var reg=/^[\u4e00-\u9fa50-9a-zA-Z_]+$/;
		if(!reg.test(cate_name)){
			$('#firstname').next().html('分类名称由2-12位中文、字母、数字、下滑线组成且不能为空');
			return;
		}
		//验证唯一性
		$.ajax({
			type:'post',
			url:"/category/checkOnly",
			data:{cate_name:cate_name,cate_id:cate_id},
			async:false,
			dataType:'json',
			success:function(result){
				// console.log(result);
				if(result.count>0){
					$("#firstname").next().html('商品名称已存在');
					flag=false;
				}
			}
		});
		// alert(atitleflag);
		if(!flag){
			return;
		}
		//form提交
		$('form').submit();
	});
	$("#firstname").blur(function(){
		$(this).next().html('');
		var cate_name=$(this).val();
		// console.log(cate_name);
		var reg=/^[\u4e00-\u9fa50-9a-zA-Z_]{2,12}$/;
		// alert(reg.test(cate_name));
		if(!reg.test(cate_name)){
			$(this).next().html('分类名称由2-12位中文、数字、字母、下划线组成，且不能为空');
			return;
		}
		// alert(cate_id);
		//唯一性验证
		$.ajax({
			type:'post',
			url:"/category/checkOnly",
			data:{cate_name:cate_name,cate_id:cate_id},
			dataType:'json',
			success:function(res){
				if(res.count>0){
					$("#firstname").next().html('分类名称已存在');
				}
			}
		})
	})
</script>
</html>