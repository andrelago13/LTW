<?php
require_once (__DIR__ . "/../config.php");
require_once (INCLUDES_PATH . "/authentication.php");
?>

<form action="action_login.php" method="post" />
<div class="username">
	<label for="username">Username:</label> <input type="text"
		name="username" id="username">
</div>
<div class="password">
	<label for="password">Password:</label> <input type="text"
		name="password" id="password">
</div>
<div class="submit_btn">
	<button type="submit">Submit</button>
</div>
</form>