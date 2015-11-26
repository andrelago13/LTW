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
<link href='https://fonts.googleapis.com/css?family=Raleway'
	rel='stylesheet' type='text/css'>
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
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
				<li><a href="logout.php">Logout</a></li>
			<?php
			} else {
				?>
			<li><a href="login.php">Login</a></li>
				<li><a href="register.php">Register</a></li>
				<?php
			}
			?>
		</ul>
		</nav>
		<?php
		if (isUserLoggedIn ()) {
			?>
		<form id="search" action="search_events.php" method="get">
			<input type="text" name="query" placeholder="Search event"<?php if (isset($_GET["query"])) echo ' value="' . $_GET['query'] . '"'; ?> /> <input
				type="submit" value=">" />
		</form>
			<?php
		}
		?>
	</header>
<?php
?>