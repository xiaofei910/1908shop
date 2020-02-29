<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Brand;
use App\Goods;
class GoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //商品分类
        $categoryInfo=Category::get();
        $info=getCateInfo($categoryInfo);
        //品牌
        $brandInfo=Brand::get();
        $pageSize=config('app.pageSize');
        $goodsInfo=Goods::leftjoin('category','goods.cate_id','=','category.cate_id')
                        ->leftjoin('brand','goods.b_id','=','brand.b_id')
                        ->orderby('goods_id','desc')
                        ->paginate($pageSize);
        // dd($goodsInfo);
        //相册 
        foreach($goodsInfo as $k=>$v){
            $goodsInfo[$k]['goods_imgs']=explode('|',$v['goods_imgs']);
        } 
        return view('goods.index',['goodsInfo'=>$goodsInfo,'brandInfo'=>$brandInfo,'info'=>$info]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //商品分类
        $categoryInfo=Category::get();
        $info=getCateInfo($categoryInfo);
        //品牌
        $brandInfo=Brand::get();
        return view('goods.create',['brandInfo'=>$brandInfo,'info'=>$info]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $goodsInfo=$request->except('_token');
        // dd($goodsInfo);
        // 商品货号
        $goodsInfo['goods_code']=$this->CreateGoodsSn();
        //文件上传
        if ($request->hasFile('goods_img')) { 
            $goodsInfo['goods_img']=upload('goods_img');
        }
        //多文件上传
        if (isset($goodsInfo['goods_imgs'])) {
           $photos=Moreuploads('goods_imgs');
           $goodsInfo['goods_imgs']=implode('|',$photos);
        }
        // dd($goodsInfo);
        //第二种方法
        // 接收相册信息
        // $files=$request->file('goods_imgs');
        // // dump($files);die;
        // $goods_imgs="";
        // //$file指的是值
        // foreach($files as $v){
        //     $goods_imgs.= $v->store('goods_imgs').'|';
        // }
        // //去除右边的|
        // $goods_imgs=rtrim($goods_imgs,'|');
        // // dump($goods_imgs);
        // $goodsInfo['goods_imgs']=$goods_imgs;
        
        $res=Goods::insert($goodsInfo);

        // dd($res);
        if($res){
            return redirect('/goods');
        }
    }
    //产生货号
    public function CreateGoodsSn(){
        return 'shop'.date('YmdHis').rand(1000,9999);
    }
    /**
     * ajax验证唯一性
     */
    public function checkOnly(){
        $goods_name=request()->goods_name;
        // echo $atitle;
        $where=[];
        if($goods_name){
            $where[]=['goods_name','=',$goods_name];
        }
        $goods_id=request()->goods_id;
        // echo $atitle;
        if($goods_id){
            $where[]=['goods_id','!=',$goods_id];
        }
        $count=Goods::where($where)->count();
        echo json_encode(['code'=>'00000','msg'=>'ok','count'=>$count]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //商品分类
        $categoryInfo=Category::get();
        $info=getCateInfo($categoryInfo);
        //品牌
        $brandInfo=Brand::get();
        $goodsInfo=Goods::find($id);
        return view('goods.edit',['goodsInfo'=>$goodsInfo,'brandInfo'=>$brandInfo,'info'=>$info]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // echo $id;
        $goodsInfo=$request->except('_token');
        // dd($goodsInfo);
        
        //文件上传
        if ($request->hasFile('goods_img')) { 
            $goodsInfo['goods_img']=upload('goods_img');
        }
        // 接收相册信息
        $files=$request->file('goods_imgs');
        //多文件上传
        if (isset($goodsInfo['goods_imgs'])) {
           $photos=Moreuploads('goods_imgs');
           $goodsInfo['goods_imgs']=implode('|',$photos);
        }
        // if($files){
             
        //     // dump($files);die;
        //     $goods_imgs="";
        //     //$file指的是值
        //     foreach($files as $v){
        //         $goods_imgs.= $v->store('goods_imgs').'|';
        //     }
        //     //去除右边的|
        //     $goods_imgs=rtrim($goods_imgs,'|');
        //     // dump($goods_imgs);
        //     $goodsInfo['goods_imgs']=$goods_imgs;
        // }
       
        
        $res=Goods::where('goods_id',$id)->update($goodsInfo);

        // dd($res);
        if($res!==false){
            return redirect('/goods');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res=Goods::destroy($id);
        if($res){
            echo json_encode(['code'=>'00000','msg'=>'ok']);
        }
    }
}
