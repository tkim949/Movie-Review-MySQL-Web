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
    $query = "SELECT movie_id, movietitle, directorname, picture FROM movie WHERE movie_id = '" . $_GET['movie_id'] . "'";
   }
    $data = mysqli_query($dbc, $query);
  
   if (mysqli_num_rows($data)) {
   $row = mysqli_fetch_array($data);
  echo '<table>';
  echo '<td>' . $row['movie_id'] . '</td>';
  echo '<td>' . $row['movietitle'] . '</td>';
  echo '<td>' . $row['directorname'] . '</td>';
  
  if(is_file(MM_UPLOADPATH . $row['picture']) && filesize(MM_UPLOADPATH . $row['picture'])>0) {
		echo'<td><img src="'. MM_UPLOADPATH . $row['picture'].'"alt="Movie image" /></td></tr>';
		}
	else {
		echo'<td><img src="'. MM_UPLOADPATH . 'Nopic.gif' . '"alt="No Picture" /></td></tr>';
	}
  echo '</td></tr>';
  
  echo '</table>';
  }
 
   $id =$_GET['movie_id'];
  
  if (!$data) {
  printf("Error: %s\n", mysqli_error($dbc));
     exit();
    } 
    
	 // Start generating the table of results
  echo '<table border="0" cellpadding="2">';

  // Generate the review headings
  echo '<tr class="heading">';
  echo '<td>User Name</td><td>reviewscore</td><td>Description</td>';
  echo '</tr>';
   	
	$query = "SELECT review_id, username, reviewscore, review_des FROM movie_review WHERE $id = movie_id ORDER BY review_id ASC "; 
	$data = mysqli_query($dbc, $query);	
	
	 $i= 0;
	 $total =0;
	
    while ($row = mysqli_fetch_array($data)) { 
      // Display each row as a table row
	   echo '<tr class="reviews">';
       echo '<td valign="top" width="10%">' . $row['username'] . '</td>';
       echo '<td valign="top" width="10%">' . $row['reviewscore'] . '</td>';
      // echo '<td valign="top" width="10%">' . $row['state'] . '</td>';
       echo '<td valign="top" width="50%">' . $row['review_des'] . '</td>';
       echo '</tr>';
     
	 $i += 1;
	 $score = (int)($row['reviewscore']);	
	 $total = $total + ($score);
 	}				
		echo '<tr><td><strong>Review Count:</strong><br /> ' . $i . '</td></tr>';
		
		if (!($i==0)){
		echo '<tr><td><strong>Review Score:</strong><br /> ' . floor(($total/$i)*100)/100 . '</td></tr>';
		}
		else {
		echo '<tr><td><strong>Review Score:</strong><br /> ' . $i . '</td></tr>';
		}
    echo '</table>';
	
	
   mysqli_close($dbc);
  
  
  echo '<p><a href="index.php">&lt;&lt; Back to main page</a></p>';
?>

<?php
  // Insert the page footer
  require_once('footer.php');
?>

