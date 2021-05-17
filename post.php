<?php 

// Displays post form & handles posting
include('includes/header.html');

echo '<p>Created through included post form with some for validation including the use of PHP\'s strip_tag, htmlenitities, and htmlspecialchars() functions to prevent cross-site scripting (XSS) attacks.</p>';

echo '<p>Post/threads added via SQL INSERT query depending on whether form is in post.php or read.php</p>';

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Handle form

	// Use language ID in session
	// Validate thread ID ($tid)
	if (isset($_POST['tid']) && filter_var($_POST['tid'], FILTER_VALIDATE_INT, array('min_range' => 1)) ) {
		$tid = $_POST['tid'];
	} else {
		$tid = FALSE; // If no thread ID
	}

	// If there's no thread ID, a subject must be provided
	if (!$tid && empty($_POST['subject'])) {
		$subject = FALSE; // No thread ID & Subject left blank
		echo '<p class="alert alert-danger">Please enter a subject for this post.</p>';
	} elseif (!$tid && !empty($_POST['subject'])) { // No thread ID, subject entered
		$subject = htmlspecialchars(strip_tags($_POST['subject']));
	} else { // Thread ID, subject not needed
		$subject = TRUE;
	}

	// Validate post
	if (!empty($_POST['body'])) {
		$body = htmlentities($_POST['body']);
	} else {
		$body = FALSE;
		echo '<p class="alert alert-danger">Please enter a body for this post.</p>';
	}

	if ($subject && $body) { // Subject & body set

		// Add post to db, Insert into threads for original thread posts, Insert into posts for subsequent replies

		if (!$tid) { // No thread ID, create new thread
			$q = "INSERT INTO threads (lang_id, user_id, subject) VALUES ({$_SESSION['lid']}, {$_SESSION['user_id']}, '" . mysqli_real_escape_string($dbc, $subject) . "')";
			$r = mysqli_query($dbc, $q);
			if (mysqli_affected_rows($dbc) == 1) {
				$tid = mysqli_insert_id($dbc);
			} else { // error message
				echo '<p class="alert alert-danger">Your post could not be handled due to a system error.</p>';
			}
		} 

		if ($tid) { // Thread ID in use, add to replies table
			$q = "INSERT INTO posts (thread_id, user_id, message, posted_on) VALUES ($tid, {$_SESSION['user_id']}, '" . mysqli_real_escape_string($dbc, $body) . "', UTC_TIMESTAMP())";
			$r = mysqli_query($dbc, $q);
			if (mysqli_affected_rows($dbc) == 1) {
				echo '<p class="alert alert-success">Your post has been entered.</p>';
			} else { // error message
				echo '<p class="alert alert-danger">Your post could not be handled due to a system error.</p>';
			}
		}

	} else { // Include form
		include('includes/post_form.php');
	}

} else { // Display form

	include('includes/post_form.php');

}

// HTML footer
include('includes/footer.html');
?>