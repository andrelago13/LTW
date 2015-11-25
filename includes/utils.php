<?php
function uploadImage($file, $target_file) {
	$imageFileType = pathinfo ( $target_file, PATHINFO_EXTENSION );
	
	// Check if image file is a actual image or fake image
	$check = @getimagesize ( $file ["tmp_name"] );
	if (! $check) {
		throw new RuntimeException ( "File is not an image." );
	}
	
	// Check if file already exists
	if (file_exists ( $target_file )) {
		throw new RuntimeException ( "Sorry, file already exists." );
	}
	// Check file size
	if ($file ["size"] > MAX_IMAGE_SIZE) {
		throw new RuntimeException ( "Sorry, your file is too large." );
	}
	// Allow certain file formats
	if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
		throw new RuntimeException ( "Sorry, only JPG, JPEG, PNG & GIF files are allowed." );
	}
	
	if (! move_uploaded_file ( $file ["tmp_name"], $target_file )) {
		throw new RuntimeException ( "Sorry, there was an error uploading your file." );
	}
}