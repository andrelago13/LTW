<?php
require_once (__DIR__ . "/../config.php");

require_once (INCLUDES_PATH . "/authentication.php");
?>

<form class="register_form" id="register_form" action="login.php" method="post" autocomplete="off" />
	<h1 id="title">Register</h1>
	<input id="reg_name" type="text" value="" placeholder="Name" autocomplete="off" />
	<input id="reg_email" type="text" value="" placeholder="Email" autocomplete="off"/>
	<input id="reg_username" type="text" value="" placeholder="Username" autocomplete="off" />
	<input id="reg_password" type="password" value="" placeholder="Password" autocomplete="off" />
	<button id="submit" type="submit">Submit</button>
</form>