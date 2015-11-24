<?php
function showError($errorMessage)
{
	echo '<p class="errormsg">Error: ' . $errorMessage . '</p>';
}
function showSuccess($successMessage)
{
	echo '<p class="successmsg">Success: ' . $successMessage . '</p>';
}