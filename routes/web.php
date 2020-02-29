<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//闭包路由
Route::get('/', function () {
	// echo 123;
	$name='1908欢迎您';
    return view('welcome',['name'=>$name]);
});
// Route::get('/show', function () {
// 	echo "hello";
// });
Route::get('/user','UserController@index');
Route::get('/adduser','UserController@add');
Route::post('/adddo','UserController@adddo');


//作业练习
// Route::get('/show', function () {
// 	echo "这里是商品详情页";
// });
//必须参数
// Route::get('/show/{id}/{name}', function ($id,$name) { 
// 	echo "商品id是：".$id."<br>"; 
// 	echo "关键字是：".$name;
// });
//可选参数
// Route::get('/show/{id?}', function ($id=null) { 
// 	echo "商品id是：".$id;
// });
//显示品牌添加页面
Route::get('/brand/create','BrandController@create');
Route::post('/brand/store','BrandController@store');
Route::get('/brand','BrandController@index');
Route::get('/brand/destroy/{id}','BrandController@destroy');
Route::get('/brand/edit/{id}','BrandController@edit');
Route::post('/brand/update/{id}','BrandController@update');
Route::view('/brands','brand.add');
//显示添加分类界面
// Route::get('/category', function () {
// 	$fid='服装';
//     return view('category.add',['fid'=>$fid]);
// });
// Route::get('/category/add','CategoryController@index');
// Route::post('/add','CategoryController@adddo')->name('do');


//2.12练习
// Route::get('/goods/{id}', function ($id) { 
// 	echo "商品id是：".$id."<br>"; 
// });
// Route::get('/show/{id}', function ($id) { 
// 	echo "ID：".$id;
// });
// Route::get('/show/{id}/{name}', function ($id,$name) { 
// 	echo "商品id是：".$id."<br>"; 
// 	echo "关键字是：".$name;
// })->where(['name'=>'[a-zA-z]+']);

//外来人员登记
Route::prefix('people')->group(function () {
Route::get('create','PeopleController@create');
Route::post('store','PeopleController@store');
Route::get('/','PeopleController@index');
Route::get('edit/{id}','PeopleController@edit');
Route::post('update/{id}','PeopleController@update');
Route::get('destroy/{id}','PeopleController@destroy');
});

//学生成绩登记
Route::prefix('student')->group(function(){
	Route::get('/create','StudentController@create');
	Route::post('/store','StudentController@store');
	Route::get('/','StudentController@index');
	Route::get('/edit/{id}','StudentController@edit');
	Route::get('/destroy/{id}','StudentController@destroy');
	Route::post('/update/{id}','StudentController@update');
});


//周测   文章
Route::prefix('article')->group(function(){
	Route::get('/create','ArticleController@create');
	Route::post('/store','ArticleController@store');
	Route::post('/checkOnly','ArticleController@checkOnly');
	Route::get('/','ArticleController@index');
	Route::get('/destroy/{id}','ArticleController@destroy');
	Route::get('/edit/{id}','ArticleController@edit');
	Route::post('/update/{id}','ArticleController@update');
});
//周测  物流管理
Route::prefix('manage')->middleware('checklogin')->group(function(){
	Route::get('/create','ManageController@create');
	Route::post('/store','ManageController@store');
	Route::get('/','ManageController@list');
	// Route::view('/','manage.list');
	Route::get('/index','ManageController@index');
	Route::get('/destroy/{id}','ManageController@destroy');

});
//测试
Route::get('/test/index','TestController@index');



Route::view('/logins','login');
Route::post('/admin/logindo','LoginController@logindo');
//分类
Route::prefix('category')->group(function(){
	Route::get('/create','CategoryController@create');
	Route::post('/store','CategoryController@store');
	Route::post('/checkOnly','CategoryController@checkOnly');
	Route::get('/','CategoryController@index');
	Route::get('/destroy/{id}','CategoryController@destroy');
	Route::get('/edit/{id}','CategoryController@edit');
	Route::post('/update/{id}','CategoryController@update');
});
//商品
Route::prefix('goods')->group(function(){
	Route::get('/create','GoodsController@create');
	Route::post('/store','GoodsController@store');
	Route::post('/checkOnly','GoodsController@checkOnly');
	Route::get('/','GoodsController@index');
	Route::get('/destroy/{id}','GoodsController@destroy');
	Route::get('/edit/{id}','GoodsController@edit');
	Route::post('/update/{id}','GoodsController@update');
});
//管理员
Route::prefix('admin')->group(function(){
	Route::get('/create','AdminController@create');
	Route::post('/store','AdminController@store');
	Route::post('/checkOnly','AdminController@checkOnly');
	Route::get('/','AdminController@index');
	Route::get('/destroy/{id}','AdminController@destroy');
	Route::get('/edit/{id}','AdminController@edit');
	Route::post('/update/{id}','AdminController@update');
});
//前台
Route::get('/','Index\IndexController@index');
//测试cookie
Route::get('/setcookie','Index\IndexController@setCookie');
//列表
Route::get('/prolist/{id}','Index\ProlistController@index');
//详情
Route::get('/proinfo/{id}','Index\ProlistController@proinfo');
//购物车
Route::post('/cart/create','Index\CartController@createCart');
Route::get('/cart/index','Index\CartController@cartList');
//登录
Route::get('/login','Index\LoginController@login');
Route::post('/login/logindo','Index\LoginController@loginDo');
//注册
Route::get('/reg','Index\LoginController@reg');
Route::post('/reg/regdo','Index\LoginController@regDo');
Route::post('/reg/checkOnly','Index\LoginController@checkOnly');
//短信
Route::get('/send','Index\LoginController@ajaxsend');
//发送邮件
Route::get('/sendemail','Index\LoginController@sendEmail');
