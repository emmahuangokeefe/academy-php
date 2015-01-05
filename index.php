<?php include('includes/database.inc'); ?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Movie Night Vote</title>
  <link type="text/css" href="css/style.css" rel="stylesheet">
</head>

<body>

  <div id="wrapper">

    <header>

      <div id="user-info">
        <a href="#">Log in</a>
        <a href="#">Site admin</a>
      </div>

      <h1>Movie Night Vote</h1>

      <nav>
        <ul>
          <li><a href="index.php">This week's vote</a></li>
          <li><a href="results.php">This week's results</a></li>
          <li><a href="#">Previous results</a></li>
          <li><a href="#">About this site</a></li>
          <li><a href="#">Contact</a></li>
        </ul>
      </nav>

    </header>

    <div id="content">

      <h2>This week's vote:</h2>

      <form action="vote.php" method="get">

        <div id="movies">

          <p>Which of the following movies would you like to see on the next Movie Night?<br>Pick your choice below!</p>

          <?php
          // Get all the movies.
          $query = $pdo->query("SELECT * FROM movies");

          // display the movies one by one in a table row
          while ($movie = $query->fetch(PDO::FETCH_OBJ)) {
            print '<p class="movie">';
            print "<label for='vote_$movie->id'>";

            // Check for cache (faster).
            $image_file = './cache/movie-' . $movie->id . '.jpg';
            $synopsis_file = './cache/movie-' . $movie->id . '.txt';
            if (!file_exists($image_file) || isset($_GET['no-cache'])) {
              // pull down rotten tomatoes love
              // @see http://developer.rottentomatoes.com/iodocs
              $url = "http://api.rottentomatoes.com/api/public/v1.0/movies.json?q=" . urlencode($movie->name) . "&page_limit=1&page=1&apikey=5txumzsgfr829mj4vp832y97";
              $json = file_get_contents($url);
              $data = json_decode($json, TRUE);

              if (!empty($data) && $data['total'] > 0) {
                // Save the image locally - requires allow_url_fopen set to true.
                file_put_contents($image_file, file_get_contents($data['movies'][0]['posters']['profile']));
                // Generate a synopsis from the response.
                $synopsis = '(' . $data['movies'][0]['year'] . ') ';
                if (!empty($data['movies'][0]['synopsis'])) {
                  $synopsis .= $data['movies'][0]['synopsis'];
                }
                else if (isset($data['movies'][0]['critics_consensus'])) {
                  $synopsis .= $data['movies'][0]['critics_consensus'];
                }
                else {
                  // @TODO make this better.
                }

                file_put_contents($synopsis_file, $synopsis);
              }
              else {
                // Better error handling goes in here.
              }
            }

            // The title will not contain XSS right?
            print "<img class='poster' src='$image_file' alt='$movie->name' />";
            print '</label>';
            print "<input type='radio' name='vote' value='$movie->id' id='vote_$movie->id' />";
            print $movie->name;

            // Sure hope there is nothing malicious in this text file.
            print '<span class="synopsis">' . substr(file_get_contents($synopsis_file), 0, 200) . '&hellip; ';
            print "[$movie->length minutes]";
            print '</p>';
          }

          ?>

          <input type="submit" value="Vote!" id="vote_button">

        </div>



      </form>

    </div>

  </div>

  <footer>
    <p class="small">A page by Sean, Copyright <?php print date('Y'); ?></p>
  </footer>

<script type="text/javascript" src="//code.jquery.com/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="js/script.js"></script>

</body>

</html>
