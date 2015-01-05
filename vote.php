<?php

// Get a database connection.
include('includes/database.inc');

# Named placeholders.
try {
  $stmt = $pdo->prepare("INSERT INTO votes (id, person_id, movie_id) value (:id, :person_id, :movie_id)");

  // Get the variables for the insert. These should be validated first.
  $id = NULL;
  $person_id = 1;
  $movie_id = $_GET['vote'];

  $stmt->bindParam(':id', $id);
  $stmt->bindParam(':person_id', $person_id);
  $stmt->bindParam(':movie_id', $movie_id);
  $success = (int) $stmt->execute();
}
catch (Exception $e) {
  print $e->getMessage();
}

header("Location: results.php?success=$success&movie_id=$movie_id");
die;

?>
