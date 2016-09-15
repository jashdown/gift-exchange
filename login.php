<?php
include("/not-in-webroot/db_settings.php");
$mysqli = new mysqli("localhost", $db_user, $db_pass, $db_db);
unset ($db_user, $db_pass, $db_db);
if ($mysqli->connect_errno) {
	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

$name = $mysqli->real_escape_string(strtoupper($_GET["name"]));
$pass = $_GET["password"];

$person = (object) array('name' => '', 'id' => '', 'giftee' => '', 'loggedin' => 'false');

$stmt = $mysqli->stmt_init();
if($stmt->prepare("SELECT password, id FROM users where UPPER(name)=?")){
	$stmt->bind_param("s",$name);
	$stmt->execute();
	$stmt->bind_result($dbpass,$id);
	while($stmt->fetch()){
		if($dbpass == $pass){
			$person->loggedin = 'true';
			$person->name = $name;
			$person->id = $id;
			if($stmt->prepare("SELECT name FROM users WHERE id=(SELECT giftee FROM secret_santa where user_id=? and year=2016)")){
				$stmt->bind_param("s",$person->id);
				$stmt->execute();
				$stmt->bind_result($giftee);
				while($stmt->fetch()){
					$person->giftee = $giftee;
				}
				$stmt->close();
			}
		}
	}
	$stmt->close();
}


$mysqli->close();
echo json_encode($person);
?>
