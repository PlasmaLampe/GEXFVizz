<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html lang="en">
<head>
	<?php
		$conference = $_POST['conference'];
		$result = mysql_query("SELECT id FROM event WHERE text='$conference'");
		$row = mysql_fetch_object($result);
		$idConferenc = $row->id;

		$syear = $_POST['syear'];
		$eyear = $_POST['eyear'];
	?>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>untitled</title>
	<meta name="generator" content="TextMate http://macromates.com/">
	<meta name="author" content="Jörg Amelunxen">
	
	<!-- Date: 2012-06-21 -->
	
	<?php
		include("include/db.php"); // .htaccess secured :)
	?>

	<?php
		if($_POST['chosenmetric'] == "co-authorship"){
		$remoteURL = "http://$USER:$PASSWORD@mlearn.aan.cs.upb.de/Export/CoAuthorGexf?startyear=$syear&endyear=$eyear&uploaded=true&eventid=$idConferenc";

		// download file to server
		file_put_contents("data/$conference.gexf", file_get_contents($remoteURL));

		echo "your file has been downloaded, click <a href='vizz_neu?url=data/$conference.gexf'>here</a> to continue ...";
		}elseif($_POST['chosenmetric'] == "co-citation"){
		$remoteURL = "http://84.200.8.141:8080/GEXFServer/Servlet?eventid=$idConferenc&graphtype=cc&syear=$syear&eyear=$eyear";
		echo $remoteURL;
		$link = file_get_contents($remoteURL); 
		echo '<meta http-equiv="refresh" content="3; URL=$link">';
		}elseif($_POST['chosenmetric'] == "bibliographic coupling"){
		echo "sorry, this is a todo feature ... :( ...";
		}
	?>
	
</head>
<body>
please wait ...

</body>
</html>
