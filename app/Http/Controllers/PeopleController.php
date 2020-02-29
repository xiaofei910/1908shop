<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use DB;
use App\People;
use App\Http\Requests\StorePeoplePost;
use Validator;
class PeopleController extends Controller
{
    /**
     * Display a listing of the resource.
     *列表展示
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $username=request()->username??'';

        // echo $username;
        $where=[];
        if($username){
            $where[]=['username','like',"%$username%"];
        }
        //DB
        // $data=DB::table('people')->select('*')->get();
        // ORM操作
        // $data=People::all();
        // $data=People::get();
        $pageSize=config('app.pageSize');
        $data=People::where($where)->orderby('p_id','desc')->paginate($pageSize);
        
        // dd($data);
        return view('people.index',['data'=>$data,'username'=>$username]);
    }

    /**
     * Show the form for creating a new resource.
     *展示添加视图
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('people.create');
    }

    /**
     * Store a newly created resource in storage.
     *执行添加
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    // 第二种验证
    // public function store(StorePeoplePost $request)
    {
        
        //第一种 表单验证
        // $request->validate([ 
        //     'username' => 'required|unique:people|max:12|min:2',
        //     'age' => 'required|integer|between:1,130', 
        // ],[
        //     'username.required'=>'名字不能为空',
        //     'username.unique'=>'名字已存在',
        //     'username.max'=>'名字长度不能超过12为',
        //     'username.min'=>'名字长度不能少于2位',
        //     'age.required'=>'年龄不能为空',
        //     'age.integer'=>'年龄必须为数字',
        //     'age.between'=>'年龄数据不合法',
        // ]);
        $data=$request->except('_token');
        // dd($data);
        //第三种验证
        $validator=Validator::make($data,[
            'username' => 'required|unique:people|max:12|min:2',
            'age' => 'required|integer|between:1,130',
        ],[
            'username.required'=>'名字不能为空',
            'username.unique'=>'名字已存在',
            'username.max'=>'名字长度不能超过12为',
            'username.min'=>'名字长度不能少于2位',
            'age.required'=>'年龄不能为空',
            'age.integer'=>'年龄必须为数字',
            'age.betwwen'=>'年龄数据不合法',
        ]);
        if ($validator->fails()){
            return redirect('people/create')
                ->withErrors($validator)
                ->withInput();
        }
        
        // 文件上传
        if ($request->hasFile('head')) { 
            $data['head']=upload('head');
            // dd($img);
        }
        $data['add_time']=time();
        //DB
        // $res=DB::table('people')->insert($data);
        // ORM操作
        // 方法1   save
        // $people=new People;
        // $people->username=$data['username'];
        // $people->age=$data['age'];
        // $people->card=$data['card'];
        // $people->head=$data['head'];
        // $people->add_time=$data['add_time'];
        // $res=$people->save();
        //方法2 create   黑名单/白名单
        // $res=People::create($data);
        //方法3  insert
        $res=People::insert($data);

        // dd($res);
        if($res){
            return redirect('/people');
        }
    }
   
    /**
     * Display the specified resource.
     *详情页
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *修改
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // echo $id;
        // DB
        // $info=DB::table('people') ->where('p_id',$id) ->first();
        // ORM操作
        $info=People::find($id);
        // $info=People::where('p_id',$id) ->first();
        // dd($info);
        return view('people.edit',['info'=>$info]);
    }

    /**
     * Update the specified resource in storage.
     *执行修改
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        // echo $id;
        $info=$request->except('_token');
        if($request->hasFile('head')){
            $info['head']=upload('head');
        }
        //DB
        // $res=DB::table('people')->where('p_id',$id) ->update($info);
        //ORM操作
        // $people=People::find($id);
        // $people->username=$info['username'];
        // $people->age=$info['age'];
        // $people->card=$info['card'];
        // $people->head=$info['head']??'';
        // $res=$people->save();
        $res=People::where('p_id',$id)->update($info);
        // dd($res);
        if($res!==false){
             return redirect('/people');
        }
    }

    /**
     * Remove the specified resource from storage.
     *删除
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // echo $id;
        
        // DB操作
        // $res=DB::table('people')->where('p_id',$id)->delete();
        //ORM操作
        $res=People::destroy($id);
        if($res){
            return redirect('/people');
        }
    }
}
