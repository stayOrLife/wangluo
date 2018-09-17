<?php 
namespace app\index\model;
use think\Model;
use app\index\model\T;
use think\Cookie;
session_start();
class User extends Model{
	public function test(){
		echo "123";
	}
	public function check($username,$phone,$password,$checkbox){
		$result = $this->where('username', $username)->where('phone',$phone)->find();
		$password = md5(trim($password));
		if($result != null){
			if($password === $result['password'] ){
				session('username', $username);
				session('phone', $phone);
				if($checkbox == 1){
					// Cookie::set('username',$username,1200);
					cookie("username",$username,1200);
					cookie("phone",$phone,1200);
					// Cookie::set('password',$password,1200);
				}else{
					// Cookie::set('username',$username,-1);
					cookie("username",null);
					cookie("phone",null);
					// Cookie::set('username',$username,-1);
				}
				return true;
			}else{
				echo "密码错误！";
				return false ;
			}
		}else{
			echo "该用户没有注册！";
			return false;
		}
	}
	

	//结尾
}

?>