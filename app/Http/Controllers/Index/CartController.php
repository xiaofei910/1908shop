<?php

namespace App\Http\Controllers\Index;

use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Cart;
use App\Goods;
class CartController extends Controller
{
	//加入购物车
    public function createCart(Request $request){
    	$buy_number=$request->buy_number;
    	$goods_id=$request->goods_id;
    	// echo $buy_number;die;
    	// echo $goods_id;
    	$userinfo=session('userinfo');
    	// echo $userinfo;die;
        $goods_num=Goods::where('goods_id',$goods_id)->value('goods_num');
        // dd($goods_num);
    	//判断用户是否登录
    	if(!$userinfo){
    		// echo "未登录";
            // 存入cookie
            $cartInfo=cookie('cartInfo');
            if($cartInfo){
               $cartInfo=[]; 
            }
            if(array_key_exists($goods_id,$cartInfo)){
                 // 检测库存
                if(($buy_number+$cartInfo[$goods_id]['buy_number'])>$goods_num){
                    //将库存的值赋给购买数量
                    $buy_number=$goods_num;
                }else{
                    // 把购买数量累加，加入时间改为当前时间
                    $buy_number=$cartInfo[$goods_id]['buy_number']+$buy_number;
                }
                $cartInfo[$goods_id]['buy_number']=$buy_number;
                $cartInfo[$goods_id]['add_time']=time();
            }else{
                //检测库存
                if($buy_number>$goods_num){
                    $buy_number=$goods_num;
                }
                // dd($buy_number);
                //将商品id、加入购物车时间、购买数量  加入cookie
                $cartInfo[$goods_id]=['buy_number'=>$buy_number,'goods_id'=>$goods_id,'add_time'=>time()];
                // dd($cartInfo);
            }
            // response('')->cookie('cartInfo',$cartInfo,1000);
            // cookie('cartInfo',$cartInfo);
            // echo "ok";

    	}else{
    		// echo "已登录";
            $user_id=session('userinfo.user_id'); 
            //判断 数据库中此用户是否把此商品加入过购物车
            $where=[
                ['goods_id','=',$goods_id],
                ['user_id','=',$user_id],
                ['cdel','=',1]
            ];
            $cartinfo=Cart::where($where)->first();
            // dd($cartinfo);
            if(!empty($cartinfo)){
                // 检测库存
                if($buy_number+$cartinfo['buy_number']>$goods_num){
                    //将库存的值赋给购买数量
                    $buy_number=$goods_num;
                }else{
                    // 把购买数量累加，加入时间改为当前时间
                    $buy_number=$cartinfo['buy_number']+$buy_number;
                }
                    $info=['buy_number'=>$buy_number,'add_time'=>time()];
                    $res=Cart::where($where)->update($info);
            }else{
                // 否则
                // 检测库存
                if($buy_number>$goods_num){
                    $buy_number=$goods_num;
                }
                // 将数据存入数据库
                $data=['buy_number'=>$buy_number,'goods_id'=>$goods_id,'add_time'=>time(),'user_id'=>$user_id];
                $res=Cart::create($data);
            }
    		if($res){
    			echo "ok";
    		}else{
    			echo "no";
    		}
    	}
    }
    //购物车展示
    public function cartList(){
    	//判断用户是否登录
    	$userinfo=session('userinfo');
    	if(!$userinfo){
            // $cartInfo=Cookie::get('cartInfo');
            $cartInfo=request()->cookie('cartInfo');
            dd($cartInfo);
    	}else{
    		//登录
    		//展示数据库中的值
    		$info=Cart::select('goods.goods_id','goods_img','goods_name','goods_price','goods_num','buy_number','add_time')
    			 ->leftJoin('goods','goods.goods_id','=','cart.goods_id')
    		     ->orderby('add_time','desc')
		         ->get();

    	}
    	// dd($info);
    	//根据goods_id展示数据
    	return view('index.cart',['info'=>$info]);
    }
}
