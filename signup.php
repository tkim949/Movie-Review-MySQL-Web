<?php
  // Insert the page header
  $page_title = 'Sign Up';
  require_once('header.php');

  require_once('appvars.php');
  require_once('connectvars.php');

  // Connect to the database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  if (isset($_POST['submit'])) {
    // Grab the profile data from the POST
    $username = mysqli_real_escape_string($dbc, trim($_POST['username']));
    $password1 = mysqli_real_escape_string($dbc, trim($_POST['password1']));
    $password2 = mysqli_real_escape_string($dbc, trim($_POST['password2']));
	$firstname = mysqli_real_escape_string($dbc, trim($_POST['firstname']));
	$lastname = mysqli_real_escape_string($dbc, trim($_POST['lastname']));
	$emailaddress = mysqli_real_escape_string($dbc, trim($_POST['emailaddress']));

    if (!empty($username) && !empty($password1) && !empty($password2) &&!empty($firstname)&&!empty($lastname)&&!empty($emailaddress) && ($password1 == $password2)) {
      // Make sure someone isn't already registered using this username
      $query = "SELECT * FROM movie_user WHERE username = '$username'";
      $data = mysqli_query($dbc, $query);
      if (mysqli_num_rows($data) == 0) {
        // The username is unique, so insert the data into the database
        $query = "INSERT INTO movie_user (username, password, firstname, lastname, emailaddress) VALUES ('$username', SHA('$password1'), '$firstname', '$lastname', '$emailaddress')";
        mysqli_query($dbc, $query);

        // Confirm success with the user
        echo '<p>Your new account has been successfully created. You\'re now ready to <a href="login.php">log in</a>.</p>';

        mysqli_close($dbc);
        exit();
      }
      else {
        // An account already exists for this username, so display an error message
        echo '<p class="error">An account already exists for this username. Please use a different address.</p>';
        $username = "";
      }
    }
    else {
      echo '<p class="error">You must enter all of the sign-up data, including the desired password twice.</p>';
    }
  }

  mysqli_close($dbc);
?>

  
  
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
   <p>Sign up with Funny Movie reviews today.</p>
   <table>
    <tr>
      <td><label for="username">Username:</label></td>
      <td><input id="username" name="username" type="text" value="<?php echo (isset($username)) ? $username : ''; ?>"/></td></tr>
    <tr>
      <td><label for="password1">Password:</label></td>
      <td><input id="password" name="password1" type="text" value="<?php echo (isset($password1)) ? $password1 : ''; ?>"/></td>
	<tr>
      <td><label for="password2">Password (retype):</label></td>
      <td><input id="password" name="password2" type="text" value="<?php echo (isset($password2)) ? $password2 : ''; ?>"/></td> 
    <tr>
      <td><label for="firstname">First Name:</label></td>
      <td><input id="firstname" name="firstname" type="text" value="<?php echo (isset($firstname)) ? $firstname : ''; ?>"/></td></tr>
    <tr>
      <td><label for="lastname">Last Name:</label></td>
      <td><input id="lastname" name="lastname" type="text" value="<?php echo (isset($lastname)) ? $lastname: ''; ?>"/></td></tr>
    <tr>
      <td><label for="emailaddress">Email:</label></td>
      <td><input id="emailaddress" name="emailaddress" type="text" value="<?php echo (isset($emailaddress)) ? $emailaddress : ''; ?>"/></td></tr>
    
  </tr>
  </table>
  <input type="submit" value="Sign Up" name="submit" />
</form>
<?php
  // Insert the page footer
  require_once('footer.php');
?>
