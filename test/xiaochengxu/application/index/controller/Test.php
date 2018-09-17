<?php 
namespace app\index\controller;
use think\Controller;
use think\Db;

class Test extends Controller
{
 

public function test(){
  	return $this->fetch();
}
public function test2(){
	$post = $_POST;
 
 	 $context = array();
         if (is_array($post)) {
            ksort($post);
            $context['http'] = array (
            'timeout'=>60,
            'method' => 'POST',
            'content' => http_build_query($post, '', '&'),
            );
        }
        $re =  file_get_contents($url, false, stream_context_create($context)); 
        $reArray = json_decode($re, true);
}




    //结尾
}
?>