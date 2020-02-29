<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use Illuminate\Validation\Rule;
class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $type=request()->type;
        $atitle=request()->atitle;
        // echo $type;
        // echo $atitle;
        $where=[];
        if($type){
            $where[]=['type','=',$type];
        }
        if($atitle){
            $where[]=['atitle','like',"%$atitle%"];
        }
        $data=Article::where($where)->paginate(2);
        // dd($data);
        return view('article.index',['data'=>$data,'type'=>$type,'atitle'=>$atitle]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('article.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $request->validate([ 
            'atitle' => 'required|unique:article|regex:/^[\x{4e00}-\x{9fa5}A-Za-z0-9_-]+$/u',
            'type' => 'required',
            'vital' => 'required',
            'is_no' => 'required',
        ],[
            'atitle.required'=>'文章标题不能为空',
            'atitle.unique'=>'文章标题已存在',
            'atitle.regex'=>'文章标题是中文、字母、数字、下划线',
            'type.required'=>'分类不能为空',
            'vital.required'=>'文章重要性不能为空',
            'is_no.required'=>'是否显示不能为空',
        ]);
        //接收值
        $data=$request->except('_token');
        $data['time']=time();
        // dd($data);
        if ($request->hasFile('img')) { 
            $data['img']=$this->upload('img');
        }
        $res=Article::insert($data);
        if($res){
            return redirect('/article');
        }
    }
    /**
     * ajax验证唯一性
     */
    public function checkOnly(){
        $atitle=request()->atitle;
        // echo $atitle;
        $where=[];
        if($atitle){
            $where[]=['atitle','=',$atitle];
        }
        $a_id=request()->a_id;
        // echo $atitle;
        if($a_id){
            $where[]=['a_id','!=',$a_id];
        }
        $count=Article::where($where)->count();
        echo json_encode(['code'=>'00000','msg'=>'ok','count'=>$count]);
    }
    /**
     * 文件上传
     */
    public function upload($filename){
        if (request()->file($filename)->isValid()){
            $photo=request()->file($filename);
            $store_result = $photo->store('uploads');
            return $store_result;
        }
        exit('文件上传过程中有错误');
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
        $data=Article::find($id);
        // dd($data);
        return view('article.edit',['data'=>$data]);
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
        $request->validate([
        'atitle'=>[
                'required',
               'regex:/^[\x{4e00}-\x{9fa5}A-Za-z0-9_-]{2,12}$/u',
                Rule::unique('article')->ignore($id,'a_id'),
            ],
            'type' => 'required',
            'vital'=>'required',
            'is_no'=>'required',
        ],[
            'atitle.required'=>'文章标题不能为空',
            'atitle.unique'=>'文章标题已存在',
            'atitle.regex'=>'文章标题是中文、字母、数字、下划线',
            'type.required'=>'分类不能为空',
            'vital.required'=>'文章重要性不能为空',
            'is_no.required'=>'是否显示不能为空',
        ]);
        // echo $id;
        $data=$request->except('_token');
        // dd($data);
        if ($request->hasFile('img')) { 
            $data['img']=$this->upload('img');
        }
        $res=Article::where('a_id',$id)->update($data);
        if($res!==false){
            return redirect('/article');
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
        $res=Article::destroy($id);
        if($res){
            echo json_encode(['code'=>'00000','msg'=>'ok']);
        }
    }
}
