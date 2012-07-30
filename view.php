<!DOCTYPE html>
<html lang="en">
  <head>
	<?php
		include("include/db.php"); // .htaccess secured :)
	?>
	
	<?php
		$data = $_GET['url'];
		$metric = $_GET['metric'];
		$rank = $_GET['rank'];
		
		$syear = $_GET['syear'];
		$eyear = $_GET['eyear'];
		$bcedges = $_GET['bcedges'];
		$eventseriesid = $_GET['eventseriesid'];
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
	<script type="text/javascript" src="js/sortable.js"></script>
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
		  <li>
		    Visualization
		  </li><span class="divider">/</span>
		  <li class="active">
		    Statistics
		  </li>
		</ul>
		Note: you can click on the table heading entries like "name" to sort the table ... <br>
		<?php
		$result = "";
		if($bcedges != "true"){
			$link = $data."&metric=".$metric."&rank=".$rank;
			$result = file_get_contents($link); 
		}else{
			$link = $data."&eventseriesid=".$eventseriesid."&rank=".$rank."&syear=".$syear."&eyear=".$eyear."&bcedges=true";
			$result = file_get_contents($link);
		}
		echo $result;
		?>	
    </div> <!-- /container -->
  </body>
</html>
