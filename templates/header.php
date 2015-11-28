<?php
require_once (__DIR__ . "/../config.php");
require_once (INCLUDES_PATH . "/authentication.php");
require_once (INCLUDES_PATH . "/menu.php");
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
<script src="scripts/main.js"></script>
</head>
<body>
	<header id="pagetop">
		<h1 id="title">Event Manager</h1>
		<nav>
			<ul id="menuoptions">
			<?php
			$menuPages = getMenuPages ();
			foreach ( $menuPages as $url => $name ) {
				echo '<li';
				if (basename ( $_SERVER ['PHP_SELF'] ) === $url)
					echo ' class="active"';
				echo '><a href="' . $url . '">' . $name . '</a></li>';
			}
			?>
		</ul>
		</nav>
		<?php
		if (isUserLoggedIn ()) {
			?>
		<form id="search" action="search_events.php" method="post">
			<input type="text" name="query" placeholder="Search event"
				<?php if (isset($_POST["query"])) echo ' value="' . $_POST['query'] . '"'; ?> />
			<button id="submit" type="submit">Go!</button>
		</form>
			<?php
		}
		?>
	</header>
<?php
?>
