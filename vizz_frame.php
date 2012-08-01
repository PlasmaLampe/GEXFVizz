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
		$name = $_GET['name'];
		$eventseriesid =  $_GET['eventseriesid'];
		$syear =  $_GET['syear'];
		$eyear =  $_GET['eyear'];
		$bcedges = $_GET['bcedges'];
		$id = $_GET['id'];

		$ServletPREFIX = "http://131.234.31.148:8080/GEXFServer/Servlet?";
		$WebPREFIX = "http://131.234.31.148/";
	?>
	
    <!-- Le styles -->
    <link href="css/bootstrap.min.theme.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet">

	<!-- some libs and other needed stuff -->
	<link rel="stylesheet" href="css/own.css">
	<script type="text/javascript">
		var mindate = -1;
		var maxdate;
		var demo = -1;
		var slider;
		var currentDay = 0;
	</script>	
	
	<script src="js/jquery.min.js"></script>
	<script src="js/sigma.concat.js"></script>
	<script src="zoom/jquery.zoomooz.min"></script>
	<script src="js/hover_and_zoom.js"></script>
	<script src="js/vector2.js"></script>
	<script src="js/sigma.fr.js"></script>
	<script src="js/sigma.circ.js"></script>
	<script src="js/sigma.random.js"></script>
	<script src="js/sigma.hideNodes.js"></script>
	<script src="js/sigma_own.js"></script>
	<script src="js/sigma.parseGexfPlus.js"></script>
	<script src="js/bootstrap-tooltip.js"></script>
	<script src="js/bootstrap-popover.js"></script>
	
	<!-- source of the slider: http://dhtmlx.com/docs/products/dhtmlxSlider/index.shtml -->	
	<script  src="slider_codebase/dhtmlxcommon.js"></script>
	<script  src="slider_codebase/dhtmlxslider.js"></script>
	<script  src="slider_codebase/ext/dhtmlxslider_start.js"></script>
	<link rel="STYLESHEET" type="text/css" href="slider_codebase/dhtmlxslider.css">
	<!-- source of the slider: http://dhtmlx.com/docs/products/dhtmlxSlider/index.shtml -->
  </head>

  <body>

	<!--	MAIN OUTPUT		-->	
    <div class="container">		
			<div class="row">
	        <div id="perLink" class="span4">
				<?php
					$bcPOSTFIX = "";
					if($_GET['bcedges'] != null){ // add some vars, because we have a bibliographic coupling graph here
						$bcPOSTFIX = "&syear=".$syear."&eyear=".$eyear."&bcedges=true&eventseriesid=".$eventseriesid;
					}
					$linktext = "<h4>use this link to open this graph with GEXF Vizz:</h4>";
					$finalperLink = $WebPREFIX."vizz_neu.php?id=".$id."&name=".$name.$bcPOSTFIX;
					
					echo "<a href =\"".$finalperLink."\">".$linktext."</a>";
				?>
	        </div>
	        <div id="downloadLink" class="span4">			
	       </div>
	        <div id="empty" class="span4">
	        </div>
	      </div>
				
		<hr>
		
		<div class="buttons-container">
			<input style="width:140px" type="button" id='randomlayout' value="random layout">
			<input style="width:140px" type="button" id='circlayout' value="circular layout">
			<input style="width:140px" type="button" id='frlayout' value="FR layout">
		</div>
		
		<br>
		
		<div id='mainAndListing'>
			<div id='main'>
				<div class="span12 sigma-parent" id="sigma-example-parent">
				  	<div class="sigma-expand" id="sigma-example">

				  	</div>
				</div>

				<div id="slider" >
					<div id="sliderBox"></div>
					<div class="buttons-container">
						<input style="width:80px" type="button" id='Day-' value="N/A">
						<input style="width:140px" type="button" id='PlayAnimation' value="Play animation">
						<input style="width:80px" type="button" id='Day+' value="Step+">
					</div>
				</div>
			</div>			
    </div> <!-- /container -->
  </body>
</html>
