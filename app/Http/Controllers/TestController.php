<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Article;
class TestController extends Controller
{
    public function index(){
    	// Cache::flush();
    	// 搜索条件
    	$atitle=request()->atitle;
    	$where=[];
    	if($atitle){
    		$where[]=['atitle','like',"%$atitle%"];
    	}
    	// 接收当前页码
    	$page=request()->page??1;
    	// $data=cache('data_'.$page.'_'.$atitle);
    	
    	$data=Redis::get('data_'.$page.'_'.$atitle);
        // dd($data);
    	if(!$data){
    		// echo "走的DB";
			$pageSize=config('app.pageSize');
    		$data=Article::where($where)->paginate($pageSize);
    		//存入缓存
    		// cache(['data_'.$page.'_'.$atitle=>$data],60*60*24*30);
            $data=serialize($data); 
            Redis::setex('data_'.$page.'_'.$atitle,60,$data); 
    	}
    	$data=unserialize($data);
    	// dd(request()->ajax());
    	// ajax请求，要实现ajax分页
    	if(request()->ajax()){
    		return view('test.ajaxPage',['data'=>$data,'query'=>request()->all()]);
    	}
        
    	// var_dump($data);
    	return view('test.index',['data'=>$data,'query'=>request()->all()]);
    }
}
