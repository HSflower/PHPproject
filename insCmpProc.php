<?

if(empty($_POST['submitC']))
{
	echo "Form is not submitted!!";
	exit;
}

if(empty($_POST["id"]) || empty($_POST["pw"]) )
{
	echo "Please fiill the form";
	exit;
}

$id			= $_POST["id"];
$pw			= $_POST["pw"];
$cName		= $_POST["cName"];
$rName		= $_POST["rName"];
$email		= $_POST["email"];
$phone		= $_POST["phone"];
$dlvTime	= $_POST["dlvTime"];
$cNote		= $_POST["note"];
$adDstr		= $_POST["adDstr"];
$name 			= "seul";
$email 			= "2983rgt@gmail.com";
$ctgr 			= $_POST["ctgr"];

mail ( '2983rgt@naver.com' , 'new form submission' , 
	"New form submission : 
	Name: $name, Email: $email" );

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

	$sql = "INSERT INTO tblCompany (quotaNumber,cID, cPW, cName, rName, email, phone, dlvTime, cNote, admDstr)
	VALUES ('0', '{$id}','{$pw}', '{$cName}', '{$rName}', '{$email}', '{$phone}', '{$dlvTime}', '{$cNote}', '{$adDstr}' )";

	if ($db->query($sql) === TRUE) {
	    echo "New record created successfully";
	} else {
	    echo "Error: " . $sql . "<br>" . $db->error;
	}

	//Example (MySQLi Procedural)
	mysqli_close($db);  

header('Location: write.html#companyenrolling');

?>