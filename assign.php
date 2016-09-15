<?php
 // this is the page that will do the random assignments.
 // remove false when ready to do the assignment
if($_GET["pass"] == "forrealz" && false){

include("/not-in-webroot/db_settings.php");
$mysqli = new mysqli("localhost", $db_user, $db_pass, $db_db);
unset ($db_user, $db_pass, $db_db);
if ($mysqli->connect_errno) {
	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

$res = $mysqli->query("SELECT id FROM users");

for ($row_num = 0; $row_num < $res->num_rows; $row_num++){
	$giftee[] = -1;
}
$res->data_seek(0);
while ($row = $res->fetch_assoc()) {
    $id = $row['id'];
	$stmt = $mysqli->stmt_init();
	if($stmt->prepare("SELECT exclude FROM exclusions where user_id=?")){
		$stmt->bind_param("s",$id);
		$stmt->execute();
		$stmt->bind_result($exclusion);
		while($stmt->fetch()){
			$exclusions[] = $exclusion;
		}
		for($index = 0; $index < count($giftee); $index++){
			if($giftee[$index] > -1){
				$exclusions[] = $giftee[$index];
			}
		}
		for($index = 0; $index < count($giftee); $index++){
			if(!in_array($index, $exclusions)){
				$selector[] = $index;
			}
		}
		$giftee[$id] = $selector[array_rand($selector, 1)];
		unset($exclusions);
		unset($selector);
	}
}

for($index = 0; $index < count($giftee); $index++){
	$query = "INSERT INTO secret_santa (user_id, giftee, year) VALUES (?,?,2016)";
    $stmt = $mysqli->prepare($query);
    $stmt ->bind_param("ss", $index, $giftee[$index]);
    $stmt->execute();
    $stmt->close();
}

$res->close();
$mysqli->close();

echo "assignment completed";
}
?>
