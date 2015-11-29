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
	
	echo '<div class="user_profile">';
	echo '<h1 id="title">User Profile</h1>';
	
	echo '<p id="name"><strong>Name:</strong> ' . $user ["name"] . '</p>';
	if ($canEdit)
		echo '<a href="" class="edit" id="edit_name"><img src="images/edit_field.png" alt="Edit" /></a>';
	
	echo '<p id="username"><strong>Username:</strong> ' . $user ["username"] . '</p>';
	if ($canEdit)
		echo '<a href="" class="edit" id="edit_name"><img src="images/edit_field.png" alt="Edit" /></a>';
	
	echo '<p id="email"><strong>Email:</strong> <a href="mailto:' . $user["email"] . '">' . $user ["email"] . '</a></p>';
	if ($canEdit)
		echo '<a href="" class="edit" id="edit_name"><img src="images/edit_field.png" alt="Edit" /></a>';
	echo '</div>';
}
?>
<script src="scripts/user.js"></script>