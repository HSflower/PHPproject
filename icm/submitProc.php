<?

if(empty($_POST['submitQ']))
{
	echo "Form is not submitted!";
	exit;
}

if(empty($_POST["deliverTime"]) || empty($_POST["addrs"]) )
{
	echo "Please fill the form";
	exit;
}

$insDT			= $_POST["insDT"];
$clsDT			= $_POST["clsDT"];
$addrs			= $_POST["addrs"];
$deliverTime	= $_POST["deliverTime"];
$adDstr			= $_POST["adDstr"];
$note			= $_POST["note"];
//$pic			= $_POST["pic"];
$name 			= "seul";
$email 			= "29283rgt@gmail.com";
$cName			= $_POST["cName"];
$ctgr 			= $_POST["ctgr"];

//mail ( '2983rgt@naver.com' , 'new form submission' , "New form submission : Name: $name, Email: $email" );

$servername = "localhost";
$dbName		= "buyrunicm" ;
$username 	= "buyrunicm";
$password 	= "toltol2199**";
$charset	= "utf8" ;

$db = mysqli_connect($servername, $username, $password, $dbName); //db connection
	//var $result ;			//result set
$debug = true ;		//is debug??

	// Check connection
	 if ($db->connect_error) {
	     die("Connection failed: " . $db->connect_error);
	} 
	echo "Connected successfully";

	$sql = "INSERT INTO tblQuota (userNumber, cName, registDT, category, clsDT, adDstr, qNote, addrs, reqTime)
	VALUES ('0', '{$cName}', '{$insDT}', '{$ctgr}', '{$clsDT}', '{$adDstr}', '{$note}', '{$addrs}', '{$deliverTime}' )";

	if ($db->query($sql) === TRUE) {
	    echo "New record created successfully<br>";
	} else {
	    echo "Error: " . $sql . "<br>" . $db->error;
	}

	//Example (MySQLi Procedural)
	mysqli_close($db);  
//history.back();

/*
$valid_formats = array("jpg", "png", "gif", "zip", "bmp");
$max_file_size = 1024*100; //100 kb
$path = "upload_quopic/"; // Upload directory
$count = 0;
//$f = $_FILES['quotaImg']['name'][$count];
if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){
    // Loop $_FILES to execute all files
    foreach ($_FILES['quotaImg']['name'] as $key => $name) {     
        if ($_FILES['quotaImg']['error'][$f] == 4) {
            continue; // Skip file if any error found
        }          
        if ($_FILES['quotaImg']['error'][$f] == 0) {              
            if ($_FILES['quotaImg']['size'][$f] > $max_file_size) {
                $message[] = "$name is too large!.";
                continue; // Skip large files
            }
            elseif( ! in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats) ){
                $message[] = "$name is not a valid format";
                continue; // Skip invalid file formats
            }
            else{ // No error found! Move uploaded files 
                if(move_uploaded_file($_FILES["quotaImg"]["tmp_name"][$f], $path.$name)) {
                    $count++; // Number of successfully uploaded files
                }
            }
        }
    }
}
*/

/*
fixFilesArray($_FILES['quotaImg']);
var_dump($_FILES['quotaImg']);
function fixFilesArray(&$files){
    // a mapping of $_FILES indices for validity checking
    $names = array('name' => 1, 'type' => 1, 'tmp_name' => 1, 'error' => 1, 'size' => 1);
    // iterate over each uploaded file
    foreach ($files as $key => $part) {
        // only deal with valid keys and multiple files
        $key = (string) $key;
        if (isset($names[$key]) && is_array($part)) {
            foreach ($part as $position => $value) {
                $files[$position][$key] = $value;
            }
            // remove old key reference
            unset($files[$key]);
        }
    }
}
*/


if(isset($_FILES['quotaImg'])){
    $name_array = $_FILES['quotaImg']['name'];
    $tmp_name_array = $_FILES['quotaImg']['tmp_name'];
    $type_array = $_FILES['quotaImg']['type'];
    $size_array = $_FILES['quotaImg']['size'];
    $error_array = $_FILES['quotaImg']['error'];
    print_r($name_array);
    for($i = 0; $i < count($tmp_name_array); $i++){
        if(move_uploaded_file($tmp_name_array[$i], "upload_quopic/".$name_array[$i]) ){
            echo $name_array[$i]." upload is complete<br>";
        } else {
            echo "<br>move_uploaded_file function failed for ".$name_array[$i]."<br>";
        }
    }
}


