<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use DB;
class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sname=request()->sname??'';
        $class=request()->class??'';
        // echo $sname;
        // echo $class;
        // echo 123;
        $where=[];
        if($sname){
            $where[]=['sname','like',"%$sname%"];
        }
        if($class){
            $where[]=['class','=',$class];
        }
        $info=DB::table('student')->where($where)->orderby('sid','desc')->paginate(2);
        // dd($info);
        return view('student.index',['info'=>$info,'sname'=>$sname,'class'=>$class]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('student.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //第一种验证
        $request->validate([
            // 'sname' => 'required|unique:student|alpha_dash|min:2|max:12',
            'sname'=>'unique:student|regex:/^[\x{4e00}-\x{9fa5}A-Za-z0-9_-]{2,12}$/u',
            'sex' => 'required|integer',
            'grade'=>'required|integer|between:0,100',
        ],[
            // 'sname.required'=>'名字不能为空',
            'sname.unique'=>'名字已存在',
            // 'sname.alpha_dash'=>'名字必须是中文、数字、字母、下划线2-12位',
            'sname.regex'=>'名字必须是中文、数字、字母、下划线2-12位',
            // 'sname.min'=>'名字最少2位',
            // 'sname.max'=>'名字不能超过12位',
            'sex.required'=>'性别不能为空',
            'sex.integer'=>'性别必须是数字类型',
            'grade.required'=>'成绩不能为空',
            'grade.integer'=>'成绩必须是数字类型',
            'grade.between'=>'成绩不能超过100分',
        ]);
        $data=$request->except('_token');
        // dd($data);
        if($request->hasFile('head')){
            $data['head']=$this->upload('head');
        }
        $res=DB::table('student')->insert($data);
        // dd($res);
        if($res){
            return redirect('/student');
        }
    }
    /**
     *  文件上传
    */
    public function upload($filename){
        //判断文件上传过程有无错误
        if(request()->file($filename)->isValid()){
            //接收值
            $file=request()->file($filename);
            //获取新的路径
            $store_result= $file->store('uploads');
            return $store_result;
        }
        exit('文件上传过程中出现错误');
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
        $info=DB::table('student')->where('sid',$id)->first();
        // dd($info);
        return view('student.edit',['info'=>$info]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //第一种验证
       $request->validate([
            // 'sname' => "required|unique:student,sname,$id,sid|alpha_dash|min:2|max:12",
            'sname'=>[
                'regex:/^[\x{4e00}-\x{9fa5}A-Za-z0-9_-]{2,12}$/u',
                Rule::unique('student')->ignore($id,'sid'),
            ],
            'sex' => 'required|integer',
            'grade'=>'required|integer|between:0,100',
        ],[
            // 'sname.required'=>'名字不能为空',
            'sname.unique'=>'名字已存在',
            'sname.regex'=>'名字必须是中文、数字、字母、下划线',
            // 'sname.alpha_dash'=>'名字必须是中文、数字、字母、下划线',
            // 'sname.min'=>'名字最少2位',
            // 'sname.max'=>'名字不能超过12位',
            'sex.required'=>'性别不能为空',
            'sex.integer'=>'性别必须是数字类型',
            'grade.required'=>'成绩不能为空',
            'grade.integer'=>'成绩必须是数字类型',
            'grade.between'=>'成绩不能超过100分',
        ]);
        // echo $id;
        $data=$request->except('_token');
        // dd($data);
        if($request->hasFile('head')){
            $data['head']=$this->upload('head');
        }
         $res=DB::table('student')->where('sid',$id)->update($data);
         if($res!==false){
            return redirect('/student');
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
        $res=DB::table('student')->where('sid',$id)->delete();
        if($res){
            return redirect('/student');
        }
    }
}
