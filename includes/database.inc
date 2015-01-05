<?php

// Helpful error logging to the screen. Remove in production.
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

// Disable opcache if needed.
// ini_set('opcache.enable', FALSE);

// Can haz database?
try {
  $pdo = new PDO('mysql:host=localhost;dbname=movie', 'movie', 'password');
}
catch (Exception $e) {
  die('Could not connect: ' . $e->getMessage());
}

// Need to vote for the same movie more than once? Drop the constraint here.
// pg_query($conn, "ALTER TABLE movie.public.votes DROP CONSTRAINT votes_once");

?>
