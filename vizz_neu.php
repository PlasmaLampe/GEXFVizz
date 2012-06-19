<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>GEXF Vizz</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

	<?php
			// download file to server
			file_put_contents("data/".basename($_GET['url']), file_get_contents($_GET['url']));
	?>
	
    <!-- Le styles -->
    <link href="css/bootstrap.min.theme.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">

	<!-- some libs and other needed stuff -->
	<link rel="stylesheet" href="css/own.css">
	<script type="text/javascript">
		var mindateInt;
		var mindate;
		var maxdateInt;
		var maxdate;
		var demo = -1;
		var slider;
		var currentDay = 0;
	</script>	
	
	<script src="js/sigma.concat.js"></script>
	<script src="js/jquery.min.js"></script>
	<script src="zoom/jquery.zoomooz.min"></script>
	<script src="js/demo.js"></script>
	<script src="js/sigma.parseGexfPlus.js"></script>
	
	<!-- source of the slider: http://dhtmlx.com/docs/products/dhtmlxSlider/index.shtml -->	
	<script  src="slider_codebase/dhtmlxcommon.js"></script>
	<script  src="slider_codebase/dhtmlxslider.js"></script>
	<script  src="slider_codebase/ext/dhtmlxslider_start.js"></script>
	<link rel="STYLESHEET" type="text/css" href="slider_codebase/dhtmlxslider.css">
	<!-- source of the slider: http://dhtmlx.com/docs/products/dhtmlxSlider/index.shtml -->
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
              <li><a href="uploadorchoose.php">Upload or choose file</a></li>
              <li><a href="impressum.php">Contact</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

	<!--	MAIN OUTPUT		-->	
    <div class="container">
		<ul class="breadcrumb">
		  <li>
		    <a href="index.php">Home</a> <span class="divider">/</span>
		  </li>
		  <li>
		    <a href="uploadorchoose.php">Upload or choose</a> <span class="divider">/</span>
		  </li>
		  <li class="active">Visualization</li>
		</ul>
		
		<div class='out'>
			babab
		</div>

		<div id='mainAndListing'>
			<div id='main'>
				<div class="span12 sigma-parent" id="sigma-example-parent">
				  	<div class="sigma-expand" id="sigma-example">

				  	</div>
				</div>

				<div id="slider" >
					<div id="sliderBox"></div>
					<div class="buttons-container">
						<input style="width:80px" type="button" id='Day-' value="Step -">
						<input style="width:140px" type="button" id='PlayAnimation' value="Play animation">
						<input style="width:80px" type="button" id='Day+' value="Step +">
					</div>
				</div>
			</div>
			<div class="vspace"></div>
			
			<div class="row">
	        <div id="timeBox" class="span4">
			<h3>Time information:</h3>
	          	<div class='from'>from</div>
				<div class='to'>to</div>
	        </div>
	        <div id="graphBox" class="span4">
			<h3>Graph information:</h3>				
				<?php
					$nae = file_get_contents("http://84.200.8.141:8080/GEXFServer/Servlet?url=".$_GET['url']."&getnodesandedges=1");
					$dens = file_get_contents("http://84.200.8.141:8080/GEXFServer/Servlet?url=".$_GET['url']."&getdensity=1");
					list ($nodes, $edges) = split('#', $nae);
					echo "The graph contains $nodes nodes and $edges edges<br>The graph density is $dens"
				?>
	       </div>
	        <div id="otherFilesBox" class="span4">
				<h3>Other files on this server:</h3>
				<?php
					if ($handle = opendir('data/')) {
						echo "<table border='1'>\n\t<tr><th>File</th></tr>";
					    while (false !== ($file = readdir($handle))) {
							if ($file != "." && $file != "..") {
					        	echo "<tr><td><a href='http://84.200.8.141/vizz_neu.php?url=data/$file'>$file</a></td></tr>\n";
							}
					    }
					    closedir($handle);
					}
					echo "</table>";
				?>
	        </div>
	      </div>
	<div class="vspace"></div>
			<div class="row">
	        <div id="dcBox" class="span4">
	          	<h3><a id="zoomDC" href="#">Degree Centrality</a></h3>
				<?php
				echo file_get_contents("http://84.200.8.141:8080/GEXFServer/Servlet?url=".$_GET['url']."&metric=dc&rank=3"); 
				?>
	        </div>
	        <div id="ccBox" class="span4">
	          <h3><a id="zoomCC" href="#">Closeness Centrality</a></h3>
				<?php
				echo file_get_contents("http://84.200.8.141:8080/GEXFServer/Servlet?url=".$_GET['url']."&metric=cc&rank=3"); 
				?>
	       </div>
	        <div id="bcBox" class="span4">
				<h3><a id="zoomBC" href="#">Betweenness Centrality</a></h3>
				<?php
				echo file_get_contents("http://84.200.8.141:8080/GEXFServer/Servlet?url=".$_GET['url']."&metric=bc&rank=3"); 
				?>
	        </div>
	      </div>
	      <hr>

	      <footer>
	        <p>&copy; Company 2012</p>
	      </footer>
    </div> <!-- /container -->
  </body>
</html>
