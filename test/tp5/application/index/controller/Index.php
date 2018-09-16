<?php 
namespace app\index\controller;
use think\Controller;
use app\index\model\User;
use think\Cookie;
use think\Db;
use think\Session;

class a{
	public $username = "zhong";
}

class Index extends Controller
{
  public function test(){
  	$name = "zhong";
  	$str = "[{zhong}]";
  	$str = str_replace("[{".$name."}]", 'Z', $str);
  	echo $str;
  	// $model = model("admin/User");
  	// $model->test();
  	// $res = $model->find('27');
  	// $obj = new a();
  	// return $this->fetch('test',['obj'=>$obj,'res'=>$res]);
  }

  //原项目代码
  // public function test(){
  //   echo ROOT_PATH;
  // }
  public function index()
  {

 //  	Db::execute("create table if not exists T(
	// id int not null auto_increment primary key,
	// startTime date,
	// endTime date
 //  	)engine=myisam default charset=utf8");

 //  	Db::execute("create table if not exists User(
	// id int not null auto_increment primary key,
	// username varchar(12)not null,
	// password varchar(64)not null,
	// phone char(11)not null unique,
	// Ttarget int,
	// JRXZ int,
	// CSL int,
	// QYRDL int,
	// DRZL int,
	// ZZL float,
	// WCL float,
	// flag char(1),
	// updateTIme date,
	// TID int,
	// foreign key(TID)references T(id)
 //  	)engine=myisam default charset=utf8");

 //  	Db::execute("create table if not exists Temp(
	// id int not null auto_increment primary key,
	// username varchar(12)not null,
	// password varchar(64)not null,
	// phone char(11)not null unique,
	// Ttarget int,
	// JRXZ int,
	// CSL int,
	// QYRDL int,
	// DRZL int,
	// ZZL float,
	// WCL float,
	// flag char(1),
	// updateTIme date,
	// TID int,
	// foreign key(TID)references T(id)
 //  	)engine=myisam default charset=utf8");

    $mod = model("User");

    $list = User::order('WCL','desc')->paginate(10,false);
    $list[sizeof($list)-1]->date = date('Y-m-d');
    // return json_encode($list);
    $i=0;
    $this->assign('list', $list);
    $this->assign('i',$i);
    $this->assign('date',date('Y-m-d'));
    return $this->fetch();
  }
 //  public function login(){
 //    if(COOKIE::has('username')){
 //      $mod = model("User");
 //      $result = $mod->where('username', cookie("username"))->where('phone',cookie("phone"))->find();

 //      if(!empty($result['TID'])){
 //   		// SELECT A.*,B.* from table1 as A,table2 as B where A.*=B.* and A.*=*
 //       $res = Db::query("select a.* from User as u , T  as a where u.TID = a.id");
 //       $this->assign("startTime",$res[0]['startTime']);
 //       $this->assign("endTime",$res[0]['endTime']);
 //     }
 //     $this->assign("TID",$result['TID']);
 //     $this->assign("flag",$result['flag']);
 //     $this->assign("date",date("Y-m-d"));

 //     return $this->fetch("userIndex");
 //   }
 //   return $this->fetch("login");
 // }
//  public function loginPro(){
//    $mod = model("User");
//    $checkbox = isset($_POST['checkbox'])?'1':'0' ;
//    $b = $mod->check($_POST['username'],$_POST['phone'],$_POST['password'],$checkbox);
//    if($b){

//    	$result = $mod->where('username', $_POST['username'])->where('phone',$_POST['phone'])->find();

//    	if(!empty($result['TID'])){
//    		// SELECT A.*,B.* from table1 as A,table2 as B where A.*=B.* and A.*=*
//    		$res = Db::query("select a.* from User as u , T  as a where u.TID = a.id");
//       $this->assign("startTime",$res[0]['startTime']);
//       $this->assign("endTime",$res[0]['endTime']);
//     }
//     $this->assign("TID",$result['TID']);
//     $this->assign("flag",$result['flag']);
//     $this->assign("date",date("Y-m-d"));

//     return $this->fetch("userIndex");
//   }else {
//     echo $b;
//     $url = url("index/login");
//     echo "<a href='$url'>返回登录界面</a>";
//   }
// }
// public function DRWCL($flag){
//   $mod = model("User");
//   $result = $mod->where('username', session("username"))->find();

//   $time =date("Y-m-d");
//   $res = Db::query("select * from T");

//   for($i=0;$i<sizeof($res);$i++){
//   	if( date("Y-m-d") >= $res[$i]['startTime'] && date("Y-m-d") <= $res[$i]['endTime']){
//   		$id = $res[$i]['id'];
//   	}
//   }
//   if($flag == 1){
//   	if( empty($_POST['Target']) ){
//   		$tempTarget = $result["Ttarget"];
//   		$tempCSL = $result["CSL"];
//   	}else{
//   		$tempTarget = $_POST['Target'];
//   		$tempCSL = $_POST['CSL'];
//   	}
//     $temp = $result['QYRDL'];
//     $mod->save(['flag' => $flag, 'TID' => $id, "Ttarget" => $tempTarget, "CSL" => $tempCSL, "QYRDL" => $_POST['JRDS'], "DRZL" => $_POST['JRDS'] -$temp , "ZZL" => (($_POST['JRDS'] -$temp)/$tempTarget), "WCL" => (($_POST['JRDS']-$tempCSL)/$tempTarget),'UT' => date('Y-m-d'),'JRDL' => $_POST['JRDS'] ],['username' => session('username')]);
//   }else if($flag == 2){
//     if( empty($_POST['Target']) ){
//       $tempTarget = $result["Ttarget"];
//     }else{
//       $tempTarget = $_POST['Target'];
//     }
//     $temp = $result['QYRDL'];
//     $mod->save(['flag' => $flag, 'TID' => $id, "Ttarget" => $tempTarget, "QYRDL" => $_POST['DRZL']+ $temp, "DRZL" => $_POST['DRZL'] , "ZZL" => $_POST['DRZL']/$tempTarget, "WCL" => ($temp +  $_POST['DRZL'])/$tempTarget,'UT' => date('Y-m-d'),'JRDL' => $_POST['DRZL'] + $temp ],['username' => session('username')]);
//   }
//   $this->redirect('Index/index', ['cate_id' => 2]);
// }
// public function zhuxiao(){
//   if(COOKIE::has('username')){
//   	session("username",null);
//     cookie("username",null);
//   }
//   $this->redirect('Index/login', ['cate_id' => 2]);
// }
// public function zhuce(){
// 	return $this->fetch("zhuce");
// }
// public function zhucePro(){
// 	$mod = model("Temp");
// 	$mod->data(['username'  => $_POST['username'], 'password' =>  ($_POST['password']),'phone'  => $_POST['phone'] ] );
// 	$mod->save();
// 	return $this->fetch("zhuce");
// }


    //结尾
}
?>