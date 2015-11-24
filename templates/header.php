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
	<header id="pagetop" />
	<h1 id="title">Event Manager</h1>
	<nav>
		<ul id="menuoptions">
			<?php
			if (isUserLoggedIn ()) {
				?>
			<a href="#"><li>My events</li></a>
			<a href="create_event.php"><li>Create event</li></a>
			<a href="#"><li>Search events</li></a>
			<a href="logout.php"><li>Logout</li></a>
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