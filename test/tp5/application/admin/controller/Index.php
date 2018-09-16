<?php 
namespace app\admin\controller;
use think\Db;
use think\Controller;
use think\Cookie;
use think\Session;
use app\index\model\Temp;
use app\index\model\User;
use app\admin\model\T;

class Index extends \think\Controller
{
	public function index()
	{
		if(Cookie::has('name') ){
			return $this->fetch("adminIndex");
		}else{
			return $this->fetch();
		}
	}
	public function loginPro(){
		if(Cookie::has('name') ){
			return $this->fetch("adminIndex");
		}else{
			$mod = model("Admin");
			$checkbox = isset($_POST['pwd'])?'1':'0' ;
			$b = $mod->check(input('username'),input('password'),$checkbox);
			if($b){
				return $this->fetch("adminIndex");
			}else {
				setcookie("adminName",$_POST['username'],time()-1);
				return $this->error('登录失败','index/index/index');
			}
		}
		
	}
	public function zhuce(){
		$mod = model("Admin");
		$b = $mod->zhuce(input('username'),input('password'),input('target'),input('QSDS'));
		echo input('username');
		if($b){
			echo "<div style='color:black;text-align:center'>注册成功</div>";
		}else{
			echo "<div style='color:red;text-align:center'>注册失败</div>";
		}
		return $this->fetch("Index/adminIndex");
	}
	public function zhuxiao(){
		if(Cookie::has('name')){
			Cookie::delete('name');
			Session::delete('name');
		}
		echo Cookie::delete('name');
		return $this->fetch("index");
	}
	public function zhuceAdmin(){
		$list = Temp::order('WCL','desc')->paginate(10,false);
		$i=0;
		$this->assign('list', $list);
		$this->assign('i',$i);
		return $this->fetch("zhuceAdmin");
	}
	public function userAdmin(){
		$list = User::order('WCL','desc')->paginate(10,false);
		$i=0;
		$this->assign('list', $list);
		$this->assign('i',$i);
		return $this->fetch("userAdmin");
	}
	public function T(){
		$list = T::paginate(5,false);
		$this->assign('i', 1);
		$this->assign('list', $list);
		return $this->fetch("Tadmin");
	}
	public function Tpro(){
		$mod = model("T");
		$mod->data(['startTime'  => $_POST['startTime'], 'endTime' =>  $_POST['endTime']]);
		$mod->save();
		$list = T::paginate(5,false);
		$this->assign('i', 1);
		$this->assign('list', $list);
		return $this->fetch("Tadmin");
	}
	public function zhuceUser(){
		$user = model("User");
		// var_dump($_GET);
		if(input('flag') == "zhuce"){
			$user->data([ 'username'  =>  input('username'),  'password' =>  md5(input('password')),'phone' => input('phone')]);
			$user->save();
		}
		Temp::destroy(['phone' => input('phone')]);
		$this->redirect('Index/zhuceAdmin', ['cate_id' => 2]);
	}
	public function select(){
		$mod = model("User");
		$result = $mod->where("phone",$_POST['phone'])->where("username",$_POST['username'])->find();
		$list = User::order('WCL','desc')->paginate(10,false);
		$this->assign('list', $list);
		if(empty($result)){
			$mess = "该用户没有注册";
			$this->assign('mess',$mess);
			$this->assign('result',$result);
			return $this->fetch("userAdmin");
		}else{
			$mess = 1;
			$this->assign('mess',$mess);
			$this->assign('result',$result);
			return $this->fetch("userAdmin");
		}
	}

	public function del($phone){
		User::destroy(["phone" => $phone]);
		$list = User::order('WCL','desc')->paginate(10,false);
		$this->assign('list', $list);
		return $this->fetch("userAdmin");
	}

	public function update($phone){
		$user = new User();
		$result = $user->where('phone', $phone)->find();
		$this->assign('result', $result);
		return $this->fetch("update");
	}

	public function updatePro($flag,$phone){
		$user = new User;
		$result =$user->where('phone', $phone)->find();
		if($flag == 1){
			if(empty($_POST['Ttarget']) || empty($_POST['CSL']) ){
				if(empty($_POST['Ttarget'])){
					$user->save([ 'CSL'  => $_POST['CSL'], 'WCL' => ($result['JRDL'] - $_POST['CSL'])/$result['Ttarget'] ],['phone' => $phone]);
				}else {
					$user->save([ 'Ttarget'  => $_POST['Ttarget'],'ZZL' => $result['DRZL']/$_POST['Ttarget'] , 'WCL' => ($result['JRDL'] - $result['CSL'])/$_POST['Ttarget'] ],['phone' => $phone]);
				}
			}else {
				$user->save([ 'Ttarget'  => $_POST['Ttarget'], 'CSL'  => $_POST['CSL'],'ZZL' => $result['DRZL']/$_POST['Ttarget'] , 'WCL' => ($result['JRDL'] - $_POST['CSL'])/$_POST['Ttarget'] ],['phone' => $phone]);
			}
		}else{
			$user->save([ 'Ttarget'  => $_POST['Ttarget'], 'ZZL' => $result['DRZL']/$_POST['Ttarget'] , 'WCL' => $result['JRDL']/$_POST['Ttarget'] ],['phone' => $phone]);
		}
		$list = User::order('WCL','desc')->paginate(10,false);
		$this->assign('list', $list);
		return $this->fetch("userAdmin");
	}

	public function emptyAll(){
		Db::execute("delete from user");
		$list = User::order('WCL','desc')->paginate(10,false);
		$this->assign('list', $list);
		return $this->fetch("userAdmin");
	}

	public function changTPro(){
		$T = model("T");
		$T->save(['endTime'  => $_POST['endTime'] ],['startTime' => $_POST['startTime']]);
		$list = T::paginate(5,false);
		$this->assign('i', 1);
		$this->assign('list', $list);
		return $this->fetch("Tadmin");

	}
	//结尾
}
?>