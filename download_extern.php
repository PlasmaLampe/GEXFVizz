<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>untitled</title>
	<meta name="generator" content="TextMate http://macromates.com/">
	<meta name="author" content="Jörg Amelunxen">
	<!-- Date: 2012-06-21 -->
	
	<?php
		include("include/db.php"); // .htaccess secured :)
	?>
	
</head>
<body>
<?php
$conference = $_POST['conference'];
$syear = $_POST['syear'];
$eyear = $_POST['eyear'];

$result = mysql_query("SELECT id FROM event WHERE text='$conference'");
$row = mysql_fetch_object($result);
$realnameConferenc = $row->id;

$remoteURL = "http://$USER:$PASSWORD@mlearn.aan.cs.upb.de/Export/CoAuthorGexf?startyear=$syear&endyear=$eyear&uploaded=true&eventid=$realnameConferenc";

// download file to server
file_put_contents("data/$conference.gexf", file_get_contents($remoteURL));

echo "your file has been downloaded, click <a href='vizz_neu?url=data/$conference.gexf'>here</a> to continue ...";
?>
</body>
</html>
