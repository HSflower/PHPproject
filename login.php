<?
session_start();
$id 	= 'guest'; //from db
$pwd	= '123456';

$admId	= 'admin';
$admPw	= '123456';

	$user_id = $_POST['user_id'];
	$user_pw = $_POST['user_pw'];
	$members = array('user1'=>array('pw'=>'pw1', 'name'=>'한놈'),
	        'user2'=>array('pw'=>'pw2', 'name'=>'두시기'),
	        'user3'=>array('pw'=>'pw3', 'name'=>'석삼'));

if(!empty($_POST['id']) && !empty($_POST['pwd'])){
	if(!isset($_POST['user_id']) || !isset($_POST['user_pw'])) {
		echo "<script>alert('아이디 또는 패스워드를 입력하세요');</script>";
		header('Location: http://buyrunicm.cafe24.com/home.html');
		exit;
	}

	if($id==$user_id && $pwd==$user_pw){
		$_SESSION['is_login'] 	= 'guest';
		$_SESSION['niickname']	= 'user';
		$_SESSION['user_id'] = $user_id;
		$_SESSION['user_name'] = $members[$user_id]['name'];
		$_SESSION['my_session']="ok";
		header('Location: http://buyrunicm.cafe24.com/home.html');
		exit;
	} else if($_POST['id']==$admId && hash("123456", $_POST['pwd'])==$admPw){
		$_SESSION['is_login']	= 'admin';
		$_SESSION['niickname']	= 'administrator';
		$_SESSION['user_id'] = $user_id;
		$_SESSION['user_name'] = $members[$user_id]['name'];
		header('Location: http://buyrunicm.cafe24.com/home.html');
		$_SESSION['my_session']="ok";
		exit;
	}
} else{
	$_SESSION['user_id'] = $user_id;
	$_SESSION['user_name'] = $members[$user_id]['name'];
	$_SESSION['my_session']="ok";
		header('Location: http://buyrunicm.cafe24.com/home.html');
	exit;
}

	/*
	if(!isset($members[$user_id])) {
	        echo "<script>alert('아이디 또는 패스워드가 잘못되었습니다.');history.back();</script>";
	        exit;
	}
	if($members[$user_id]['pw'] != $user_pw) {
	        echo "<script>alert('아이디 또는 패스워드가 잘못되었습니다.');history.back();</script>";
	        exit;
	}
	*/
	
?>
<!--	<meta http-equiv='refresh' content='0;url=home.html'> -->