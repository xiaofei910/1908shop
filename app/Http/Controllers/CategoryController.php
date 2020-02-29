<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Category::get();
        $info=getCateInfo($data);
        // dd($data);
        return view('category.index',['info'=>$info]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $cateInfo=Category::get();
        // dd($cateInfo);
        $info=getCateInfo($cateInfo);
        // dd($info);
        return view('category.create',['info'=>$info]);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'cate_name' => 'required|unique:category|regex:/^[\x{4e00}-\x{9fa5}A-Za-z0-9_-]{2,12}$/u', 
        // ],[
        //     'cate_name.required'=>'分类名称不能为空',
        //     'cate_name.unique'=>'分类名称已存在',
        //     'cate_name.regex'=>'分类名称由2-12位中文、数字、字母、下划线组成',
        // ]);
        $data=$request->except('_token');
        // dd($data);
        $res=Category::create($data);
        if($res){
            return redirect('/category');
        }
        
    }
    /**
     * 唯一性验证
     */
    public function checkOnly(){
        $cate_name=request()->cate_name;
        // dd($cate_name);
        $where=[];
        if($cate_name){
            $where[]=['cate_name','=',$cate_name];
        }
        $cate_id=request()->cate_id;
        // echo $atitle;
        if($cate_id){
            $where[]=['cate_id','!=',$cate_id];
        }
        $count=Category::where($where)->count();
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
        // echo $id;
        $cateInfo=Category::select('*')->get();
        // dd($cateInfo);
        $info=getCateInfo($cateInfo);
        // dd($info);
        $data=Category::where('cate_id',$id)->first();
        // dd($data);
        return view('category.edit',['data'=>$data,'info'=>$info]);
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
        $data=$request->except('_token');
        // dd($data);
        $res=Category::where('cate_id',$id)->update($data);
        if($res!==false){
            return redirect('/category');
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
        // echo $id;
        //判断父类底下是否有子类，没有就执行删除，有就不能删除
       
        $count=Category::where('pid',$id)->count();
        if($count>0){
            exit('此分类下有子类，不能删除');
        }
        //判断分类下是否有商品，没有就执行删除，有就不能删除
        $res=Category::destroy($id);
        if($res){
            echo json_encode(['code'=>'00000','msg'=>'ok']);
        }
    }
}
