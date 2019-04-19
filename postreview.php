<?php
  // Start the session
  require_once('startsession.php');

  // Insert the page header
  $page_title = 'Post your reviews!';
  require_once('header.php');

  require_once('appvars.php');
  require_once('connectvars.php');

  // Show the navigation menu
  require_once('navmenu.php');

  // Connect to the database 
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); 
  
if (isset($_GET['movie_id'])) {
    $query = "SELECT movie_id, movietitle, directorname FROM movie WHERE movie_id = '" . $_GET['movie_id'] . "'";
    $data = mysqli_query($dbc, $query);
  
   if (mysqli_num_rows($data)) {
  $row = mysqli_fetch_array($data);
  echo '<table>';
  echo '<td>' . $row['movie_id'] . '</td>';
  echo '<td>' . $row['movietitle'] . '</td>';
  echo '<td>' . $row['directorname'] . '</td>';
  echo '</td></tr>';
  echo '</table>';
   }
 }
  
//if (!$data) {
 //   printf("Error: %s\n", mysqli_error($dbc));
//    exit();
 //   } 
  
  if (isset($_POST['submit'])) {
	  // $value = isset($_POST['value']) ? $_POST['value'] : '';
    $movie_id = $_POST['movie_id'];
    $username = $_POST['username'];
    $reviewscore = $_POST['reviewscore'];
    $review_des = addslashes($_POST['review_des']);
    $output_form = 'no';
	
	if (!empty($movie_id) && !empty($username) && !empty($reviewscore) && !empty($review_des) ) {
      // Write the data to the database
      $query = "INSERT INTO movie_review (movie_id, username, reviewscore, review_des) VALUES ('$movie_id', '$username', '$reviewscore', '$review_des')";
	  usleep(250000); // take a 1/4 second break
      mysqli_query($dbc, $query);
    }
	 usleep(250000); // take a 1/4 second break
	 mysqli_close($dbc);
	 
    if (empty($movie_id)) {
      // $movie_id is blank
      echo '<p class="error">You forgot to enter the movie id number.</p>';
      $output_form = 'yes';
    }

    if (empty($username)) {
      // $username is blank
      echo '<p class="error">You forgot to enter your user name.</p>';
      $output_form = 'yes';
    }
   
    if (empty($reviewscore)|| $reviewscore <1 || $reviewscore > 5) {
      // $reviewscore is blank... 
      echo '<p class="error">You forgot to enter the proper score for the movie. Please input between 1 and 5. 1 is lowest and 5 is highest.</p>';
      $output_form = 'yes';
    }

    if (empty($review_des)) {
      // $review detail is blank
      echo '<p class="error">You forgot to enter your review for the movie.</p>';
      $output_form = 'yes';
    }
  }
  else {
    $output_form = 'yes';
  }

  if ($output_form == 'yes') {
?>
 

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
   <p>Post your opinion for the movie.</p>
  <table>
    <tr>
      <td><label for="movie_id">Movie Id Number:</label></td>
      <td><input id="movie_id" name="movie_id" type="text" value="<?php echo (isset($movie_id)) ? $movie_id :''; ?>"/></td></tr>
    <tr>
      <td><label for="username">Username:</label></td>
      <td><input id="username" name="username" type="text" value="<?php echo (isset($username)) ? $username : ''; ?>"/></td></tr>
    <tr>
      <td><label for="reviewscore">Score (From 1 to 5):</label></td>
      <td><input id="reviewscore" name="reviewscore" type="number" value="<?php echo (isset($reviewscore)) ? $reviewscore : ''; ?>"/></td>
    
  </tr>
  </table>
  <p>
    <label for="review_des">Post your opinion.:</label><br />
    <textarea id="review_des" name="review_des" rows="4" cols="40"><?php echo (isset($review_des)) ? $review_des: ''; ?></textarea><br />
    <input type="submit" name="submit" value="Submit" />
  </p>
</form>

<?php
  }
  else if ($output_form == 'no') {
    echo '<p>' . $username . ', thanks for your post!</p>';
    
  }
  echo '<p><a href="index.php">&lt;&lt; Back to main page</a></p>';
?>

<?php
  // Insert the page footer
  require_once('footer.php');
?>

