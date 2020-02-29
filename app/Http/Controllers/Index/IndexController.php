<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Goods;
use App\Category;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;

class IndexController extends Controller
{
	//cookie的使用
	public function setCookie(){
		return response('测试cookie')->cookie('name', '学院君',2);
	}
    public function index(){
    	// echo request()->cookie('name');
    	// $value=Cookie::get('name');
    	// echo $value;
      //查询商品表中的数据
      $goodsInfo=Goods::get();
      $cateInfo=Category::where('pid','=','0')->get();
      // dd($goodsInfo);
      // dd($cateInfo);
    	return view('index.index',['goodsInfo'=>$goodsInfo,'cateInfo'=>$cateInfo]);
    }
}
