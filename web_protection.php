<?php

error_reporting(0);

session_start();

# Variable

$lock = md5(sha1('password'));                                # Your Chosen Password
$chances = 3;                                                                # Maximum Attempt

# Main Script

$_SESSION['attempt'];

$file = pathinfo($_SERVER['PHP_SELF'])['basename'];

if ($file !== 'web_protection.php') {

	if (!isset($_SESSION['user'])) {

		header('location: web_protection.php');

	}

}

if (isset($_POST['logout'])) {
	
	session_unset();
	session_destroy();

}

if (isset($_POST['unlock'])) {

	$password = htmlspecialchars($_POST['password']);

	if ($_SESSION['attempt'] <= $chances) {

		if (md5(sha1($password)) == $lock) {
			
			$_SESSION['user'] = 'admin';
			header('location: index.php');
			//header('location: web_protection.php');

		} else{

			$_SESSION['attempt'] += 1;

		}

	}

}

if (!isset($_SESSION['user']) and $file !== 'script.php') {

	if ($_SESSION['attempt'] >= $chances) {

		echo '

		<!DOCTYPE html>
		<html>
		<head>
			<title>Locked</title>
			<link rel="stylesheet" type="text/css" href="asset/main.css">
			<meta name="viewport" content="width=device-width,initial-scale=1">
		</head>
		<body>

			<div class="shield_container">

				<form action="" method="POST">

					<p>You are blocked. No more attempts!</p>
				
				</form>

			</div>

			<script>

			if ( window.history.replaceState ) {
			  	window.history.replaceState( null, null, window.location.href );
			}

			</script>

		</body>
		</html>

		';

	} else{

		echo '

			<!DOCTYPE html>
			<html>
			<head>
				<title>Locked</title>
				<link rel="stylesheet" type="text/css" href="asset/main.css">
				<meta name="viewport" content="width=device-width,initial-scale=1">
			</head>
			<body>

				<div class="shield_container">

					<form action="" method="POST">

						<p>Unlock - '. ($chances - $_SESSION['attempt']).' Chances</p>

						<input type="password" name="password" placeholder="Password">
						<button name="unlock">Unlock</button>
					
					</form>

				</div>

			<script>

				if ( window.history.replaceState ) {
				  	window.history.replaceState( null, null, window.location.href );
				}

			</script>

			</body>
			</html>

		';

	}

} elseif (isset($_SESSION['user']) and $file == 'web_protection.php') {
	
	echo '

		<!DOCTYPE html>
		<html>
		<head>
			<title>Locked</title>
			<link rel="stylesheet" type="text/css" href="asset/main.css">
			<meta name="viewport" content="width=device-width,initial-scale=1">
		</head>
		<body>

			<div class="shield_container">

				<form action="" method="POST">

					<p>You have admin access!</p>

					<button name="logout">logout</button>
				
				</form>

			</div>

			<script>

			if ( window.history.replaceState ) {
			  	window.history.replaceState( null, null, window.location.href );
			}

			</script>

		</body>
		</html>

	';

}

?>
