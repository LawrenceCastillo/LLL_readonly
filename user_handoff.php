<?php
require_once "config.php";

$stmt = $con->prepare('SELECT fname, lname, email FROM `iArt` WHERE kid = (
	SELECT max(kid) FROM iArt)');
$stmt->execute();
$stmt->bind_result($fname, $lname, $email);
$stmt->fetch();
$stmt->close();

?>

<!DOCTYPE html>
<html>
<h1>Thank you <?=$fname?> <?=$lname?></h1> for your information! Thank you for being so trusting! We promise we will take very good care of your personal data and we solemnly promise absolutely not to sell your information, especially not your email address: 
<h3><?=$email?></h3>
</html>
