<?php
require_once (__DIR__ . "/../config.php");
require_once (INCLUDES_PATH . "/authentication.php");
require_once (DATABASE_PATH . "/events.php");
require_once (TEMPLATES_PATH . "/utils.php");

require (INCLUDES_PATH . "/create_event_action.php");

if (! isUserLoggedIn ()) {
	http_response_code ( 403 );
	showError ( 'You need to login to create an event.' );
} else {
	$eventTypes = getEventTypes ();
	?>

<form class="create_event" action="create_event.php" method="post"
	enctype="multipart/form-data">
	<h1 id="name">Create Event</h1>
	<div class="type">
		<label for="type">Type:</label> <select id="type" name="type"
			value="Party">
	<?php
	foreach ( $eventTypes as $eventType ) {
		echo '<option value="' . $eventType ["id"] . '"';
		if (isset ( $_POST ["type"] ) && $_POST ["type"] == $eventType ["id"])
			echo ' selected';
		echo '>' . $eventType ["name"] . '</option>';
	}
	?>
	</select>
	</div>
	<div class="name">
		<label for="name">Name:</label> <input type="text" name="name"
			id="name"
			value="<?php if (isset($_POST["name"])) echo $_POST["name"];?>"
			required />
	</div>
	<div class="description">
		<label for="description">Description:</label>
		<textarea name="description" id="description"/>
			<?php if (isset($_POST["description"])) echo $_POST["description"];?>
		</textarea>
	</div>
	<div class="date">
		<label for="date">Date:</label> <input type="datetime" name="date"
			id="date"
			value="<?php if (isset($_POST["date"])) echo $_POST["date"];?>"
			required />
	</div>
	<div class="public">
		<label for="public">Public?</label> <input type="checkbox" id="public"
			name="public" <?php if (isset($_POST["public"])) echo ' checked';?> />
	</div>

	<div class="image">
		<label for="image">Image:</label> <input type="file" name="image"
			id="image" />
	</div>
	<div class="submit_btn">
		<button type="submit">Submit</button>
	</div>
</form>
<?php } ?>