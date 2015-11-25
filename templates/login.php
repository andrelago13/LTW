<?php
require_once (__DIR__ . "/../config.php");

require (INCLUDES_PATH . "/login_action.php");
?>

<form id="login_form" action="login.php" method="post" />
	<h1 id="title">Login</h1>
	<input id="custom_us" type="text" value="" placeholder="Username" id="username" />
	<input id="custom_pw" type="password" value="" placeholder="Password" id="password" />
	<button id="submit" type="submit">Submit</button>
</form>