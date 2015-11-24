<?php
require_once (__DIR__ . "/../config.php");
require_once (INCLUDES_PATH . "/authentication.php");
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Event Manager</title>
<link rel="stylesheet" href="styles/style.css" />
</head>
<body>
	<header id="pagetop">
		<h1 id="title">Event Manager</h1>
		<nav>
			<ul id="menuoptions">
			<?php
			if (isUserLoggedIn ()) {
				?>
			<li><a href="#">My events</a></li>
				<li><a href="create_event.php">Create event</a></li>
				<li><a href="#">Search events</a></li>
				<li><a href="logout.php">Logout</a></li>
			<?php
			} else {
				?>
			<a href="login.php"><li>Login</li></a>
				<a href="register.php"><li>Register</li></a>
				<?php
			}
			?>
		</ul>
		</nav>
	</header>
<?php
?>