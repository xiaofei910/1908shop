<?php

/**
 * 公用的方法  返回json数据，进行信息的提示
 * @param $status 状态
 * @param string $message 提示信息
 * @param array $data 返回数据
 */
function showMsg($status,$message = '',$data = array()){
    $result = array(
        'status' => $status,
        'message' =>$message,
        'data' =>$data
    );
    exit(json_encode($result));
}
/**
     * 无限极分类
     */
    //$level等级，在视图页面根据等级决定输出多少个空格
   function getCateInfo($cateInfo,$pid=0,$level=1){
        if(!$cateInfo){
            return;
        }
        //将数据存到一个静态数组中，在函数执行完后，变量值仍保存
        static $info=[];
        foreach($cateInfo as $k=>$v){
            //如果pid等于0取出所有的顶级分类，我们不只是要取出顶级分类，还要取出顶级分类中的子类，需要将等于后面的值写活
            if($v['pid']==$pid){
                // print_r($v);
                $v['level']=$level;
                $info[]=$v;
                //刚刚已经查询到所有顶级的分类，调用自己，再查一遍，传数据，再传刚查到数据的分类id
                getCateInfo($cateInfo,$v['cate_id'],$v['level']+1);
            }
        }
        //将数据返回
        return $info;
    }  
     //文件上传
    function upload($filename){
        //判断文件上传过程有无错误
        if (request()->file($filename)->isValid()){
            //接收值
            $photo= request()->file($filename);
            //上传
            $store_result = $photo->store('uploads');
            return $store_result;
        }
        exit('未获取到上传文件或上传过程出错');
    }
    //多文件上传
    function Moreuploads($filename){
        //接收值
        $photo= request()->file($filename);
        if(!is_array($photo)){
            return;
        }
        // dd($photo);
        foreach($photo as $v){
            //判断文件上传过程有无错误
            if ($v->isValid()){
                //上传
                $store_result[] = $v->store('uploads');
            }
        }
        return $store_result;
    }
    // 自定义函数 把数组转化为字符串
    function fail($font){
         $arr=['code'=>2,'font'=>$font];
         echo json_encode($arr);
         die;
    }
    function successly($font=''){
        $arr=['code'=>1,'font'=>$font];
        echo json_encode($arr);
        die;
    }
    function getCateId($info,$pid){
        static $cate_id=[];
        $cate_id[$pid]=$pid;
        foreach($info as $k=>$v){
            if($v['pid']==$pid){
                // dump($cate_id);
                $cate_id[$v['cate_id']]=$v['cate_id'];
                getCateId($info,$v['cate_id']);
                // print_r($v);
            }
        }
        return $cate_id;
    }
?>