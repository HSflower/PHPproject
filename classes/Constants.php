<?php
if(! class_exists("Constants") )
{
	class Constants 
	{

		// XML URL 
		var $datasheetPath		= "/common/xml/datasheet.xml" ;
	
		/* 개발서버 */
		var $fileSavePath			= "/home/itsupply/upload_img/" ;
		var $excelSavePath			= "/home/hosting_users/itsupply/www/upload_excel/" ;
		var $fileSavePath_720		= "/home/itsupply/720/" ;				// linux 경로
		var $fileSavePath_640		= "/home/itsupply/640/" ;				// linux 경로
		var $fileSavePath_480		= "/home/itsupply/480/" ;				// linux 경로
		var $fileSavePath_320		= "/home/itsupply/320/" ;				// linux 경로
		var $fileSavePath_100		= "/home/itsupply/100/" ;				// linux 경로
		var $agreeInfoPath			= "/home/itsupply/setting/agree.txt";	// 이용약관 파일 경로
		var $privacyInfoPath		= "/home/itsupply/setting/privacy.txt";	// 개인정보취급방침 파일 경로
		var $payAttentionInfoPath	= "/home/itsupply/setting/pay_attention.txt";	// 결제시 유의사항
		

		var $logPath		= "/home/itsupply/log/" ;	// simple 로그기록
		var $documentRoot	= "/home/itsupply/" ;	// simple 로그기록
		var $webRoot		= "http://itsupply.cafe24.com" ;			
		var $con_domain		= "http://itsupply.cafe24.com" ;	// 메일에서 사용되는 도메인
		
		
		/* 운영서버
		var $fileSavePath = "/home/turi/upload_img/" ;
		var $fileSavePath_480 = "/home/turi/480/" ;				// linux 경로
		var $fileSavePath_100 = "/home/turi/100/" ;				// linux 경로	
		var $logPath = "/www/turi/log/" ;	// simple 로그기록
		var $documentRoot = "/www/turi/" ;	// simple 로그기록
		var $webRoot = "http://showdownserver.co.kr" ;			
		var $con_domain = "http://showdownserver.co.kr" ;	// 메일에서 사용되는 도메인
		var $dbHost = "14.63.215.114" ;
		var $mTwelveBaseUrl = "http://web6.m12.co.kr:12101/app/";	//M12연동 base URL
		*/

		var $dbHost				= "localhost" ;
		var $fileSaveUrl		= "/upload_img/" ;
		var $fileSaveUrl_480	= "/480/" ;

		var $dbName		= "itsupply" ;
		var $dbUser		= "itsupply" ;
		var $dbPass		= "toltol2199**" ;
		var $charset	= "utf8" ;
				
	}
}
?>