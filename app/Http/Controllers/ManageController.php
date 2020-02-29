<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Manage;
class ManageController extends Controller
{
	public function list(){
		$user=session('adminuser');
		if($user['manage']==1){
			return view('manage.list');
		}else{
			return view('manage.lists');
		}
	}
    public function index(){
    	$user=Manage::get();
    	return view('manage.index',['user'=>$user]);
    }
    public function destroy($id){
    	// echo $id;
    	$res=Manage::destroy($id);
        if($res){
            echo json_encode(['code'=>'00000','msg'=>'ok']);
        }
    }
    public function create(){
    	return view('manage.create');
    }
    public function store(){
    	$data=request()->except('_token');
    	$data['pwd']=md5(md5($data['pwd']));
    	$res=Manage::create($data);
    	if($res){
    		return redirect('/manage/index');
    	}
    }
}
