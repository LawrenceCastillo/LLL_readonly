<?php
// Include config file
require_once "config.php";

foreach ($_POST as $key => $value){

  if ($value == "Tend to Agree" ){$choice_id = $key*2;}
  else if ($value == "Tend to Disagree" ){$choice_id = $key*2+1;}
    
  if ($stmt = $con->prepare('
      INSERT INTO chooses (account_id, choice_id) 
      VALUES (?, ?)')){
    $stmt->bind_param('ii', $id, $choice_id);
    $stmt->execute();
  } else { die ('Something went wrong!'); }
  $stmt->close();
}

$stmt = $con->prepare('
    SELECT x.type_id type_id
    FROM choices x
    JOIN (
      SELECT choice_id 
      FROM chooses 
      WHERE account_id = ? 
      ORDER BY choose_id DESC 
      LIMIT 8) o
    ON x.choice_id = o.choice_id');
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
while($row_data = $result->fetch_assoc()) {
  $score += $row_data['type_id'];
}

/* Find Type from score */
if ($score < 24)      {$type = 2;}
else if ($score < 28) {$type = 3;}
else if ($score < 32) {$type = 4;}
else                  {$type = 5;} 
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

      <h2 id="qpage">Personality Types based on "The Four Tendencies" by Gretchen Rubin</h2>
      <div>
	<?php for ( $i=0; $i < 4; $i++ ){ ?>
          <blockquote><b>
	    <?php echo $result[$i]['type'];?>: </b><?php echo $result[$i]['description']; ?>
          </blockquote>
        <?php } ?>
      </div>

      <nav>
        <ul>
          <li><a class="navigation" href="logout.php">LOGOUT</a></li>
          <li><a class="navigation" href="quiz.php">TAKE THE QUIZ!</a></li>
          <li><a class="navigation" href="profile.php">PROFILE</a></li>
	  <li><a class="navigation" href="index.html">LOGIN</a></li>
	  <li><a class="navigation" href="register.html">REGISTER</a></li>
        </ul>
      </nav>

     <footer>
       This website was created for educational purposes only. No harm intended to the author of the book.<br>
       &copy; Lawrence Gabriel Castillo: New York- Based Software Engineer
       <!--This website created by Lawrence Gabriel Castillo-->
     </footer>

    </div>
  </body>
</html>
