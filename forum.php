<?php
// Shows threads in forum
include('includes/header.html');
?>

<div class="container">
	<div class="row">
		<div clas="col-12">
			<p>Here you can find already made forums along with information such as author, date & time of creation, number of replies
				and date & time of latest reply. You can also change the information presented by changing the language using the languages 
				dropdown in the navbar. It will also change the time zone in addition to the language and post presented!
		</div>
	</div>
</div>


<?php

// Convert dates & times based on timezone
if (isset($_SESSION['user_tz'])) {
	$first = "CONVERT_TZ(p.posted_on, 'UTC', '{$_SESSION['user_tz']}')";
	$last = "CONVERT_TZ(p.posted_on, 'UTC', '{$_SESSION['user_tz']}')";
} else {
	$first = 'p.posted_on';
	$last = 'p.posted_on';
}

// Query for retrieving all threads in forum with the author
// When thread first posted, last replied, and # of replies
$q = "SELECT t.thread_id, t.subject, username, COUNT(post_id) - 1 AS responses, MAX(DATE_FORMAT($last, '%e-%b-%y %l:%i %p')) AS last, MIN(DATE_FORMAT($first, '%e-%b-%y %l:%i %p')) AS first FROM threads AS t INNER JOIN posts AS p USING (thread_id) INNER JOIN users AS u ON t.user_id = u.user_id WHERE t.lang_id = {$_SESSION['lid']} GROUP BY (p.thread_id) ORDER BY last DESC";
$r = mysqli_query($dbc, $q);
if (mysqli_num_rows($r) > 0) {

	// Create table:
	echo '<table class="table table-striped">
	<thead>
		<tr>
			<th>' . $words['subject'] . '</th>
			<th>' . $words['posted_by'] . '</th>
			<th>' . $words['posted_on'] . '</th>
			<th>' . $words['replies'] . '</th>
			<th>' . $words['latest_reply'] . '</th>
		</tr>
	</thead>
	<tbody>';

	// Fetch threads
	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {

		echo '<tr>
				<td><a href="read.php?tid=' . $row['thread_id'] . '">' . $row['subject'] . '</a></td>
				<td>' . $row['username'] . '</td>
				<td>' . $row['first'] . '</td>
				<td>' . $row['responses'] . '</td>
				<td>' . $row['last'] . '</td>
			</tr>';

	}

	echo '</tbody></table>'; // End table

} else { // If no threads in language
	echo '<div class="container"> <p>There are currently no messages in this forum.</p> </div>';
}

// HTML footer
include('includes/footer.html');
?>