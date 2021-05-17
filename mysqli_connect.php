<?php

// DB access information, MySQL connection & selects database

// DB access constants using Heroku ClearDB 
define('DB_USER', 'b5246f25105d18');
define('DB_PASSWORD', '55a8abe6');
define('DB_HOST', 'us-cdbr-east-03.cleardb.com');
define('DB_NAME', 'heroku_c4e8ca22b1fe691');

// MySQL connection
$dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connect to MySQL: ' . mysqli_connect_error() );

// Set encoding
mysqli_set_charset($dbc, 'utf8');

?>