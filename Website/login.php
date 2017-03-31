<?php

if(isset($_POST["username"], $_POST["password"]))
{

        $conn = new mysqli("localhost", "jamie", "3parj9Ld5Rs18", "bikepanda");

        if (mysqli_connect_errno()) {
		die("Connection failed: " . mysqli_connect_error());
        }

        if($stmt1 = $conn->prepare("SELECT password FROM users WHERE username=?")) {
                $stmt1->bind_param("s", $username);
        } else {
                die("Prepared statement failed failed: " . $conn->error_list);
        }

	if($stmt2 = $conn->prepare("SELECT password FROM users WHERE email=?")) {
                $stmt2->bind_param("s", $username);
        } else {
                die("Prepared statement failed failed: " . $conn->error_list);
        }

        $username = $_POST["username"];

        if (!$stmt1->execute()) {
		die("Execute failed: (" . $stmt1->errno . ") " . $stmt1->error);
        }
	

	$stmt1->bind_result($user_password1);


	$verify1 = $verify2 = "";
	while ($stmt1->fetch()) {
		$verify1 = password_verify($_POST["password"], $user_password1);
        }

	$stmt1->close();
	
	$stmt2->bind_result($user_password2);

        if (!$stmt2->execute()) {
                die("Execute failed: (" . $stmt2->errno . ") " . $stmt2->error);
        }

	while ($stmt2->fetch()) {
                $verify2 = password_verify($_POST["password"], $user_password2);
        }

	$stmt2->close();
	$conn->close();

	if ($verify1 || $verify2) {
		session_start();
		$_SESSION["id"]=$username;
		header( 'Location: ./progress.php' );
	} else {
		header( 'Location: ./login.html' );	
	}
} else {
	header( 'Location: ./login.html' );
}
?>
