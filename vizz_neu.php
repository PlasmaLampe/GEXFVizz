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
		if($_GET['url'] != null){
			file_put_contents("data/".basename($_GET['url']), file_get_contents($_GET['url']));
		}
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
		
		<div id="nameOfGraph">
			<?php
				if($name != null){
					echo "<h4>you are looking at: ".$name."</h4>";
				}else{
					echo "<h4>you are looking at: ".basename($_GET['url']).".gexf</h4>";
				}
			?>
		</div>
		
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
					if($_GET['url'] != null){
						$nae = file_get_contents("http://84.200.8.141:8080/GEXFServer/Servlet?url="."data/".basename($_GET['url']."&getnodesandedges=1"));
						$dens = file_get_contents("http://84.200.8.141:8080/GEXFServer/Servlet?url="."data/".basename($_GET['url']."&getdensity=1"));
						list ($nodes, $edges) = split('#', $nae);
						$roundDens = round($dens, 2);
						echo "The graph contains $nodes nodes and $edges edges<br>The graph density is $roundDens";
					}else{
						$hashlink = $_GET['id'];
						
						$nae = file_get_contents("http://84.200.8.141:8080/GEXFServer/Servlet?id=".$hashlink."&getnodesandedges=1");
						$dens = file_get_contents("http://84.200.8.141:8080/GEXFServer/Servlet?id=".$hashlink."&getdensity=1");
						list ($nodes, $edges) = split('#', $nae);
						$roundDens = round($dens, 2);
						echo "The graph contains $nodes nodes and $edges edges<br>The graph density is $roundDens";
					}
				?>
	       </div>
	        <div id="perLink" class="span4">
					<?php
						if($_GET['url'] != null){
							$hashval = file_get_contents("http://84.200.8.141:8080/GEXFServer/Servlet?url="."data/".basename($_GET['url']."&getsha=1"));
							echo "<h3>use this link to share this page with your partners and friends:</h3> http://84.200.8.141/vizz_neu.php?id=".$hashval; 
						}else{
							$hashlink = $_GET['id'];
							echo "<h3>use this link to share this page with your partners and friends:</h3> http://84.200.8.141/vizz_neu.php?id=".$hashlink; 
						}
					?>
	        </div>
	      </div>
	<div class="vspace"></div>
			<div class="row">
	        <div id="dcBox" class="span4">
	          	<h3><a id="zoomDC" href="#">Degree Centrality</a> | <a href="#" id="dcHover" rel="tooltip" >(?)</a></h3>
				<?php
					if($_GET['url'] != null){
						echo file_get_contents("http://84.200.8.141:8080/GEXFServer/Servlet?url="."data/".basename($_GET['url'])."&metric=dc&rank=10"); 
					}else{
						$hashlink = $_GET['id'];
						echo file_get_contents("http://84.200.8.141:8080/GEXFServer/Servlet?id=".$hashlink."&metric=dc&rank=10"); 
					}
				?>
	        </div>
	        <div id="ccBox" class="span4">
	          <h3><a id="zoomCC" href="#">Closeness Centrality</a> | <a href="#" id="ccHover" rel="tooltip" >(?)</a></h3>
				<?php
					if($_GET['url'] != null){
						echo file_get_contents("http://84.200.8.141:8080/GEXFServer/Servlet?url="."data/".basename($_GET['url'])."&metric=cc&rank=10"); 
					}else{
						$hashlink = $_GET['id'];
						echo file_get_contents("http://84.200.8.141:8080/GEXFServer/Servlet?id=".$hashlink."&metric=cc&rank=10"); 
					}
				?>
	       </div>
	        <div id="bcBox" class="span4">
				<h3><a id="zoomBC" href="#">Betweenness Centrality</a> | <a href="#" id="bcHover" rel="tooltip" >(?)</a></h3>
				<?php
					if($_GET['url'] != null){
						echo file_get_contents("http://84.200.8.141:8080/GEXFServer/Servlet?url="."data/".basename($_GET['url'])."&metric=bc&rank=10"); 
					}else{
						$hashlink = $_GET['id'];
						echo file_get_contents("http://84.200.8.141:8080/GEXFServer/Servlet?id=".$hashlink."&metric=bc&rank=10"); 
					}
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
