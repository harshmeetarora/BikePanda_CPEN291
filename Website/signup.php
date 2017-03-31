<?php
session_start();

if(isset($_POST["firstname"], $_POST["lastname"], $_POST["username"], $_POST["email"], $_POST["password"])) 
{     

	$conn = new mysqli("localhost", "jamie", "3parj9Ld5Rs18", "bikepanda");

	if (mysqli_connect_errno()) {
	    die("Connection failed: " . mysqli_connect_error());
	}

	if($stmt = $conn->prepare("INSERT INTO users (first_name, last_name, username, email, password) VALUES (?, ?, ?, ?, ?)")) {
		$stmt->bind_param("sssss", $firstname, $lastname, $username, $email, $password);
	} else {
		die("Prepared statement failed failed: " . $conn->error_list);
	}


	$bcrypt_options = [
	  'cost' => 10
	];
	
	$firstname = trim($_POST["firstname"]);
	$lastname = trim($_POST["lastname"]);
        $username = trim($_POST["username"]); 
	$email = trim($_POST["email"]);
	$password = trim($_POST["password"]);
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT, $bcrypt_options);

	if (!$stmt->execute()) {
	    die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
	}
	
	$stmt->close();
	$conn->close();

	$_SESSION["id"]=$username;
	
	header( 'Location: ./progress.php' );
} else {
	echo "post parameters not set";
}

?>
