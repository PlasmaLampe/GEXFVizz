<!DOCTYPE html>
<html lang="en">
  <head>
	<?php
		include("include/db.php"); // .htaccess secured :)
	?>
	
	<?php
		$conference = $_POST['conferenceseries'];
		$result = mysql_query("SELECT id FROM eventseries WHERE text=\"$conference\"");
		$row = mysql_fetch_object($result);
		$idConferenc = $row->id;
		$checkedCircos = $_POST['checkedCircos'];
		$syear = $_POST['syear'];
		$eyear = $_POST['eyear'];

		$ccremoteURL = "http://84.200.8.141:8080/GEXFServer/Servlet?eventseriesid=$idConferenc&graphtype=cc&syear=$syear&eyear=$eyear";
		$bcremoteURL = "http://84.200.8.141:8080/GEXFServer/Servlet?eventseriesid=$idConferenc&graphtype=bc&syear=$syear&eyear=$eyear";
	?>
	
    <meta charset="utf-8">
    <title>GEXF Vizz</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.min.theme.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
	<link rel="stylesheet" href="css/own.css">
  </head>

  <body>

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="index.php">GEXF Vizz</a>
          <div class="nav-collapse">
            <ul class="nav">
              <li><a href="index.php">Home</a></li>
              <li class="active"><a href="uploadorchoose.php">Upload or choose file</a></li>
              <li><a href="impressum.php">Contact</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">
		<ul class="breadcrumb">
		  <li>
		    <a href="index.php">Home</a> <span class="divider">/</span>
		  </li>
		  <li>
		    Upload or choose
		  </li><span class="divider">/</span>
		  </li>
		  <li class="active">
		    Generating...
		  </li>
		</ul>
		
		<h2>Hold on! We are generating your file ...</h2>
			<?php
			if($_POST['chosenmetric'] == "co-authorship"){
				$remoteURL = "http://$USER:$PASSWORD@".strtolower($conference).".aan.cs.upb.de/Export/CoAuthorGexf?startyear=$syear&endyear=$eyear&uploaded=true&eventseriesid=$idConferenc";

				// download file to server
				file_put_contents("data/".$conference.$syear.$eyear.".gexf", file_get_contents($remoteURL));

				echo "your file has been downloaded, click <a href='vizz_neu?url=data/".$conference.$syear.$eyear.".gexf&type=person&circos=".$checkedCircos."&name=".$conference."_from_".$syear."_to_".$eyear."(".$_POST['chosenmetric'].")'>here</a> to continue ...";
			}elseif($_POST['chosenmetric'] == "co-citation"){					
				$link = file_get_contents($ccremoteURL); 
				echo "your file has been generated, click <a href=\"".$link."&type=book&circos=".$checkedCircos."&name=".$conference."_from_".$syear."_to_".$eyear."(".$_POST['chosenmetric'].")\">here</a> to open it";		
		//echo '<meta http-equiv="refresh" content="3; URL='.$link.'">';
			}elseif($_POST['chosenmetric'] == "bibliographic coupling"){
				$link = file_get_contents($bcremoteURL); 
				echo "your file has been generated, click <a href=\"".$link."&type=book&circos=".$checkedCircos."&name=".$conference."_from_".$syear."_to_".$eyear."(".$_POST['chosenmetric'].")\">here</a> to open it";
			}
			?>
		
    </div> <!-- /container -->
  </body>
</html>
