<?php

// login fields cannot be blank
if(isset($_POST["username"], $_POST["password"]))
{

        $conn = new mysqli("localhost", "jamie", "3parj9Ld5Rs18", "bikepanda");

        if (mysqli_connect_errno()) {
					die("Connection failed: " . mysqli_connect_error());
        }

        // Since the form says username OR email, we will compare the password against
        // both entries
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

        // bind the given username to be used in the above prepared statements
        $username = $_POST["username"];

        // execute prepared statement 1
        if (!$stmt1->execute()) {
					die("Execute failed: (" . $stmt1->errno . ") " . $stmt1->error);
        }

				$stmt1->bind_result($user_password1);

				// validate the password against the result from prepared statement 1
				$verify1 = $verify2 = "";
				while ($stmt1->fetch()) {
					$verify1 = password_verify($_POST["password"], $user_password1);
			  }

				$stmt1->close(); // must close the connection in order to execute the next prepared statement

				// execute statement 2
			  if (!$stmt2->execute()) {
						die("Execute failed: (" . $stmt2->errno . ") " . $stmt2->error);
			  }

				// validate the password against the result from prepared statement 2
				$stmt2->bind_result($user_password2);
				while ($stmt2->fetch()) {
			 		 $verify2 = password_verify($_POST["password"], $user_password2);
			  }

			  // close the connection
				$stmt2->close();
				$conn->close();

				// redirect based on result
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
