<?php
require_once (__DIR__ . "/../config.php");

require (INCLUDES_PATH . "/login_action.php");
?>

<form id="login_form" action="login.php" method="post" />
	<h1 id="title">Login</h1>
	
	<div class="form_row" id="login_username_row">
		<div class="form_row_icon" id="login_username_icon">test</div><!--
		--><input id="login_username" name="username" type="text" value="" placeholder="Username" />
	</div>
	<div class="form_row" id="login_password_row">
		<div class="form_row_icon" id="login_password_icon">test</div><!--
		--><input id="login_password" name="password" type="password" value="" placeholder="Password" />
	</div>
		
	<button id="submit" type="submit">Submit</button>
</form>
