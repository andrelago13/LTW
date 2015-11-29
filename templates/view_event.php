<?php
require_once (__DIR__ . "/../config.php");
require_once (TEMPLATES_PATH . "/utils.php");
require_once (INCLUDES_PATH . "/authentication.php");
require_once (INCLUDES_PATH . "/events.php");
require_once (DATABASE_PATH . "/events.php");

try {
	if (! isset ( $_GET ["id"] )) {
		http_response_code ( 400 );
		showError ( 'Missing event ID.' );
	} else if (! isUserLoggedIn ()) {
		http_response_code ( 403 );
		showError ( 'You need to login to view this event.' );
	} else if (! canSeeEvent ( $_SESSION ["userid"], $_GET ["id"] )) {
		http_response_code ( 403 );
		showError ( 'You do not have access to this event.' );
	} else {
		$idEvent = $_GET ["id"];
		$event = getEvent ( $idEvent );
		echo '<div class="event" id="event' . $idEvent . '">';
		echo '<a href="delete_event.php?id=' . $idEvent . '" class="delete" id="delete_event"><img src="" alt="Delete Event" /></a>';
		echo '<h1 id="name">' . htmlspecialchars ( $event ["name"] ) . '</h1>';
		echo '<a href="" class="edit" id="edit_name"><img src="images/edit_field.png" alt="Edit" /></a>';
		echo '<div class="container">';
		echo '<img id="image" src="database/event_image.php?id=' . $idEvent . '" alt="' . htmlspecialchars ( $event ["name"] ) . '" width="256" height="256" />';
		echo '<p id="description">' . preg_replace("/\n/", "<br />", htmlspecialchars ( $event ["description"] )) . '</p>';
		echo '<a href="" class="edit" id="edit_description"><img src="images/edit_field.png" alt="Edit" /></a>';
		echo '</div>';
		echo '<datetime id="date">' . htmlspecialchars ( $event ["date"] ) . '</datetime>';
		echo '<a href="" class="edit" id="edit_date"><img src="images/edit_field.png" alt="Edit" /></a>';
	
		echo '<div class="comment_area">';
		echo '<form class="write_comment_form" id="write_comment" action="login.php" method="post">';
		echo '<textarea name="text" id="text" required placeholder="Comment..." maxlength="500"></textarea>';
		echo '<button id="submit" type="submit">Add comment</button>';
		echo '</form>';
		
		echo '<div class="comment_container">';
		echo '<h2 id="title">Comments:</h2>';
		echo '<div class="comment">';
		echo '<h3 id="user">Cristiano Ronaldo</h3>';
		echo '<p id="text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec efficitur, libero ac faucibus tincidunt, urna urna tincidunt enim, sit amet congue nunc magna at est. Nam rhoncus dignissim orci eget fermentum. Proin ultrices dignissim vestibulum. Suspendisse porttitor pellentesque suscipit. Fusce sodales, nisl et pretium rutrum, urna nunc egestas nulla, vitae imperdiet erat diam sit amet metus. Suspendisse po</p>';
		echo '<h4 id="time">2014/02/02 22:22</h4>';
		echo '</div>';
		echo '<div class="comment">';
		echo '<h3 id="user">Cristiano Ronaldo</h3>';
		echo '<p id="text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec efficitur, libero ac faucibus tincidunt, urna urna tincidunt enim, sit amet congue nunc magna at est. Nam rhoncus dignissim orci eget fermentum. Proin ultrices dignissim vestibulum. Suspendisse porttitor pellentesque suscipit. Fusce sodales, nisl et pretium rutrum, urna nunc egestas nulla, vitae imperdiet erat diam sit amet metus. Suspendisse po</p>';
		echo '<h4 id="time">2014/02/02 22:22</h4>';
		echo '</div>';
		echo '<div class="comment">';
		echo '<h3 id="user">Cristiano Ronaldo</h3>';
		echo '<p id="text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec efficitur, libero ac faucibus tincidunt, urna urna tincidunt enim, sit amet congue nunc magna at est. Nam rhoncus dignissim orci eget fermentum. Proin ultrices dignissim vestibulum. Suspendisse porttitor pellentesque suscipit. Fusce sodales, nisl et pretium rutrum, urna nunc egestas nulla, vitae imperdiet erat diam sit amet metus. Suspendisse po</p>';
		echo '<h4 id="time">2014/02/02 22:22</h4>';
		echo '</div>';
		echo '</div>';
		echo '</div>';
		echo '</div>';
	}
} catch ( Exception $e ) {
	showError ( $e->getMessage () );
}
?>
<script src="scripts/event.js"></script>
