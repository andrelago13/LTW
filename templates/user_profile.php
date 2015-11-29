<?php
require_once (__DIR__ . "/../config.php");
require_once (INCLUDES_PATH . "/authentication.php");
require_once (TEMPLATES_PATH . "/utils.php");
require_once (DATABASE_PATH . "/user.php");

$canEdit = false;
if (isset ( $_GET ["id"] )) {
	$idUser = $_GET ["id"];
} else {
	if (isUserLoggedIn ())
		$idUser = getUserID ();
	else
		showError ( "Missing user ID." );
}
if (isset ( $idUser )) {
	$user = getUser ( $idUser );
	$canEdit = (isUserLoggedIn () && $idUser === getUserID ());
	
	echo '<div class="user_profile" id="user' . $user['id'] . '">';
	echo '<h1 id="title">User Profile</h1>';
	
	echo '<p class="name">';
	echo '<strong>Name:</strong>&nbsp';
	echo '<span id="name">' . $user ["name"] . '</span>';
	if ($canEdit)
		echo '<a href="" class="edit" id="edit_name"><img src="images/edit_field.png" alt="Edit" /></a>';
	echo '</p>';
	
	echo '<p class="username">';
	echo '<strong>Username:</strong>&nbsp';
	echo '<span id="username">' . $user ["username"] . '</span>';
	if ($canEdit)
		echo '<a href="" class="edit" id="edit_username"><img src="images/edit_field.png" alt="Edit" /></a>';
	echo '</p>';
	
	echo '<p class="email">';
	echo '<strong>Email:</strong>&nbsp';
	echo '<span>';
	echo '<a id="email" href="mailto:' . $user ["email"] . '">' . $user ["email"] . '</a>';
	if ($canEdit)
		echo '<a href="" class="edit" id="edit_email"><img src="images/edit_field.png" alt="Edit" /></a>';
	echo '</span></p>';
	
	echo '</div>';
}
?>
<script src="scripts/signup.js"></script>
<script src="scripts/user.js"></script>