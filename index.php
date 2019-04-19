
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
  
  $query ="SELECT mv.movie_id, mv.movietitle, mv.directorname, mv.description, mrt.ratedsign AS rated_name, ml.lgname AS language_name, mv.runningtime, mv.releasedate, mv.picture " .
      "FROM movie AS mv " .
      "INNER JOIN movie_rated AS mrt USING (rated_id) " .
      "INNER JOIN movie_language AS ml USING (language_id) " .
      "WHERE movietitle IS NOT NULL ORDER BY movie_id ASC ";      
  $data = mysqli_query($dbc, $query);
 
  
  if (!$data) {
    printf("Error: %s\n", mysqli_error($dbc));
    exit();
     }
 echo '<table>';
  while ($row = mysqli_fetch_array($data)) { 
    // Display the data
   // echo '<tr class="scorerow"><td><strong>' . $row['name'] . '</strong></td>';
    echo '<td>' . $row['movie_id'] . '</td>';
    echo '<td>' . $row['movietitle'] . '</td>';
	echo '<td>' . $row['directorname'] . '</td>';
	echo '<td>' . $row['rated_name'] . '</td>';
	echo '<td>' . $row['description'] . '</td>';
	echo '<td>' . $row['runningtime'] . '</td>';
	echo '<td>' . $row['language_name'] . '</td>';		
	echo '<td>' . $row['releasedate'] . '</td>';
	
	if(is_file(MM_UPLOADPATH . $row['picture']) && filesize(MM_UPLOADPATH . $row['picture'])>0) {
		echo'<td><img src="'. MM_UPLOADPATH . $row['picture'].'"alt="Movie image" /></td></tr>';
		}
	else {
		echo'<td><img src="'. MM_UPLOADPATH . 'Nopic.gif' . '"alt="No Picture" /></td></tr>';
	}
	
	echo'<td><a href="viewreviews.php?movie_id=' . $row['movie_id'] . '&amp;movietitle=' . $row['movietitle'] . '&amp;directorname=' . $row['directorname'] .
      '&amp;description=' . $row['description'] . '&amp;rated_name=' . $row['rated_name'] . '&amp;language_name=' . $row['language_name'] .
	  '&amp;runningtime=' . $row['runningtime'] . '&amp;releasedate=' . $row['releasedate'] . '&amp;picture=' . $row['picture'] . '">To see reviews</a>';
   	 
	echo'<td><a href="postreview.php?movie_id=' . $row['movie_id'] . '&amp;movietitle=' . $row['movietitle'] . '&amp;directorname=' . $row['directorname'] .
      '&amp;description=' . $row['description'] . '&amp;rated_name=' . $row['rated_name'] . '&amp;language_name=' . $row['language_name'] .
	  '&amp;runningtime=' . $row['runningtime'] . '&amp;releasedate=' . $row['releasedate'] . '&amp;picture=' . $row['picture'] . '">To post review</a>';
    echo '</td></tr>';
  }
  echo '</table>';

  mysqli_close($dbc);
?>
  

<?php
  // Insert the page footer
  require_once('footer.php');
?>