/*
$uploads_dir = '/upload_quopic';
foreach ($_FILES["quotaImg"]["error"] as $key => $error) {
    if ($error == UPLOAD_ERR_OK) {
        $tmp_name = $_FILES["quotaImg"]["tmp_name"][$key];
        $name = $_FILES["quotaImg"]["name"][$key];
        move_uploaded_file($tmp_name, "$uploads_dir/$name");
    }
}
*/

/*
$valid_formats = array("jpg", "png", "gif", "zip", "bmp");
$max_file_size = 1024*100; //100 kb
$path = "upload_quopic/"; // Upload directory
$count = 0;

if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){
    // Loop $_FILES to exeicute all files
    foreach ($_FILES['quotaImg']['name'] as $f => $name) {     
        if ($_FILES['quotaImg']['error'][$f] == 4) {
            continue; // Skip file if any error found
        }          
        if ($_FILES['quotaImg']['error'][$f] == 0) {              
            if ($_FILES['quotaImg']['size'][$f] > $max_file_size) {
                $message[] = "$name is too large!.";
                continue; // Skip large files
            }
            elseif( ! in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats) ){
                $message[] = "$name is not a valid format";
                continue; // Skip invalid file formats
            }
            else{ // No error found! Move uploaded files 
                if(move_uploaded_file($_FILES["quotaImg"]["tmp_name"][$f], $path.$name))
                $count++; // Number of successfully uploaded file
            }
        }
    }
}
*/

/*
//print_r($_FILES["quotaImg"]);
print_r($_FILES);
$count=0;
foreach ($_FILES["quotaImg"]["name"] as $_FILES["quotaImg"]["name"][$count]){

$target_dir = "upload_quopic/";
$target_file = $target_dir . basename($_FILES["quotaImg"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    $tmp_name_array = $_FILES['quotaImg']['tmp_name'];
$i = 0;

echo "<br>" . file_exists($target_dir . $target_file)?"true":"false" . "<br>";

    for( $i=0; $i<count($tmp_name_array)) {
        $i++;
        $target_file = $imageFileType["filename"] . "-" . $i . "." . $imageFileType["extension"];
        echo "file ". basename( $_FILES["quotaImg"]["name"]). " is uploaded.";
    }


// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["quotaImg"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["quotaImg"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["quotaImg"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
$count++;
}
// Check if image file is a actual image or fake image
*/

/*
if(isset($_POST["submitQ"])) {
    $check = getimagesize($_FILES["quotaImg"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
*/

/*
function reArrayFiles(&$file_post) {

    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);

    for ($i=0; $i<$file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }

    return $file_ary;
}
if ($_FILES['quotaImg']) {
    $file_ary = reArrayFiles($_FILES['quotaImg']);

    foreach ($file_ary as $file) {
        print 'File Name: ' . $file['name'];
        print 'File Type: ' . $file['type'];
        print 'File Size: ' . $file['size'];

	    $target_dir = "upload_quopic/";
		$target_file = $target_dir . basename($file["name"]);
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		$check = getimagesize($file['name']);
		if($check !== false) {
		    echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
	    } else {
	        echo "File is not an image.";
	        $uploadOk = 0;
	    }		
    }
}
*/

/*
define("UPLOAD_DIR", "upload_quopic/");
 
if (!empty($_FILES["myFile"])) {
    $myFile = $_FILES["myFile"];
 
    if ($myFile["error"] !== UPLOAD_ERR_OK) {
        echo "<p>An error occurred.</p>";
        exit;
    }
 
    // ensure a safe filename
    $name = preg_replace("/[^A-Z0-9._-]/i", "_", $myFile["name"]);
 
    // don't overwrite an existing file
    $i = 0;
    $parts = pathinfo($name);
    while (file_exists(UPLOAD_DIR . $name)) {
        $i++;
        $name = $parts["filename"] . "-" . $i . "." . $parts["extension"];

    }
 
    // preserve file from temporary directory
    $success = move_uploaded_file($myFile["tmp_name"],
        UPLOAD_DIR . $name);
    if (!$success) { 
        echo "<p>Unable to save file.</p>";
        exit;
    }
 
    // set proper permissions on the new file
    chmod(UPLOAD_DIR . $name, 0644);
}
*/

	//header('Location: http://buyrunicm.cafe24.com/write.html');
?>