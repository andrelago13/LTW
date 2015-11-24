<?php
require_once (__DIR__ . "/../config.php");

require_once (INCLUDES_PATH . "/authentication.php");
?>

<form class="register_form" id="register_form" action="login.php" method="post" autocomplete="off" />
	<h1 id="title">Register</h1>
	<input id="name" type="text" value="" placeholder="Name" id="name" autocomplete="off" />
	<input id="email" type="text" value="" placeholder="Email" id="email" autocomplete="off"/>
	<input id="username" type="text" value="" placeholder="Username" id="username" autocomplete="off" />
	<input id="password" type="password" value="" placeholder="Password" id="password" autocomplete="off" />
	<button id="submit" type="submit">Submit</button>
</form>