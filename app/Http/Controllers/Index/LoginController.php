<?php

namespace App\Http\Controllers\Index;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Reg;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use App\Mail\SendCode;
use Illuminate\Support\Facades\Mail;
class LoginController extends Controller
{
	public function reg(){
		return view('index.reg');
	}
	//发送邮件
	public function sendEmail(){
		$email='2924948488@qq.com';
		Mail::to($email)->send(new SendCode());
	}
    //注册
    public function regDo(){
    	$data=request()->except('_token');
    	$code=session('code');
    	// dd($code);
    	// 判断验证码
    	if($data['code']!=$code){
    		return redirect('/reg')->with('msg','您输入的验证码有误');
    	}
    	//判断密码
    	if($data['pwd']!=$data['pwd2']){
    		return redirect('/reg')->with('msg','两次密码不一致');
    	}
    	//入库
    	$user=[
    		'tel'=>$data['tel'],
    		'pwd'=>encrypt($data['pwd']),
    		'time'=>time(),
    	];
    	$res=Reg::create($user);
    	if($res){
    		return redirect('/login');
    	}
    }
    public function login(){
    	return view('index.login');
    }
    //登录
   	public function loginDo(){
   		$data=request()->except('_token');
   		$where=[
   			['tel','=',$data['tel']]
   		];
   		$res=Reg::where($where)->first();
   		if($data['pwd']!=decrypt($res['pwd'])){
   			return redirect('/login')->with('msg','没有此用户或者密码错误');
   		}
      session(['userinfo'=>$res]);
      request()->session()->save();
      return redirect('/');
   	}
    //短信发送
    public function ajaxsend(){
    	$tel=request()->tel;
    	// dd($tel);
      $count=Reg::where('tel',$tel)->count(); 
      // dd($count);
      if($count>0){
        fail('该手机号已注册过了！');
      }
    	$code=rand(100000,999999);
    	$res=$this->sendSms($tel,$code);
      	// dd($res);
    	if($res['Code']=='OK'){
    		session(['code'=>$code]);
    		request()->session()->save();
    		successly("发送成功");
    	}else{
    		fail("发送失败");
    	}
    }
    //手机号唯一性
    public function checkOnly(){
      $tel=request()->tel;
      $count=Reg::where('tel',$tel)->count(); 
      // dd($count);
      if($count>0){
        echo json_encode(['code'=>'00000','msg'=>'ok','count'=>$count]);
      }
    }
    public function sendSms($tel,$code){
		AlibabaCloud::accessKeyClient('LTAI4Fov1cYYYt5dWrhgtHQW','LCt5nq6SvcIQIxzdduEjrZaOXEgQ0D')
		                        ->regionId('cn-hangzhou')
		                        ->asDefaultClient();
		try {
		    $result = AlibabaCloud::rpc()
		                          ->product('Dysmsapi')
		                          // ->scheme('https') // https | http
		                          ->version('2017-05-25')
		                          ->action('SendSms')
		                          ->method('POST')
		                          ->host('dysmsapi.aliyuncs.com')
		                          ->options([
		                                        'query' => [
		                                          'RegionId' => "cn-hangzhou",
		                                          'PhoneNumbers' => "$tel",
		                                          'SignName' => "西瓜",
		                                          'TemplateCode' => "SMS_181855675",
		                                          'TemplateParam' => "{code:$code}",
		                                        ],
		                                    ])
		                          ->request();
		    return $result->toArray();
		} catch (ClientException $e) {
		    return $e->getErrorMessage();
		} catch (ServerException $e) {
		    return $e->getErrorMessage();
		}
    }
}
