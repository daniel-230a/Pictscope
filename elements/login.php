<?php
	session_start();
	include_once "db.php";

	$username = $conn->real_escape_string($_POST['username']);
	$password = $conn->real_escape_string($_POST['password']);


	$login = $conn->query("SELECT * FROM accounts WHERE username='$username'");
	$account = $login->fetch_assoc();

	if (empty($username) || empty($password)) {
		echo "All fields are mandatory!";
	}	else if ($login->num_rows == 0) {
			echo "This account doesn't exist. try again.";
	} else {
			if (password_verify($password, $account['password'])) {
				$_SESSION['fullname'] = $account['fullname'];
				$_SESSION['username'] = $account['username'];
				echo "success";
			} else {
					echo "The password you have entered is incorrect. try again.";
			}
	}

?>
