<? include $_SERVER["DOCUMENT_ROOT"] . '/common/classes/comm/JSON.php'; ?>
<?php

if(! class_exists("Common") )	{
	

	class Common extends Services_JSON
	{
	
		// EMS 비용		
		var $eng = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z",
					 "A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","(",")","'","/",",");
		
		var $eng2 = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z",
					 "A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","(",")","'","/",","," ",".");
		var $par = array(")");
		var $aCommArea =  Array(288,488,688,888,1088,1288,1488,1688,1888) ;
		var $aComm = Array(48,66,84,102,120,138,156,174,192) ;
		
		// php 배열을 가지고 자바스크립트 배열문자열 생성
		function createArrayFromPhp($arrayNameOfJS,$array)
		{
			$str = "var $arrayNameOfJS = new Array() ;\n" ;
	
			for($i = 0 ; $i < sizeof($array) ; $i ++)
				$str .= $arrayNameOfJS . '[' . $i . '] = "' . $array[$i]  . "\" ;\n" ;
		
			return $str ;
		}	

		// 자바스크립트 연관 배열로 만든다.
		function createAssocFromPhp($arrayNameOfJS,$assoc)
		{
			$str = "var $arrayNameOfJS = new Array() ;\n" ;
	
			foreach($assoc as $key => $value )
			{
				$value = str_replace("'","\'",$value) ;
				$value = str_replace("\r\n","\\n",$value) ;
				$value = str_replace("\r\n","\\n",$value) ;

				$str .= $arrayNameOfJS . "['" . $key . "'] = '" . $value . "'  ; \n" ;
			}

			return $str ;
		}

		// 연관 배열을 자바스크립트 형식의 변수 표현의 문자열로 변화한다.
		function createVarFromAssoc($assoc)
		{
			$str = "" ;

			foreach($assoc as $key => $value )
			{
				$str .= "var " . $key . " = '" . $value  . "';\n" ;
			}

			return $str ;
		}

		// 연관 배열을 자바스크립트 Array형식(sParam)의 변수 표현의 문자열로 변화한다.
		function createObjectFromAssoc($assoc)
		{
			$str = "var sParam = {};\n" ;

			foreach($assoc as $key => $value )
			{
				$str .= "sParam['" . $key . "'] = '" . $value  . "';\n" ;
			}

			return $str ;
		}

		// 연관 배열을 자바스크립트 Array형식(sParam)의 변수 표현의 문자열로 변화한다.
		function createObjectFromOrder()
		{
			$str = "var sOrder = {};\n" ;
			$arrOrder = $this->arrOrder ;

			foreach( $arrOrder as $key => $value )
			{
				$str .= "sOrder['" . $key . "'] = {" ;
				$str .= "'title':'" . $value["title"] . "'," ;
				$str .= "'color':'" . $value["color"] . "'," ;
				$str .= "'detail':[" ;
				
				foreach( $value["detail"] as $dKey => $dValue )
					$str .= "{'" . $dKey . "':'" . $dValue . "'}," ;

				$str = substr($str,0,strlen($str)-1) ;

				$str .= "]};\n" ;
			}

			return $str ;
		}


		// str : 오리지날 변수, spl : split 할 구분자, idx : 몇번째 index를 리턴할것인가
		function toReply($str, $spl, $idx)
		{
			$retVal = "" ;

			if(stristr($str,$spl) != false){
				$strArr = explode($spl,$str) ;
				$retVal = $strArr[$idx] ;
			}

			return $retVal ;
		}
	 
		//문자열 자르기 함수
		function trimStr($title,$trim) 
		{ 
			$title = strip_tags($title); 
			$titleLen = strlen($title); 

			$trimLen = strlen(substr($title,0,$trim));	//문자열을 자름 

			//만약 문자열이 자를 문자열보다 작으며 자르지 않음 
			if($titleLen > $trimLen) 
			{ 
				for($i=0 ; $i < $trimLen ; $i ++) 
				{ 
					$tmp = ord(substr($title, $i, 1)) ; 

					//127보다 크면 한글로 가준하여 2바이트씩 자름 
					if( $tmp > 127 ) { 	$i ++ ; } 
				} 

				$title = ( $tmp > 127 ) ? substr($title , 0 , $i) . "..." : substr($title , 0 , $i) ; 
			} 

			return $title; 
		}

		function getStatus($status)
		{
			$bStatus = floor($status / 10) ;
			$arrStatus = $this->arrOrder[$bStatus] ;
			return "<FONT COLOR='".$arrStatus["color"]."'>" . $arrStatus["detail"][$status] . "</FONT>" ;
//			return $bStatus ;
		}

		// 디버깅용 자바스크립트 alert 출력
		function alert($msg)
		{
			echo "<script> alert('" . $msg . "');</script>" ;
		}


		//최대치에 따른 이미지 비율로 축대확소.
		function getRatioImage($url, $maxSize, $class)
		{

			$webPath = $_SERVER["DOCUMENT_ROOT"] . str_replace("%2F", "/", rawurlencode($url)) ;

			list($imgWidth,$imgHeight) = @getimagesize($webPath);

			$isExistImage = ( $imgWidth > 0 && $imgHeight > 0 ) ;

			
			$addClass = ( $class != "" ) ? ("class='".$class."'") : "" ;
				
			
			if( $isExistImage )
			{
				$isHorizontal = ( $imgWidth > $imgHeight ) ;
				$ratio = $maxSize / ( ( $isHorizontal ) ? $imgWidth : $imgHeight ) ;
				$imgTag = "<img src='".$url."' width='". ($imgWidth*$ratio) ."' height='". ($imgHeight*$ratio)."' ".$addClass."/>" ;
			}
			else
			{
				$imgTag = "" ;
			}

			return $imgTag ;

		}


		/**
		* cut string in utf-8
		* @author gony (http://mygony.com)
		* @param $str     source string
		* @param $len     cut length
		* @param $checkmb if this argument is true, the function treats multibyte character as two bytes. default value is false.
		* @param $tail    abbreviation symbol
		* @return string  processed string
		*/
		function strcut_utf8($str, $len, $checkmb=false, $tail='...') {
			preg_match_all('/[\xEA-\xED][\x80-\xFF]{2}|./', $str, $match);
		 
			$m    = $match[0];
			$slen = strlen($str);  // length of source string
			$tlen = strlen($tail); // length of tail string
			$mlen = count($m); // length of matched characters
		 
			if ($slen <= $len) return $str;
			if (!$checkmb && $mlen <= $len) return $str;
		 
			$ret   = array();
			$count = 0;
		 
			for ($i=0; $i < $len; $i++) {
				$count += ($checkmb && strlen($m[$i]) > 1)?2:1;
		 
				if ($count + $tlen > $len) break;
				$ret[] = $m[$i];
			}
		 
			return join('', $ret).$tail;
		}

		
		function getToday(){
			return date("Ymd",mktime());
		}


		function simpleFileLog($logData)
		{
			$today = $this->getToday() ;

			$fileDirectory = $this->logPath ;

			if(is_dir ($fileDirectory)!=true){
				mkdir($fileDirectory);
			}

			if(is_dir($fileDirectory.$today)!=true){
				mkdir($fileDirectory.$today);
			}


			$fileName = $today.".txt";

			$fPath = $fileDirectory.$today."/".$fileName;
			
			$fp = fopen($fPath,"a+");
			 
			//파일에 쓰는부분 . 

			fwrite($fp,"log Date : ".$today. " // " . $logData . "\n");
			fwrite($fp,"============================================================================\n");


			//파일 쓰기 끝 닫기

			fclose($fp);
		}


		function writeFileLog($logData, $foldor)
		{
			$today = $this->getToday() ;
			$month = date('Ym', time());

			$fileDirectory = $this->logPath.$foldor."/" ;

			if(is_dir ($fileDirectory)!=true){
				mkdir($fileDirectory);
			}

			if(is_dir($fileDirectory.$month)!=true){
				mkdir($fileDirectory.$month);
			}

			$fileName = $today.".txt";

			$fPath = $fileDirectory.$month."/".$fileName;
			
			$fp = fopen($fPath,"a+");
			 
			//파일에 쓰는부분 . 

			fwrite($fp,"log Date : ".$today. "\r\n" . $logData . "\r\n");
			fwrite($fp,"============================================================================\r\n");


			//파일 쓰기 끝 닫기

			fclose($fp);
		}
		

		function getDateFormat($date, $flag)
		{
			$ret = "" ;

			$dateArr = explode(" ", $date) ;

			if($flag == "1")		// date
			{
				$ret = $dateArr[0] ;
			
			}
			else if($flag == "2")	// hour
			{
				$ret = substr($dateArr[1],0,2) ;
			}
			else if($flag == "3")	// minut
			{
				$ret = substr($dateArr[1],3,2) ;			
			}

			return $ret ;
		}

		

	}	
}
?>