<?php

// Helpful error logging to the screen. Remove in production.
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

// Can haz database?
$conn = pg_connect("dbname=movie host=localhost user=movie password=movie");

// Need to vote for the same movie more than once? Drop the constraint here.
// pg_query($conn, "ALTER TABLE movie.public.votes DROP CONSTRAINT votes_once");

?>
