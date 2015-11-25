<?php
require_once (__DIR__ . "/../config.php");

require_once (INCLUDES_PATH . "/authentication.php");
?>

<form class="register_form" id="register_form" action="login.php" method="post" autocomplete="off" />
	<h1 id="title">Register</h1>
	
	<div class="form_row" id="reg_name_row">
		<div class="form_row_icon" id="reg_name_icon">test</div><!-- Este comentário mantém os elementos em linha
		--><input class="register_name" id="reg_name" name="name" type="text" value="" placeholder="Name" />
	</div>
	<div class="form_row" id="reg_email_row">
		<div class="form_row_icon" id="reg_email_icon">test</div><!--
		--><input id="reg_email" name="email" type="text" value="" placeholder="Email" />
	</div>
	<div class="form_row" id="reg_username_row">
		<div class="form_row_icon" id="reg_username_icon">test</div><!--
		--><input id="reg_username" name="username" type="text" value="" placeholder="Username" />
	</div>
	<div class="form_row" id="reg_password_row">
		<div class="form_row_icon" id="reg_password_icon">test</div><!--
		--><input id="reg_password" name="password" type="password" value="" placeholder="Password" />
	</div>
	<div class="form_row" id="reg_password_conf_row">
		<div class="form_row_icon" id="reg_password_conf_icon">test</div><!--
		--><input id="reg_confirm_password" name="confirm_password" type="password" placeholder="Confirm password" />
	</div>
	<button id="submit" type="submit">Submit</button>
</form>
