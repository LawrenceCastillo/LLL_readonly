<?php
// Include config file
require_once "config.php";

$stmt = $con->prepare('INSERT INTO iArt (fname, lname, email) VALUES (?, ?, ?)');
$stmt->bind_param('sss', $_POST['fname'], $_POST['lname'], $_POST['email']);
$stmt->execute();
$stmt->close();

$choice_id = 0;
$score     = 0;
$type      = 0;

foreach ($_POST as $key => $value){
  // capture choice_ids
  if ($value == "Tend to Agree" ){
    $choice_id = $key*2;
    // query for choice values (meaning)
    if ($stmt = $con->prepare('
        SELECT type_id FROM choices WHERE choice_id = ?')){
      $stmt->bind_param('i', $choice_id);
      $stmt->execute();
      $stmt->bind_result($val);
      $stmt->fetch();
    } else { die ('Something went wrong!'); }
    $stmt->close();
    // accumulate type score
    $score += $val;
  }
  else if ($value == "Tend to Disagree" ){
    $choice_id = $key*2+1;
    // query for choice values (meaning)
    if ($stmt = $con->prepare('
        SELECT type_id FROM choices WHERE choice_id = ?')){
      $stmt->bind_param('i', $choice_id);
      $stmt->execute();
      $stmt->bind_result($val);
      $stmt->fetch();
    } else { die ('Something went wrong!'); }
    $stmt->close();
    // accumulate type score
    $score += $val;
  }
}

// Find type from score
if ($score < 24)      {$type = 2;}
else if ($score < 28) {$type = 3;}
else if ($score < 32) {$type = 4;}
else                  {$type = 5;} 

// Capture type name
$stmt = $con->prepare('
    SELECT type
    FROM types 
    WHERE type_id = ?');
$stmt->bind_param('i', $type);
$stmt->execute();
$stmt->bind_result($type_name);
$stmt->fetch();
$stmt->close();

// Return compatible type 1
$stmt = $con->prepare('
  SELECT type 
  FROM types 
  WHERE type_id = (
    SELECT max(type_id2) 
    FROM pairings
    WHERE type_id1 = ?)');
$stmt->bind_param('i', $type);
$stmt->execute();
$stmt->bind_result($pair1);
$stmt->fetch();
$stmt->close();

// Return compatible type 2
$stmt = $con->prepare('
  SELECT type 
  FROM types 
  WHERE type_id = (
    SELECT min(type_id2) 
    FROM pairings
    WHERE type_id1 = ?)');
$stmt->bind_param('i', $type);
$stmt->execute();
$stmt->bind_result($pair2);
$stmt->fetch();
$stmt->close();

// Grab all types
$query = 'SELECT type, description FROM types';
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
      <h2 id="qpage">My type: <?php echo $type_name;?></h2>
      <h2 id="qpage">My compatible match types: <?php echo "$pair1 and $pair2";?></h2>
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
          <li><a class="navigation" href="quiz.php">TAKE THE QUIZ!</a></li>
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
