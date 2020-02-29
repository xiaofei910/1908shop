<?php
namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;
use App\Goods;
use App\Category;
// use Illuminate\Support\Facades\Cache;
class ProlistController extends Controller
{
    //列表
    public function index($id){
        // echo $id;
        // $goodsInfo=Cache::get('goodsInfo_'.$id);
        $goodsInfo=cache('goodsInfo_'.$id);
        
        // dd($goodsInfo);
        if(!$goodsInfo){
            // echo "走的DB";
            $cateInfo=Category::get();
            $cate_id=getCateId($cateInfo,$id);
            // dd($cate_id);
            
            $goodsInfo=Goods::whereIn('cate_id',$cate_id)->get();
            // dd($goodsInfo);
            // Cache::put('goodsInfo_'.$id,$goodsInfo,60*60*24*30);
            cache(['goodsInfo_'.$id=>$goodsInfo],60*60*24*30);
            
        }
    	
    	
    	return view('index.prolist',['goodsInfo'=>$goodsInfo]);
    }
    //详情
    public function proinfo($id){
        $num=Redis::setnx('num'.$id,1);
        if(!$num){
            $num=Redis::incr('num'.$id);
        }
       
        // dd($num);
    	// echo $id;
       // $goodsinfo=cache('goodsinfo'.$id);
       $goodsinfo=Redis::get('goodsinfo_'.$id);
       if(!$goodsinfo){
            $goodsinfo=Goods::find($id);

            // dd($goodsInfo);
            // cache(['goodsInfo'.$id=>$goodsinfo],60*60*24*30);
            $goodsinfo=serialize($goodsinfo);
            Redis::setex('goodsInfo'.$id,60,$goodsinfo);
       }   
        // var_dump($goodsInfo);
    	//相册 
        $goodsinfo=unserialize($goodsinfo);
        $goodsinfo['goods_imgs']=explode('|',$goodsinfo['goods_imgs']);
        
        
        // var_dump($goodsInfo);
    	return view('index.proinfo',['goodsInfo'=>$goodsinfo,'num'=>$num]);
    }
}
