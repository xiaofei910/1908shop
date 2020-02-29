<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brand;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Brand::get();
        return view('brand.index',['data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('brand.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data=$request->except('_token');
        // dd($data);
        if($request->hasFile('b_log')){
            $data['b_log']=$this->upload('b_log');
        }
        $res=Brand::insert($data);
        // dd($res);
        if($res){
            return redirect('/brand');
        }
    }
    /**
     * 文件上传
     */
    public function upload($filename){
        if(request()->file($filename)->isValid()){
            //接收
            $photo = request()->file($filename);
            $store_result = $photo->store('uploads');
            return $store_result;
        }
        exit('未获取到上传文件或上传过程出错');
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
        // $data=Brand::where('b_id',$id)->first();
        $data=Brand::find($id);
        // dd($data);
        return view('brand.edit',['data'=>$data]);
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
        if($request->hasFile('b_log')){
            $data['b_log']=$this->upload('b_log');
        }
        $res=Brand::where('b_id',$id)->update($data);
        // dd($res);
        if($res){
            return redirect('/brand');
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
        $res=Brand::destroy($id);
        if($res){
            return redirect('/brand');
        }
    }
}
