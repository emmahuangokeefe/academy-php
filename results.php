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
        <a href="login.html">Log in</a>
        <a href="admin.html">Site admin</a>
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

      <?php
      // display success message
      if (isset($_GET['success']) && $_GET['success'] == '1') {
        print '<strong>You voted successfully!</strong>';
      }

      ?>

      <table id='results'>
        <caption>Results</caption>
        <thead>
          <tr>
            <th>Title</th>
            <th>Votes</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Get all the movies.
          $query = $pdo->query("SELECT * FROM movies");

          // Loop around each movie, and see if it has teh votez.
          while($movie = $query->fetch(PDO::FETCH_OBJ)) {
            // Do another database query to count the votes for this movie.
            $votes = $pdo->query("SELECT * FROM votes WHERE movie_id = $movie->id")->rowCount();
            if ($votes > 0) {
              print '<tr><td>';
              print $movie->name;
              print '</td><td>';
              print $votes;
              print '</td></tr>';
            }
          }

          ?>
        </tbody>
      </table>
      <div id="chart_div"></div>

    </div>

  </div>

  <footer>
    <p class="small">A page by Sean, Copyright <?php print date('Y'); ?></p>
  </footer>

  <script type="text/javascript" src="//code.jquery.com/jquery-1.10.1.min.js"></script>
  <script type="text/javascript" src="js/script.js"></script>
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
  <script type="text/javascript">

    // Load the Visualization API and the piechart package.
    google.load('visualization', '1.0', {'packages':['corechart']});

    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawChart);

    // Callback that creates and populates a data table,
    // instantiates the pie chart, passes in the data and
    // draws it.
    function drawChart() {

      // Create the data table.
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Results');
      data.addColumn('number', 'Movies');
      var movies = [];
      $('#results tbody tr').each(function() {
        movies.push([$(this).find('td').first().text(), parseInt($(this).find('td').last().text())]);
      });
      data.addRows(movies);

      // Set chart options
      var options = {
        'title': 'Movie results',
        'width': 600,
        'height': 460,
        'backgroundColor': '#666666',
      };

      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    }
  </script>

</body>

</html>
