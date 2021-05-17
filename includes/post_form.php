<?php
// form for posting, included by other pages, never called directly

// Redirect if called directly
if (!isset($words)) {
	header ("Location: http://www.google.com");
	exit();
}

// Only display this form if the user is logged in
if (isset($_SESSION['user_id'])) {

	// Display the form
	echo '<form action="post.php" method="post" accept-charset="utf-8" style="margin-bottom: 30px;">';

	// If on read.php
	if (isset($tid) && $tid) {

		// Print caption
		echo '<h3>' . $words['post_a_reply'] . '</h3>';

		// Add thread ID as hidden input
		echo '<input name="tid" type="hidden" value="' . $tid . '">';

	} else { // New thread in post.php

		// Print caption
		echo '<h3>' . $words['new_thread'] . '</h3>';

		// Create subject input
		echo '<div class="form-group"><label for="subject">' . $words['subject'] . '</label> <input name="subject" type="text" class="form-control" size="60" maxlength="100" ';

		// Check for existing value
		if (isset($subject)) {
			echo "value=\"$subject\" ";
		}

		echo '></div>';

	}

	// Textarea
	echo '<div class="form-group"><label for="subject">' . $words['body'] . '</label> <textarea name="body" class="form-control" rows="10" cols="60">';

	if (isset($body)) {
		echo $body;
	}

	echo '</textarea></div>';

	// Finish form
	echo '<input name="submit" type="submit" class="btn btn-primary" style="margin-top: 10px;" value="' . $words['submit'] . '">
	</form>';

} else {
	echo '<p class="alert alert-warning">You must be logged in to post messages.</p>';
}

?>