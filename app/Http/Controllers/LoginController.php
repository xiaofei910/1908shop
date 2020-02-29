<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Manage;
class LoginController extends Controller
{
    public function logindo(Request $request){
    	$user=$request->except('_token');
    	$where=[
            ['user_name','=',$user['user_name']],
            ['pwd','=',md5(md5($user['pwd']))]
        ];
    	// dd($user);
         
    	$admin=Manage::where($where)->first();
    	// dd($admin);
    	if($admin){
    		//把用户的值存入session
    		session(['adminuser'=>$admin]);
    		//用save保存
    		$request->session()->save();
    		return redirect('/manage');
    	}
    	return redirect('/admin/login')->with('msg','没有此用户');
    }
}
