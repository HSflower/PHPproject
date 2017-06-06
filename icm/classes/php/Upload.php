<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/constants.php" ; ?>
<?

$cons = new Constants() ;

$_f_name = $_FILES['file']['name'];
$_f_size = $_FILES['file']['size'];
$_f_tmp = $_FILES['file']['tmp_name'];
$_allow = array("jpg", "jpeg", "gif", "png", "bmp");//이 확장자만 허용.
$_path = $cons->fileSavePath ;
$_imgPath = $cons->fileSaveUrl ;

$_mkDate = date("Ymd") ;

if($_f_size > 0){
	
	$_ext = substr($_f_name, -3);
	foreach($_allow as $_ext_a){//확장자검색
		if(strcmp(strtolower($_ext), $_ext_a)==0){
			$_ext_rst = true;
			continue;
		}
	}

	if($_ext_rst === true){//////////제외 확장자가 없다면..
		
		$_mkPath = $_path . $_mkDate . "/" ;

		if( !file_exists($_mkPath) )
		{
			@mkdir($_mkPath,0755) ;
		}

		$_name = "NZ" . str_replace(".","",str_replace(" ","",microtime().rand())) ;
		$_full_name = $_name.".".$_ext ;
		
		move_uploaded_file($_f_tmp, $_mkPath.$_full_name);
		chmod($_mkPath.$_full_name, 0707);

		// 0 : 업로드 로컬 파일명
		// 1 : 업로드 변경 파일명
		// 2 : 업로드 확장자
		// 3 : 업로드 변경 풀파일명
		// 4 : 업로드 풀패스
		echo $_f_name . "|" . $_name . "|" . $_ext . "|" . $_mkDate."/".$_full_name . "|" . $_imgPath.$_mkDate."/".$_full_name ;
	}
}
?>