<?php 
// Shows thread when specific thread entered

// HTML Header
include('includes/header.html');

// Check for thread ID
$tid = FALSE;
if (isset($_GET['tid']) && filter_var($_GET['tid'], FILTER_VALIDATE_INT, array('min_range' => 1)) ) {

	// Create shorthand version thread ID
	$tid = $_GET['tid'];

	// Convert date based on user time zone
	if (isset($_SESSION['user_tz'])) {
		$posted = "CONVERT_TZ(p.posted_on, 'UTC', '{$_SESSION['user_tz']}')";
	} else {
		$posted = 'p.posted_on';
	}

	// Run query
	$q = "SELECT t.subject, p.message, username, DATE_FORMAT($posted, '%e-%b-%y %l:%i %p') AS posted FROM threads AS t LEFT JOIN posts AS p USING (thread_id) INNER JOIN users AS u ON p.user_id = u.user_id WHERE t.thread_id = $tid ORDER BY p.posted_on ASC";
	$r = mysqli_query($dbc, $q);
	if (!(mysqli_num_rows($r) > 0)) {
		$tid = FALSE; // Invalid thread ID
	}

}

if ($tid) { // Get messages in thread

	$printed = FALSE; // Flag variable

	// Fetch each post
	while ($messages = mysqli_fetch_array($r, MYSQLI_ASSOC)) {

		// Print subject once
		if (!$printed) {
			echo "<h2>{$messages['subject']}</h2>\n";
			$printed = TRUE;
		}

		// Print post
		echo "<div class=\"card\" style=\"margin-bottom: 20px;\"> <div class=\"card-body\"> <h5 class=\"card-title\">{$messages['username']}</h5> <h6 class=\"card-subtitle text-muted\">({$messages['posted']})</h6> <p class=\"card-text\">{$messages['message']}</p></div></div>\n";

	}

	// Include create post form
	include('includes/post_form.php');

} else { // Invalid thread ID message
	echo '<p class="bg-danger">This page has been accessed in error.</p>';
}

include('includes/footer.html');
?>