<?php
require_once (__DIR__ . "/../config.php");
require_once (TEMPLATES_PATH . "/utils.php");
require_once (INCLUDES_PATH . "/authentication.php");
require_once (INCLUDES_PATH . "/events.php");
require_once (DATABASE_PATH . "/events.php");
require_once (INCLUDES_PATH . "/utils.php");
require_once (DATABASE_PATH . "/comment.php");

require (INCLUDES_PATH . "/write_comment_action.php");
require (INCLUDES_PATH . "/write_reply_action.php");
require (INCLUDES_PATH . "/invite_user_action.php");
require (INCLUDES_PATH . "/edit_event_image_action.php");

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
		$canEdit = (isUserLoggedIn () && $event ["owner"] === getUserID ());
		
		echo '<div class="event" id="event' . $idEvent . '">';
		if ($canEdit) {
			echo '<a href="delete_event.php?id=' . $idEvent . '&amp;csrf_token=' . rawurlencode($_SESSION['csrf_token']) . '" class="delete" id="delete_event" onclick="return confirm(\'Are you sure you want to delete this event?\');"><img src="//:0" alt="Delete Event" /></a>';
			$public = $event ["public"];
			if( $public )
				echo '<a href="change_event_privacy.php?id=' . $idEvent . '&action=0&csrf_token=' . rawurlencode($_SESSION['csrf_token']) . '" class="change_privacy public" id="change_privacy"><img src="//:0" alt="Change Event Privacy" /><p class="description">Make me private</p></a>';
			else
				echo '<a href="change_event_privacy.php?id=' . $idEvent . '&action=1&csrf_token=' . rawurlencode($_SESSION['csrf_token']) . '" class="change_privacy private" id="change_privacy"><img src="//:0" alt="Change Event Privacy" /><p class="description">Make me public</p></a>';
			echo '<div class="registration owner"></div>';
			
			echo '<form class="invite_user" action="invite_user.php" method="get">';
			echo '<input type="hidden" name="csrf_token" value="' . $_SESSION['csrf_token'] . '" />';
			echo '<input type="hidden" name="idEvent" value="' . $idEvent . '" />';
			echo '<input type="text" value="" placeholder="Invite user" name="invited_username" required/>';
			echo '<input class="submit" type="submit" onclick="return confirm(\'Are you sure you want to invite that user?\');"/>';
			echo '</form>';
		} else if(isUserRegisteredInEvent ( getUserID(), $idEvent )) {
			echo '<a href="user_registration.php?idEvent=' . $idEvent . '&amp;action=0&amp;csrf_token=' . rawurlencode($_SESSION['csrf_token']) . '"><div class="registration registered"></div></a>';
		} else {
			echo '<a href="user_registration.php?idEvent=' . $idEvent . '&amp;action=1&amp;csrf_token=' . rawurlencode($_SESSION['csrf_token']) . '"><div class="registration not_registered"></div></a>';
		}
		
		echo '<h1 name="name" class="name">' . htmlspecialchars ( $event ["name"] ) . '</h1>';
		if ($canEdit)
			echo '<a href="" class="edit" id="edit_name"><img src="images/edit_field.png" alt="Edit" /></a>';
		echo '<h2 class="type">' . getEventTypeName($event ["type"]) . '</h2>';
		echo '<div class="container">';
		echo '<img class="image" src="database/event_image.php?id=' . $idEvent . '" alt="' . htmlspecialchars ( $event ["name"] ) . '" width="256" height="256" />';
		if ($canEdit) {
			echo '<a class="edit visible" id="edit_image"><img src="images/edit_field.png" alt="Edit" /></a>';
			echo '<form class="new_image_form invisible" action="view_event.php?id=' . $_GET['id'] . '" method="post" enctype="multipart/form-data">';
				echo '<input name="edit_event_image" value="' . $idEvent . '" hidden/>';
				echo '<input type="file" class="new_image_file" name="file" required/>';
				echo '<input class="submit" type="submit"/>';
			echo '</form>';
		}
		echo '<p name="description" class="description">' . preg_replace ( "/\n/", "<br />", htmlspecialchars ( $event ["description"] ) ) . '</p>';
		if ($canEdit)
			echo '<a href="" class="edit" id="edit_description"><img src="images/edit_field.png" alt="Edit" /></a>';
		echo '</div>';
		
		echo '<datetime-local name="date" class="date">' . htmlspecialchars ( $event ["date"] ) . '</datetime-local>';
		if ($canEdit)
			echo '<a href="" class="edit" id="edit_date"><img src="images/edit_field.png" alt="Edit" /></a>';
		?>
<div class="fb-share-button" data-href="<?php echo requestedURL(); ?>"
	data-layout="button_count"></div>
<?php
		
		echo '<div class="comment_area">';
		if(isUserRegisteredInEvent ( getUserID(), $idEvent )) {
			echo '<form class="write_comment_form" id="write_comment" action="view_event.php?id=' . $idEvent . '" method="post">';
			echo '<input type="hidden" name="idEvent" value="' . $idEvent . '" />';
			echo '<textarea name="text" class="text" required placeholder="Comment..." maxlength="500"></textarea>';
			echo '<button type="submit" name="submit_comment">Add comment</button>';
			echo '</form>';
		}
		
		echo '<div class="comment_container">';
		echo '<h2 class="title">Comments:</h2>';
		$comments = getComments ( $idEvent );
		if(sizeof($comments) > 0) {
			foreach ( $comments as $comment ) {
				echo '<div class="comment">';
				echo '<h3 class="user">' . htmlspecialchars ( $comment ["name"] ) . '</h3>';
				if($comment["user_id"] != getUserID()) {
					if(isUserRegisteredInEvent ( $comment ["user_id"], $idEvent )) {
						echo '<div class="registered"></div>';
					} else {
						echo '<div class="not_registered"></div>';
					}
				}
				echo '<p class="text">' . nl2br ( htmlspecialchars ( $comment ["text"] ) ) . '</p>';
				echo '<h4 class="time">' . $comment ["date"] . '</h4>';
				
				echo '<form action="view_event.php?id=' . $idEvent . '" method="post" class="reply_form">';
					echo '<input type="text" hidden name="idEvent" value="' . $idEvent . '"/>';
					echo '<input type="text" hidden name="idComment" value="' . $comment["id"] . '"></input>';
					echo '<input required class="reply_text" type="textarea" wrap="hard" maxlength="500" name="text" value="" placeholder="Write your reply here"/>';
					echo '<input name="submit_reply" hidden class="submit" type="submit"/>';
				echo '</form>';
				
				echo '</div>';
				
				$replies = getCommentReplies($comment['id']);
				
				foreach($replies as $reply) {
					echo '<div class="reply">';
						echo '<h3 class="user">' . htmlspecialchars($reply['name']) . '</h3>';
						echo '<p class="text">' . nl2br(htmlspecialchars($reply['text'])) . '</p>';
						echo '<h4 class="time">' . $reply["date"] . '</h4>';
					echo '</div>';
				}
			}
		} else {
			echo '<h4 class="no_comments">There are no comments yet on this event.</h4>';
		}
		
		echo '</div>';
		echo '</div>';
		echo '</div>';
	}
} catch ( Exception $e ) {
	showError ( $e->getMessage () );
}
?>
<script src="scripts/event.js"></script>
