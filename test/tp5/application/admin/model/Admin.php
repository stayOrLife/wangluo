<?php 
namespace app\admin\model;
use think\Model;
use app\index\model\User;
use app\admin\controller\Index;
use think\Cookie;
use think\Session;

class Admin extends Model{
	public function check($username,$password,$checkbox){
		$result = $this->where('username', $username)->find();
		if($result != null){
			if($password === $result['password']){
				Session::set('name',$username);
				if($checkbox == "1"){
					cookie('name', $username, 3600);
				}else if (Cookie::has('name')) {
					Cookie::delete('name');
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

	public function exis_name($username){
		$user = new User();
		$result = $user->where('username', $username)->find();
		if(!empty($result)){
			return true ;//存在
		}else{
			return false;//不存在
		}
	}

	public function zhuce($username,$password,$target,$QSDS){
		$b = $this->exis_name($username);
		if(!$b){
			$user = new User();
			$user->username = $username;
			$user->password = $password;
			// $user->phone = $phone;
			$user->target = $target;
			$user->QSDS = $QSDS;
			$user->SYRDL = $QSDS;
			$user->save();
			$col = new Index();
			return true;
		}else{
			return false;
		}
	}

	//结尾
}

?>