<?
//	session_start();

/*
	//DB connection -> create class and include
	$db = mysqli_connect($servername, $username, $password, $dbName); //db connection
	//var $result ;			//result set
	$debug = true ;		//is debug??

	// Check connection
	 if ($db->connect_error) {
	     die("Connection failed: " . $db->connect_error);
	} 
	echo "Connected successfully";

	$sql = "SELECT * FROM tblUser";

	if ($db->query($sql) === TRUE) {
	    $login_row = mysql_fetch_array($sql);
	} else {
	    echo "Error: " . $sql . "<br>" . $db->error;
	}

	//Example (MySQLi Procedural)
	mysqli_close($db);  

	//DB connection process end

	if($logout=="yes"){
		session_unset();
		echo "<script>alert('logout successed');</script>"; //location.href='home.html';
		header('Location: http://buyrunicm.cafe24.com/home.html');
	} else{
		//if($login_row[id]==$userID && $login_row[pw]==$pwd){
		if((trim($userID)=="noid") && (trim($userPW)=="nopw")){
			$_SESSION['is_login'] 	= 'guest';//$id;//
			$_SESSION['niickname']	= 'user';//$pw;//
			header('Location: http://buyrunicm.cafe24.com/home.html');
		} else{
			echo "<script>alert('login failed');</script>";
			header('Location: http://buyrunicm.cafe24.com/home.html');
		}
	}
*/	

/*
if(!isset($_POST['user_id']) || !isset($_POST['user_pw'])) exit;
$user_id = $_POST['user_id'];
$user_pw = $_POST['user_pw'];
$members = array('user1'=>array('pw'=>'1111', 'name'=>'김한슬'),
        'user2'=>array('pw'=>'1111', 'name'=>'이주영'),
        'user3'=>array('pw'=>'1111', 'name'=>'김종균'));
 
if( !isset($members[$user_id]) ) {
        echo "<script>alert('아이디 또는 패스워드가 잘못되었습니다.');history.back();</script>";
        exit;
}
if($members[$user_id]['pw'] != $user_pw) {
        echo "<script>alert('아이디 또는 패스워드가 잘못되었습니다.');history.back();</script>";
        exit;
}
session_start();
$_SESSION['user_id'] = $user_id;
$_SESSION['user_name'] = $members[$user_id]['name'];

header('Location: http://buyrunicm.cafe24.com/home.html');
*/
?>
<!--<meta http-equiv='refresh' content='0;url=home.html'>-->
<?php
/*
if(!isset($_POST['is_ajax'])) exit;
if(!isset($_POST['user_id'])) exit;
if(!isset($_POST['user_pw'])) exit;
$is_ajax=$_POST['is_ajax'];
$user_id = $_POST['user_id'];
$user_pw = $_POST['user_pw'];
$members = array('user1'=>array('pw'=>'1111', 'name'=>'한슬'),
        'user2'=>array('pw'=>'pw2', 'name'=>'두시기'),
        'user3'=>array('pw'=>'pw3', 'name'=>'석삼'));
 
if(!$is_ajax) exit;
if(!isset($members[$user_id])) exit;
if($members[$user_id]['pw'] != $user_pw) exit;
setcookie('user_id',$user_id);
setcookie('user_name',$members[$user_id]['name']);
echo "success";	
*/
?>
<?php
if(!isset($_POST['user_id']) || !isset($_POST['user_pw']))
echo "You can't login :P";
$user_id = $_POST['user_id'];
$user_pw = $_POST['user_pw'];
$members = array('user1'=>array('pw'=>'pw1', 'name'=>'한놈'),
        'user2'=>array('pw'=>'pw2', 'name'=>'두시기'),
        'user3'=>array('pw'=>'pw3', 'name'=>'석삼'));
 
if(!isset($members[$user_id])) {
        echo "<script>alert('아이디 또는 패스워드가 잘못되었습니다.');history.back();</script>";
        exit;
}
if($members[$user_id]['pw'] != $user_pw) {
        echo "<script>alert('아이디 또는 패스워드가 잘못되었습니다.');history.back();</script>";
        exit;
}
session_start();
$_SESSION['user_id'] = $user_id;
$_SESSION['user_name'] = $members[$user_id]['name'];
?>
<meta http-equiv='refresh' content='0;url=home.html'>