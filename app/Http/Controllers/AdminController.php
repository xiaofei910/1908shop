<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Admin::get();
        return view('admin.index',['data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data=$request->except('_token','pwd');
        // dd($data);
        $data['time']=time();
        // 密码加密
        $data['password']=encrypt($data['password']);
        //头像
        if ($request->hasFile('img')) { 
            $data['img']=upload('img');
        }
        $res=Admin::create($data);
        if($res){
            return redirect('/admin');
        }
    }
    /**
     * ajax验证唯一性
     */
    public function checkOnly(){
        $username=request()->username;
        // echo $atitle;
        $where=[];
        if($username){
            $where[]=['username','=',$username];
        }
        $admin_id=request()->admin_id;
        // echo $atitle;
        if($admin_id){
            $where[]=['admin_id','!=',$admin_id];
        }
        $count=Admin::where($where)->count();
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
        $data=Admin::find($id);
        $data['password']=decrypt($data['password']);
        return view('admin.edit',['data'=>$data]);
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
        $data=$request->except('_token','pwd');
        // dd($data);
        // 密码加密
        $data['password']=encrypt($data['password']);
        //头像
        if ($request->hasFile('img')) { 
            $data['img']=upload('img');
        }
        $res=Admin::where('admin_id',$id)->update($data);
        if($res!==false){
            return redirect('/admin');
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
        $res=Admin::destroy($id);
        if($res){
            echo json_encode(['code'=>'00000','msg'=>'ok']);
        }
    }
}
