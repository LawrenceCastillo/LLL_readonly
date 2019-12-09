<?php

// Include config
require_once "config.php";

// add in user form

$query = 'SELECT question FROM questions';
$result = mysqli_fetch_all($con->query($query), MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LikeLikeLove.com</title>
    <link rel="stylesheet" type="text/css" media="screen" href="css/screen.css">
  </head>

  <body> 
    <div id="page">
      <header>
        <a id="top"></a>
        <a class="logo" title="LikeLikeLove.com" href="profile.php"><span>LikeLikeLove.com</span></a>
        <div class="hero">
        </div>
      </header>
      <h2 id="qpage">Find Your match with this personality quiz!</h2>
      <div>
	      <form action="entry.php" method="post" autocomplete="off"> 
	        <?php for ( $i=0; $i < 8; $i++ ){ ?>
            <blockquote>
              <?php echo $result[$i]['question']; ?>
              <select type="text" name="<?php echo $i+1 ?>" id="question">
	              <option id="agree">Tend to Agree</option>
	              <option id="disagree">Tend to Disagree</option>
              </select>
            </blockquote>
            <?php } ?>
            <div>
              <input type="text" name="fname" placeholder="First Name" id="fname" required>
	          </div>
            <div>
              <input type="text" name="lname" placeholder="Last Name" id="lname" required>
	          </div>
	          <div>
	            <input type="email" name="email" placeholder="Email" id="email" required>
	          </div>
          <input type="submit" value="submit" >
        </form>
      </div>

      <nav>
        <ul>
          <li><a class="navigation" href="quiz.php">TAKE THE QUIZ!</a></li>
        </ul>
      </nav>

    </div>
  </body>
</html>
