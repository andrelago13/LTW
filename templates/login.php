<?php
require_once (__DIR__ . "/../config.php");

require (INCLUDES_PATH . "/login_action.php");
?>

<form action="login.php" method="post" />
<div class="username">
	<label for="username">Username:</label> <input type="text"
		name="username" id="username" value="gtugablue">
</div>
<div class="password">
	<label for="password">Password:</label> <input type="password"
		name="password" id="password" value="123456">
</div>
<div class="submit_btn">
	<button type="submit">Submit</button>
</div>
</form>