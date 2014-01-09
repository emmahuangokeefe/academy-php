<?php

// get a database connection
include('includes/database.inc');

// get the movie the user voted for
// pg_escape_string();
$movie_id = $_GET['vote'];

// insert a vote into the database
$result = pg_fetch_object(pg_query($conn, "INSERT INTO votes VALUES('1', '$movie_id')"));

header("Location: results.php?success=1&movie_id=$movie_id");
die;

?>
