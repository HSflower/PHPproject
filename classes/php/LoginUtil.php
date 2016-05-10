<? include $_SERVER[DOCUMENT_ROOT] . "/common/classes/Constants.php" ?>
<?php
/*
 * Created on 2006. 09. 25
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */ 
if(! class_exists("LoginUtil")){
	 class LoginUtil
	 {
	 	var $spliter = 30 ;		// Seperator Ascii code
	
	 	
		function getAdminUser()
		{
			$cookieStr = $_COOKIE["admMap"] ;
	 		
			if( LoginUtil::isAdminLogin() == false )
			{	
				$map['no'] = "-1" ;
				// $map['mem_id'] = session_id() ;
			}
			else
			{
				$cookieStr = pack("H*",$cookieStr);
				
				$aUser = explode(chr(30),$cookieStr);
	
				$map['no']				=	$aUser[0] ;
				$map['id']				=	$aUser[1] ;
				$map['name']			=	$aUser[2] ;
			}
	
	 		return $map ;	
		}
		
		// 로그인 유무
		function isAdminLogin(){
			$cookieStr = $_COOKIE["admMap"] ;
					
			return ( $cookieStr != "" ) ? true : false ;
		}
		
		//관리자 로그인
		function doAdminLogin($row){
	
			if($row != null){
				$cookieStr =
	
				$row['adminNumber']		. chr(30) .
				$row['id']				. chr(30) .
				$row['name']			. chr(30) ;
								
				$cookieStr = bin2hex($cookieStr) ; // 16진수로 암호화
	
				setcookie("admMap",$cookieStr,-1,"/", '') ;
	
				return true ;
				
			}else{
				
				return false ;
			}			
		}
		
		//admin 로그아웃
		function doAdminLogout(){
			setcookie("admMap","",time() - 3600,"/","") ;
		}
		

		// 사용자 정보
		function getWebUser()
		{
			$cookieStr = $_COOKIE["userMap"] ;
	 		
			if( LoginUtil::isWebUserLogin() == false )
			{	
				$map['userNumber']	= "-1" ;

				// ID,PW 저장 정보 가져오기
				$cookieStr = $_COOKIE["saveMap"] ;

				$cookieStr = pack("H*",$cookieStr);
				
				$aUser = explode(chr(30),$cookieStr);

				$map['saveID']		= $aUser[0] ;
				$map['savePW']		= pack("H*",$aUser[1]) ;
				// $map['mem_id'] = session_id() ;
			}
			else
			{
				$cookieStr = pack("H*",$cookieStr);
				
				$aUser = explode(chr(30),$cookieStr);
	
				$map['userNumber']		=	$aUser[0] ;
				$map['userID']			=	$aUser[1] ;
				$map['calcViewType']	=	$aUser[2] ;
				$map['assType']			=	$aUser[3] ;
				$map['companyName']		=	$aUser[4] ;	
				$map['noteText1']		=	$aUser[5] ;								
			}
	
	 		return $map ;	
		}
		
		// 사용자 로그인 유무
		function isWebUserLogin(){
			$cookieStr = $_COOKIE["userMap"] ;
					
			return ( $cookieStr != "" ) ? true : false ;
		}
		
		// 사용자 로그인
		function doWebUserLogin($row){
	
			if($row != null){
				$cookieStr =
	
				$row['userNumber']		. chr(30) .
				$row['userID']			. chr(30) .
				$row['calcViewType']	. chr(30) .
				$row['assType']			. chr(30) .
				$row['companyName']		. chr(30) .	
				$row['noteText1']		. chr(30) ;								
								
				$cookieStr = bin2hex($cookieStr) ; // 16진수로 암호화
	
				setcookie("userMap",$cookieStr,-1,"/", '') ;
				
				// ID,PW 저장
				$cookieStr = "";

				if($row["saveID"] == "1"){
					$cookieStr .= $row['userID']			. chr(30) ;
				}
				else
				{
					$cookieStr .= ""			. chr(30) ;
				}
				if($row["savePW"] == "1"){
					$cookieStr .= $row["userPWenc"]			. chr(30) ;
				}
				else
				{
					$cookieStr .= ""			. chr(30) ;
				}

				$cookieStr = bin2hex($cookieStr) ;

				setcookie("saveMap",$cookieStr,time() +3600,"/", '') ;
	
				return true ;
				
			}else{
				
				return false ;
			}			
		}
		
		// 사용자 로그아웃
		function doWebUserLogout(){
			setcookie("userMap","",time() - 3600,"/","") ;
		}
		
		//입력 후 로그인 - APP 로그인
		function doAppLogin($row){
	
			if($row != null){
				$cookieStr =

				$row['user_no']			. chr(30) .
				$row['email']			. chr(30) .
				$row['fb_id']			. chr(30) .
				$row['user_name'] 		. chr(30) .
				$row['user_type'] 		. chr(30) .
				$row['user_group'] 		. chr(30) .
				$row['regist_dt']		. chr(30) .				
				$row['appVersion']		. chr(30) .	
				$row['storeTypeID']		. chr(30) ;
								
				$cookieStr = bin2hex($cookieStr) ; // 16진수로 암호화
	
				//setcookie("userMap",$cookieStr,-1,"/", '.richware.co.kr') ;
				setcookie("userMap",$cookieStr,-1,"/", '') ;
	
				return true ;
				
			}else{
				
				return false ;
			}
		}
		
		
		// 어플 로그인 여부를 확인한다.
	 	function isAppLogin()
	 	{
	 		$cookieStr = $_COOKIE["userMap"] ;
	 		
			$cookieStr = pack("H*",$cookieStr);
				
			$aUser = explode(chr(30),$cookieStr);		
			
	 		return ( $aUser[0] != "" && $aUser[0] != "-1"  ) ? true : false ;
	 	}
		
		
		function getAppUser(){
			$cookieStr = $_COOKIE["userMap"] ;
			
			$cookieStr = pack("H*",$cookieStr);
				
			$aUser = explode(chr(30),$cookieStr);

			$map['user_no']		=	$aUser[0] ;
			$map['email']		=	$aUser[1] ;
			$map['fb_id']		=	$aUser[2] ;
			$map['user_name']	=	$aUser[3] ;
			$map['user_type']	=	$aUser[4] ;				
			$map['user_group']	=	$aUser[5] ;			
			$map['regist_dt']	=	$aUser[6] ;
			$map['appVersion']	=	$aUser[7] ;
			$map['storeTypeID']	=	$aUser[8] ;
	 		
			if( LoginUtil::isAppLogin() == false )
			{	
				$map['user_no'] = "-1" ;
			}
	
	 		return $map ;	
		}
		
		
		function doAppLogout(){
			setcookie("userMap","",time() - 3600,"/","") ;
		}
		
	

 	}	
}
?>