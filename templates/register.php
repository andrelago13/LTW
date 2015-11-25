<?php
require_once (__DIR__ . "/../config.php");

require_once (INCLUDES_PATH . "/authentication.php");
?>

<form action="login.php" method="post" />
<div class="name">
	<label for="name">Name:</label> <input type="text" name="name"
		id="name">
</div>
<div class="email">
	<label for="email">Email:</label> <input type="email" name="email"
		id="email">
</div>
<div class="username">
	<label for="username">Username:</label> <input type="text"
		name="username" id="username">
</div>
<div class="password">
	<label for="password">Password:</label> <input type="password"
		name="password" id="password">
</div>
<div class="password">
	<label for="password">Confirm password:</label> <input type="password"
		id="confirm_password">
</div>
<div class="submit_btn">
	<button type="submit">Submit</button>
</div>
</form>