<?php
require_once (__DIR__ . "/../config.php");

require (INCLUDES_PATH . "/login_action.php");
?>

<form id="login_form" action="login.php" method="post" />
	<h1 id="title">Login</h1>
	<input id="custom_us" name="username" type="text" value="" placeholder="Username" />
	<input id="custom_pw" name="password" type="password" value="" placeholder="Password" />
	<button id="submit" type="submit">Submit</button>
</form>
