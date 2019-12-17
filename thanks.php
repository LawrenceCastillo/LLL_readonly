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
<h1>We absolutely LOVE information <?=$fname?>, in fact we live for your information! Of course, we know privacy is a big concern but we got you! We would never publicly display your email address, <h3><?$email?></h3>. Oops! We'll do our best to ensure that your information isn't sold.
</html>
