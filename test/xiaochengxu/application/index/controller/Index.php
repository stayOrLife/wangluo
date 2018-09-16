<?php 
namespace app\index\controller;
use think\Controller;
use app\index\model\User;
use think\Cookie;
use think\Db;
use think\Session;

class Index extends Controller
{
  public function zhuce(){
    //获取code值
   $code= input('code');
  $url="https://api.weixin.qq.com/sns/jscode2session?appid=wx31bfd378431172ad&secret=8d756205f493fbd4044104b5cd89a7be&js_code=".$code."&grant_type=authorization_code";
  $weixin=$this->https_request($url);//通过code换取网页授权access_token
  $openid = json_decode($weixin)->openid;//获得的实际openid
  // return $openid;
  //注册信息
    $res = json_decode(input('data'));
    $ins = ['lianChuangZhongXin'=>$res->lianChuangZhongXin,'xiTong'=>$res->xiTong,'username'=>$res->username,'password'=>$res->password,'phone'=>$res->phone,'sex'=>$res->sex,'age'=>$res->age,'xueLi'=>$res->xueLi,'IdCard'=>$res->IdCard,'zhangHuXingJi'=>$res->zhangHuXingJi,'tuiJianRen'=>$res->tuiJianRen,'tel'=>$res->tel,'city'=>$res->city,'openId'=>$openid];
    $b = Db::table('user')->insert($ins);
    if($b == 1){
      return "插入成功";
    }else{
      return "插入失败";
    }
}
public function login(){
  $res = json_decode(input('data'));
  $b = Db::table('user')->where('username',$res->username)->where('password',$res->password)->where('phone',$res->phone)->find();
  if(!empty($b)){
    return "登录成功";
  }else{
    return "登录失败";
  }

}

public function getCourse(){
  $res = Db::table('course')->order('new','desc')->select();
  return json_encode($res);
}

public function getOpenId(){
 $code= input('code');
 $url="https://api.weixin.qq.com/sns/jscode2session?appid=wx31bfd378431172ad&secret=8d756205f493fbd4044104b5cd89a7be&js_code=".$code."&grant_type=authorization_code";
  $weixin=$this->https_request($url);//通过code换取网页授权access_token
  $openid = json_decode($weixin)->openid;//获得的实际openid
  $res = Db::table('user')->where('openid',$openid)->find();
  if(empty($res)){
    return 0;
  }else{
    return json_encode($res);//如果用户已经注册，返回用户信息，小程序直接登录
  }
  // return $openid;
  // return json_encode($weixin);
}
public function https_request($url,$data = null){
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
  if (!empty($data)){
    curl_setopt($curl, CURLOPT_GET, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
  }
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  $output = curl_exec($curl);
  curl_close($curl);
  return $output;
}

public function test(){
  $data = ['name'=>'时代周刊','biaoQian'=>'时尚 男人装','courseImgUrl'=>'/pages/images/c2.jpg','jianjie'=>'《时代周刊》（Time）又称《时代》，创立于1923年，是半个世纪多以前最先出现的新闻周刊之一，特为新的日益增长的国际读者群开设一个了解全球新闻的窗口。《时代》是美国三大时事性周刊之一，内容广泛，对国际问题发表主张和对国际重大事件进行跟踪报道。','price'=>500];
  Db::table('course')->insert($data);
}
public function test2(){
  var_dump($_GET);
}



    //结尾
}
?>