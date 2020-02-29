<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
    	echo "hello word";
    }
    public function add(){
    	// echo "添加用户";
    	return view('user.add');
    }
    public function adddo(Request $request){
    	// echo '123';
    	$data=$request->all();
    	dd($data);
    }
    
}
