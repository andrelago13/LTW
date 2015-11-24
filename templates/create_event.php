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

<form action="create_event.php" method="post"
	enctype="multipart/form-data" />
<label for="type">Type:</label>
<select id="type" name="type">
<?php
	foreach ( $eventTypes as $eventType ) {
		echo '<option value="' . $eventType ["id"] . '"';
		if (isset ( $_POST ["type"] ) && $_POST ["type"] == $eventType ["id"])
			echo ' selected';
		echo '>' . $eventType ["name"] . '</option>';
	}
	?>
</select>
<div class="name">
	<label for="name">Name:</label> <input type="text" name="name"
		id="name"
		value="<?php if (isset($_POST["name"])) echo $_POST["name"];?>" required>
</div>
<div class="description">
	<label for="description">Description:</label> <input type="description"
		name="description" id="description"
		value="<?php if (isset($_POST["description"])) echo $_POST["description"];?>" requires>
</div>
<div class="date">
	<label for="date">Date:</label> <input type="datetime" name="date"
		id="date"
		value="<?php if (isset($_POST["date"])) echo $_POST["date"];?>" required>
</div>
<div class="public">
	<label for="public">Public?</label> <input type="checkbox" id="public"
		name="public" <?php if (isset($_POST["public"])) echo ' checked';?>>
</div>
<input type="hidden" name="owner"
	value="<?php echo $_SESSION['userid'];?>" />
<div class="image">
	<label for="image"></label> <input type="file" name="image" id="image">
</div>
<div class="submit_btn">
	<button type="submit">Submit</button>
</div>
</form>
<?php } ?>