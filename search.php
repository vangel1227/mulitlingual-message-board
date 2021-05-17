<?php
// Displays & handles search form

// HTML header
include('includes/header.html');

// Convert dates & times based on timezone from users
if (isset($_SESSION['user_tz'])) {
	$postDateTime = "CONVERT_TZ(p.posted_on, 'UTC', '{$_SESSION['user_tz']}')";
} else {
	$postDateTime = 'p.posted_on';
}

// Show the search form
echo '<form class="form-control" action="search.php" method="get" accept-charset="utf-8">
<h4>' . $words['search'] . ':</h4> <input class="form-control" name="terms" type="text" size="30" maxlength="60" ';

// Check for existing values
if (isset($_GET['terms'])) {
	echo 'value="' . htmlspecialchars($_GET['terms']) . '" ';
}

// Complete form
echo '><input name="submit" class="btn btn-primary" style="margin-top: 20px;" type="submit" value="' . $words['submit'] . '"></p></form>';

if (isset($_GET['terms'])) { // Handle form

	// Clean terms, striping HTML/PHP tags from entered term
	$terms = mysqli_real_escape_string($dbc, htmlentities(strip_tags($_GET['terms'])));

	// Run query
	$q = "SELECT t.thread_id, t.subject, username, p.message, p.posted_on, COUNT(post_id) - 1 AS responses, MIN(DATE_FORMAT($postDateTime, '%e-%b-%y %l:%i %p')) AS postDateTime FROM threads AS t INNER JOIN posts AS p USING (thread_id) INNER JOIN users AS u ON t.user_id = u.user_id WHERE p.message LIKE '%$terms%' GROUP BY (p.thread_id) ORDER BY postDateTime DESC";
	$r = mysqli_query($dbc, $q);
	if (mysqli_num_rows($r) > 0) {
		echo '<h2>Search Results</h2>
				<table class="table table-striped">
					<thead class="table-dark">
						<tr>
							<th>' . $words['subject'] . '</th>
							<th>' . $words['posted_by'] . '</th>
							<th>' . $words['replies'] . '</th>
							<th>' . $words['posted_on'] . '</th>
						</tr>
					</thead>
				<tbody>';

				while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {

						echo '<tr>
						<td><a href="read.php?tid=' . $row['thread_id'] . '">' . $row['subject'] . '</a></td>
						<td style="width: 90px;">' . $row['username'] . '</td>
						<td>' . $row['message'] . '</td>
						<td style="width: 90px;">' . $row['postDateTime'] . '</td>
					</tr>';
	
				}

				echo '</tbody></table>';
	} else {
		echo '<p>No results found.</p>';
	}

}

// HTML footer
include('includes/footer.html');
?>
