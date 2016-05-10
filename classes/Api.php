<? include_once $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Push.php" ; ?>
<? include_once $_SERVER["DOCUMENT_ROOT"] . "/common/classes/comm/SimpleImage.php" ; ?>
<? include_once $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Email.php" ;?>
<? include_once $_SERVER["DOCUMENT_ROOT"] . "/common/classes/GEmail.php";?>
<? include_once $_SERVER["DOCUMENT_ROOT"] . "/common/classes/class.EmmaSMS.php" ;?>
<? include_once $_SERVER["DOCUMENT_ROOT"] . "/common/classes/xmlrpc.inc.php" ;?>
<?php
if(! class_exists("Api") )	{

	class Api extends Push {
		
		
		// xml 키가 들어 왔을경우 
		function Api($req,$xmlKey) 
		{
			$this->HomeFrm($req,$xmlKey) ;
		}

		function wrapParam()
		{
			$this->req['page']	= ($this->req['page'] == "") ? 1 : $this->req['page'] ;			 
		}
				
		function getAddQuery()
		{			
			$addQuery = "" ;

			return $addQuery ;
		}

		
		
		
		/***************************************************************************
		*	제  목 : 인트로 프로세스
		*	함수명 : introProcess
		*	작성일 : 2013-08-19
		*	작성자 : dev.Na
		*	설  명 : 
		*	수  정 :
		'***************************************************************************/
		function introProcess()
		{
			$appVersion			= $this->req["appVersion"];
			$deviceID			= $this->req["deviceID"];
			$deviceTypeID		= $this->req["deviceTypeID"];
			$storeTypeID		= $this->req["storeTypeID"];
			$registrationKey	= $this->req["registrationKey"];
			$userNo				= $this->req["user_no"];


			$versionParams["appVersion"]	= $appVersion;			// APP 버전
			$versionParams["deviceTypeID"]	= $deviceTypeID;		// APP 타입
			$versionParams["storeTypeID"]	= $storeTypeID;		// store 타입
			$versionParams["user_no"]		= $userNo;

			$versionInfo = $this->inFn_Api_getVersionSync($versionParams);


			$loginParams["userNo"]				= $userNo;
			$loginParams["deviceID"]			= $deviceID;
			$loginParams["deviceTypeID"]		= $deviceTypeID;
			$loginParams["storeTypeID"]			= $storeTypeID;
			$loginParams["registrationKey"]		= $registrationKey;
			$loginParams["appVersion"]			= $appVersion;

			$loginInfo = $this->inFn_Api_autoLogin($loginParams);

			

			$resultJson = array_merge($versionInfo, $loginInfo);


			return json_encode($resultJson);

		}



		function doAppLogout()
		{
			LoginUtil::doAppLogout();

			$resultJson = Array(
				"callApi"		=> $this->callApi,
				"returnCode"	=> "1",
				"returnMessage"	=> "로그아웃 처리되었습니다.",
				"entity"		=> ""
			);

			return json_encode($resultJson);
		}


		
		/***************************************************************************
		*	제  목 : 이용약관/개인정보 취급방침
		*	함수명 : getInfoOfProvision
		*	작성일 : 2013-08-19
		*	작성자 : dev.Na
		*	설  명 : 
		*	수  정 :
		'***************************************************************************/
		function getInfoOfProvision()
		{

			$agree = "";
			$privacy = "";

			$filePath = $this->agreeInfoPath;

			$files = fopen($filePath, "r");
			
			while($ss = fgets($files, 1024))	
			{
				$agree .= $ss;
			}
			
			fclose($files);


			$filePath = $this->privacyInfoPath;

			$files = fopen($filePath, "r");
			
			while($ss = fgets($files, 1024))	
			{
				$privacy .= $ss;
			}
			
			fclose($files);
			
			$entity = Array(
				"agree"		=> $agree,
				"privacy"	=> $privacy
			);
									
			$resultJson = array(
				"returnCode"	=> "1" ,
				"returnMessage" => "" ,
				"entity"		=> $entity
			) ;

			return json_encode($resultJson) ;
		}




		/***************************************************************************
		*	제  목 : 자동 로그인 함수
		*	함수명 : inFn_Api_autoLogin
		*	작성일 : 2013-08-19
		*	작성자 : dev.Na
		*	설  명 : 
		*	수  정 :
		'***************************************************************************/
		function inFn_Api_autoLogin($loginParams)
		{

			$param = Array(
				$loginParams["userNo"],
				$loginParams["deviceID"],
				$loginParams["deviceTypeID"],
				$loginParams["storeTypeID"],
				$loginParams["registrationKey"],
				$loginParams["appVersion"]
			) ;
			
			
			$ret = Array(
				"po_returnCode"	=>	"@po_returnCode"
			) ; 
			
			$sql = $this->strCallProc("uspU_autoLogin", $param, $ret) ;
			

			$result =  $this->getMultiArray($sql) ;

	
			if($result[0][0]["po_returnCode"] == "-1")
			{
				$loginInfo["isLogin"]	= $result[0][0]["po_returnCode"];
				$loginInfo["loginInfo"]	= "";
			}
			else
			{
				$loginInfo["isLogin"]	= $result[0][0]["po_returnCode"];
				$loginInfo["loginInfo"]	= $this->inFn_Api_getInfoOfUser($loginParams["userNo"]);
				LoginUtil::doAppLogin($loginInfo["loginInfo"]);
			}
			
			return $loginInfo;
		}




		/***************************************************************************
		*	제  목 : 회원정보 조회
		*	함수명 : inFn_Api_getInfoOfUser
		*	작성일 : 2013-08-20
		*	작성자 : dev.Na
		*	설  명 : 
		*	수  정 :
		'***************************************************************************/
		function inFn_Api_getInfoOfUser($userNo)
		{
			$sql = "
				SELECT
					U.user_name, U.email, U.user_type, U.regist_dt, U.user_no, U.fb_id, U.avail_mileage, U.temp_mileage, U.user_group,
					IFNULL(I.image_path, '') AS image_path, IFNULL(I.image_width, '0') AS image_width, IFNULL(I.image_height, '0') AS image_height
				FROM tbl_user U
				LEFT JOIN tbl_image I ON(U.user_no = I.target_fk AND I.target_type_id = '9')
				WHERE U.user_no = '{$userNo}'
				LIMIT 0, 1
			";

			$userInfo = $this->getRow($sql);

			if($userInfo == null)
			{
				return false;
			}

			return $userInfo;
		}



		/***************************************************************************
		*	제  목 : 버전체크 내부함수
		*	함수명 : inFn_Api_getVersionSync
		*	작성일 : 2013-07-04
		*	작성자 : dev.Na
		*	설  명 : 
		*	수  정 :
		'***************************************************************************/
		function inFn_Api_getVersionSync($versionParams)
		{			
			$appVersion		= $versionParams["appVersion"];			// APP 버전
			$appTypeID		= $versionParams["deviceTypeID"];		// APP 타입
			$storeTypeID	= $versionParams["storeTypeID"];		// store 타입
			
			$appVersionInt = (int)str_replace(".", "", $appVersion);
			
			$isMustUpdate = "0";
			
			$sql = "
				SELECT COUNT(*) AS isUpdate
				FROM tbl_app_version 
				WHERE appTypeID = '{$appTypeID}' AND storeTypeID = '{$storeTypeID}' AND versionInt > {$appVersionInt};
				
				SELECT COUNT(*) AS isMustUpdate
				FROM tbl_app_version 
				WHERE appTypeID = '{$appTypeID}' AND storeTypeID = '{$storeTypeID}' AND versionInt > {$appVersionInt} AND isMustUpdate > 0;
				
				SELECT version
				FROM tbl_app_version
				WHERE appTypeID = '{$appTypeID}' AND storeTypeID = '{$storeTypeID}'
				ORDER BY versionInt DESC
				LIMIT 0, 1;
			";
			
			
			$result = $this->getMultiArray($sql);

			

			if($result[2][0]["version"] == "")
			{
				$returnCode = "-1";
				$returnMessage = "해당 마켓에 등록된 어플이 아닙니다.";
			}
			else if($result[0][0]["isUpdate"] > 0)
			{
				$returnCode = "-10";
				$returnMessage = "업데이트된 버전이 있습니다. 업데이트 받으시겠습니까?";
				
				if($result[1][0]["isMustUpdate"] > 0)
				{
					$returnCode = "-20";
					$returnMessage = "업데이트된 버전이 있습니다. 업데이트 받으셔야만 이용하실 수 있습니다.";
				}	
			}
			else
			{
				$returnCode = "1";
				$returnMessage = "";
			}

			$marketUrl = "";

			
			$retArr = Array(
				"returnCode"	=> $returnCode,
				"returnMessage"	=> $returnMessage,
				"version"		=> $result[2][0]["version"],
				"marketUrl"		=> $marketUrl,
			);

			return $retArr;
		}


		function fileUploadMulti()
		{

			$Extension = array("txt","html","asp","php");
			$Upload = new Upload($_FILES["file"],$this->fileSavePath,$Extension,1);
			$fileData = $Upload->processing() ;

			$fileList = Array() ;

			
			for( $i = 0 ; $i < sizeof($_FILES["file"]["name"]) ; $i++ )
			{
				if( strcmp($fileData[$i]['re_name'],"") ){
					$fileName = $Upload->GetDate() . "/" . $fileData[$i]['re_name'];
					array_push($fileList, $fileName);
					$image = new SimpleImage();
					$assoc = array($this->fileSavePath_480, $this->fileSavePath_240, $this->fileSavePath_100) ; 
					$image->check($assoc) ;
					$image->processing($this->fileSavePath . $Upload->GetDate() . "/", $this->fileSavePath_720, 720, $fileData[$i]['re_name']) ;
					$image->processing($this->fileSavePath . $Upload->GetDate() . "/", $this->fileSavePath_480, 480, $fileData[$i]['re_name']) ;
					$image->processing($this->fileSavePath . $Upload->GetDate() . "/", $this->fileSavePath_320, 320, $fileData[$i]['re_name']) ;
					$image->processing($this->fileSavePath . $Upload->GetDate() . "/", $this->fileSavePath_240, 240, $fileData[$i]['re_name']) ;
					$image->processing($this->fileSavePath . $Upload->GetDate() . "/", $this->fileSavePath_100, 100, $fileData[$i]['re_name']) ;
				}
			}

			if(sizeof($fileList) > 0)
			{
				$resultJson = Array(
					"callApi"			=> $this->callApi,
					"returnCode"		=> "1",
					"returnMessage"		=> "",
					"entity"			=> $fileList
				);
				
				return json_encode($resultJson);
			}

			
		}


		/***************************************************************************
		*	제  목 : 상품등록시 파일 업로드
		*	함수명 : fileUpload
		*	작성일 : 2013-07-22
		*	작성자 : dev.Na
		*	설  명 : 
		*	수  정 :
		'***************************************************************************/
		function fileUpload()
		{

			$Extension = array("txt","html","asp","php");
			$Upload = new Upload($_FILES["file"],$this->fileSavePath,$Extension,1);
			$fileData = $Upload->processing() ;

			$filePath = "" ;
			
			if( strcmp($fileData[0]['re_name'],"") ){
				$filePath = $Upload->GetDate() . "/" . $fileData[0]['re_name'];
				$image = new SimpleImage();
				$assoc = array(
					$this->fileSavePath_720, 
					$this->fileSavePath_480,
					$this->fileSavePath_320,
					$this->fileSavePath_240,
					$this->fileSavePath_100
				) ;

				$image->check($assoc) ;

				$image->processing($this->fileSavePath . $Upload->GetDate() . "/", $this->fileSavePath_720, 720, $fileData[0]['re_name']) ;
				$image->processing($this->fileSavePath . $Upload->GetDate() . "/", $this->fileSavePath_480, 480, $fileData[0]['re_name']) ;
				$image->processing($this->fileSavePath . $Upload->GetDate() . "/", $this->fileSavePath_320, 320, $fileData[0]['re_name']) ;
				$image->processing($this->fileSavePath . $Upload->GetDate() . "/", $this->fileSavePath_240, 240, $fileData[0]['re_name']) ;
				$image->processing($this->fileSavePath . $Upload->GetDate() . "/", $this->fileSavePath_100, 100, $fileData[0]['re_name']) ;
			}
			

			if($filePath == "")
			{
				$returnCode		= "-1";
				$returnMessage	= "";
			}
			else
			{
				$returnCode		= "1";
				$returnMessage	= "";	
			}


			$resultJson = Array(
				"callApi"			=> $this->callApi,
				"returnCode"		=> $returnCode,
				"returnMessage"		=> $returnMessage,
				"entity"			=> $filePath
			);
			
			return json_encode($resultJson);

		}



		/***************************************************************************
		*	제  목 : 이미지 파일 사이즈 구하기
		*	함수명 : fileUpload
		*	작성일 : 2013-07-22
		*	작성자 : dev.Na
		*	설  명 : 
		*	수  정 :
		'***************************************************************************/
		function getImageSize($imgUrl)
		{
			$imgUrl = str_replace("/upload_img/", "", $imgUrl);

			$imgUrl = $this->fileSavePath.$imgUrl;
			$sizeInfo = getimagesize($imgUrl);

			if($sizeInfo != false)
			{
				$file_width		= $sizeInfo[0];
				$file_height	= $sizeInfo[1];
			}
			else
			{
				$file_width		= "0";
				$file_height	= "0";
			}

			$retArr = Array(
				"file_name"		=> str_replace($this->fileSavePath, "", $imgUrl),
				"file_width"	=> $file_width,
				"file_height"	=> $file_height
			);

			return $retArr;

		}



		// 파일명중 확장자를 분리해준다.
		function getFileExtension($imgUrl){
			
			$Tmp = explode(".",$imgUrl);
			
			return $Tmp[count($Tmp)-1];
		}


		function smsTest()
		{
			$str = "투리 테스트입니다. 님의 선물을 받아주세요.퍼니룰렛 돌리고, 퍼니콘 직접 고르기!돌리러 가기 http://funnycon.richware.co.kr/appStart.php" ;
			$this->sendSMS($str, "010-4220-1597", $this->turiCSPhone) ;

			// http://funnycon.richware.co.kr/action_front.php?cmd=Api.smsTest
		}


		/**
		 * sendSms($sendStr)
		 * add by Dev.Na 2013-01-09
		 * @param $sendStr - 발송할 문구
		 * 
		 * @param $phone - 전화번호		 
		 * */
		function sendSMS($sendStr, $resPhone, $reqPhone){
			
			$sms_id		= "nextplatform" ;
			$sms_passwd	= "turi1797" ;
			$sms_type	= "L" ;
			$sms_to		= $resPhone ;
			$sms_from	= $reqPhone ;
			$sms_date	= "0" ;
			$sms_msg	= $sendStr ;

			if($resPhone == "" && $resPhone == "")
			{
				$logData = "Api : sendSMS // reqPhone : {$reqPhone} //resPhone : {$resPhone} // 발송실패";
				$this->writeFileLog($logData, 'smsLog');
				return false;
			}
			
			$sms = new EmmaSMS();
				
			$sms->login($sms_id, $sms_passwd);

			$ret = $sms->send($sms_to, $sms_from, $sms_msg, $sms_date, $sms_type);

			if($ret)
			{
				$smsInfo	= json_encode($ret);
				$retunrVal	= true;
				$returnMsg	= "Success";
			}
			else
			{
				$smsInfo	= "";
				$retunrVal	= false;
				$returnMsg	= $sms->errMsg;
			}

			$logData = "Api : sendSMS // reqPhone : {$reqPhone} //resPhone : {$resPhone} // 메세지 : {$sendStr} // 발송여부 : {$returnMsg} // 잔여정보 : {$smsInfo}";
			$this->writeFileLog($logData, 'smsLog');
				
			return $retunrVal;
		}
















		
	}//클래스 종료
}
?>