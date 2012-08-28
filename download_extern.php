<!DOCTYPE html>
<html lang="en">
  <head>
	<?php
		include("include/db.php"); // .htaccess secured :)
	?>
	
	<?php
		$conferenceString = $_POST['conferenceseries'];
		
		list($conferencePath, $database) = explode("#", $conferenceString);
		mysql_select_db(trim($database)) or die ("Can't select the database");
		
		preg_match('/[a-z]*/i',$conferencePath, $co); // clean conference name
		$conference = $co[0];
		
		$result = mysql_query("SELECT id FROM eventseries WHERE filepath=\"$conferencePath\"");
		$row = mysql_fetch_object($result);
		$idConference = $row->id;

		$syear = $_POST['syear'];
		$eyear = $_POST['eyear'];

		$ServletPREFIX = "http://131.234.31.148:8080/GEXFServer/Servlet?";
		
		$ccremoteURL = $ServletPREFIX."eventseriesid=$idConference&graphtype=cc&syear=$syear&eyear=$eyear";
		$bcremoteURL = $ServletPREFIX."eventseriesid=$idConference&graphtype=bc&syear=$syear&eyear=$eyear";
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

				$remoteURL = "http://$USER:$PASSWORD@".strtolower($conference).".aan.cs.upb.de/Export/CoAuthorGexf?startyear=$syear&endyear=$eyear&uploaded=true&eventseriesid=$idConference";

				// download file to server
				file_put_contents("data/".$conference.$syear.$eyear.".gexf", file_get_contents($remoteURL));
				$hashval = file_get_contents($ServletPREFIX."url="."data/".$conference.$syear.$eyear.".gexf"."&getsha=true");

				echo "your file has been downloaded, click <a href='vizz_neu?id=".$hashval."&name=".$conference."_from_".$syear."_to_".$eyear."(".$_POST['chosenmetric'].")'>here</a> to continue ...";
			}elseif($_POST['chosenmetric'] == "co-citation"){					
				$link = file_get_contents($ccremoteURL); 
				echo "your file has been generated, click <a href=\"".$link."&name=".$conference."_from_".$syear."_to_".$eyear."(".$_POST['chosenmetric'].")\">here</a> to open it";		
		//echo '<meta http-equiv="refresh" content="3; URL='.$link.'">';
			}elseif($_POST['chosenmetric'] == "bibliographic coupling"){
				$link = file_get_contents($bcremoteURL); 
				echo "your file has been generated, click <a href=\"".$link."&eventseriesid=".$idConference."&syear=".$syear."&eyear=".$eyear."&bcedges=true&name=".$conference."_from_".$syear."_to_".$eyear."(".$_POST['chosenmetric'].")\">here</a> to open it";
			}
			?>
		
    </div> <!-- /container -->
  </body>
</html>
