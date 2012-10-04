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
		if($_GET['url'] != null){
			file_put_contents("data/".basename($_GET['url']), file_get_contents($_GET['url']));
		}
		
		$ServletPREFIX = "http://131.234.31.148:8080/GEXFServer/Servlet?";
		$WebPREFIX = "http://131.234.31.148/";
	?>
	
	<!-- include twitter bootstrap -->
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
		var mindate = -1;	// minimal date of the graph
		var maxdate;	// maximal date of the graph
		var slider;	// contains the slider object
		var sigInstGlobal;
		var currentDay = 0;	// current value of the slider
		var parser; // contains the gexf parser object
		var runningAnimation = false; // is currently an animation running ?
		var animationID; // this id is needed to stop the running animation
	</script>	
	
	<script src="js/jquery.min.js"></script>
	<script src="js/sigma.concat.js"></script>
	<script src="js/hover_and_zoom.js"></script>
	<script src="js/vector2.js"></script>
	<script src="js/sigma.fr.js"></script>
	<script src="js/sigma.circ.js"></script>
	<script src="js/sigma.random.js"></script>
	<script src="js/sigma.hideNodes.js"></script>
	<script src="js/sigma.findNode.js"></script>
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
		
		<h2>Hold on, again! Sigma.js or Circos ?</h2>
		Now, you can see a visualization with Sigma.js or with Circos ...
		<ul class="nav nav-pills">
		  <li class="active">
		    <a href="uploadorchoose.php">... show me the Sigma.js visualization</a>
		  </li>
		 <?php 
		if($_GET['url'] != null){
			echo "<li><a href=\"circos_select.php?url=data/".basename($_GET['url'])."\">... show me the Circos visualization</a></li>";
		}else{
			$hashlink = $_GET['id'];
			
			echo "<li><a href=\"circos_select.php?url=hash/".$hashlink.".gexf\">... show me the Circos visualization</a></li>";
		}
			?>
		</ul>
		
		<hr>
		
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
			<input style="width:140px" type="button" id='frlayout' value="FR layout (slow)">
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
						
						| Filter name: <input type="text" id="find"/> | Highlight all connected nodes: <input type="checkbox" name="highlightConnected" id="highlightConnected"/>
					</div>
				</div>
			</div>
			<div class="vspace"></div>
			<div class="row">
	        <div id="perLink" class="span4">
				<?php
					$bcPOSTFIX = "";
					if($_GET['bcedges'] != null){ // add some vars, because we have a bibliographic coupling graph here
						$bcPOSTFIX = "&syear=".$syear."&eyear=".$eyear."&bcedges=true&eventseriesid=".$eventseriesid;
					}
					$linktext = "<h4>use this link to share this page with your partners and friends:</h4>";
					$hashval = "";
					if($_GET['url'] != null){
						$hashval = file_get_contents($ServletPREFIX."url="."data/".basename($_GET['url']."&getsha=true"));

					}else{
						$hashval = $_GET['id'];
					}
					$finalperLink = $WebPREFIX."vizz_neu.php?id=".$hashval."&name=".$name.$bcPOSTFIX;
					echo $linktext."<a href =\"".$finalperLink."\">click here</a>";
					
					$embedLink = $WebPREFIX."vizz_frame.php?id=".$hashval."&name=".$name.$bcPOSTFIX;
					echo "<h4>Use this code to embed this graph</h4>";
					echo "<pre class=\"prettyprint linenums\">".htmlspecialchars("<iframe src=\"".$embedLink."\" width=\"800\" height=\"670\" name=\"embeddedGEXFVizz\"><p>Your browser can't show iframes: But you can open the embedded page with <a href=\"".$embedLink."\">this</a> link...</p></iframe>")."</pre>";
				?>
	        </div>
	        <div id="downloadLink" class="span4">			
			<?php
				$linktext = "<h4>Download this gexf file here:</h4>";
				$finalperLink = "";
				$hashval = "";
				
				if($_GET['url'] != null){
					$hashval = file_get_contents($ServletPREFIX."url="."data/".basename($_GET['url']."&getsha=true"));
				}else{
					$hashval = $_GET['id'];		
				}
				$finalperLink = $WebPREFIX."hash/".$hashval.".gexf";
				echo $linktext."<a href =\"".$finalperLink."\">click here</a>";
				
				$linktextproject = "<h4>Download this gephi project file here:</h4>";
				$finalperLinkproject = file_get_contents($ServletPREFIX."id=".$hashval."&getproject=true");
				echo $linktextproject."<a href =\"".$finalperLinkproject."\">click here</a><br>use 'save target as' to download the files";
				
			?>
	       </div>
	        <div id="empty" class="span4">

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
						$nae = file_get_contents($ServletPREFIX."url="."data/".basename($_GET['url']."&getnodesandedges=true"));
						$dens = file_get_contents($ServletPREFIX."url="."data/".basename($_GET['url']."&getdensity=true"));
						list ($nodes, $edges) = split('#', $nae);
						$roundDens = round($dens, 2);
						echo "The graph contains $nodes nodes and $edges edges<br>The graph density is $roundDens";
					}else{
						$hashlink = $_GET['id'];
						
						$nae = file_get_contents($ServletPREFIX."id=".$hashlink."&getnodesandedges=true");
						$dens = file_get_contents($ServletPREFIX."id=".$hashlink."&getdensity=true");
						list ($nodes, $edges) = split('#', $nae);
						$roundDens = round($dens, 2);
						echo "The graph contains $nodes nodes and $edges edges<br>The graph density is $roundDens";
					}
				?>
	       </div>
	        <div id="bc" class="span4">
				<?php
				if($bcedges == "true"){
					$bcurl = $ServletPREFIX."eventseriesid=".$eventseriesid."&syear=".$syear."&eyear=".$eyear."&rank=5&bcedges=true";
					$bAllcurl = $ServletPREFIX."eventseriesid=".$eventseriesid."&syear=".$syear."&eyear=".$eyear."&rank=10000&bcedges=true";
					echo "<h3> Top 5 Edges:  | <a href=\"view.php?url=".$bAllcurl."\">show all</a></h3>";
					echo file_get_contents($bcurl); 
				}
				?>
	        </div>
	      </div>
	<div class="vspace"></div>
			<div class="row">
	        <div id="dcBox" class="span4">
				<?php
					if($_GET['url'] != null){
						echo "<h3> Degree Centrality | <a href=\"\#\" id=\"dcHover\" rel=\"tooltip\" >(?)</a> | <a href=\"view.php?url=".$ServletPREFIX."url="."data/".basename($_GET['url'])."&metric=dc&rank=10000\">show all</a></h3>";
						echo file_get_contents($ServletPREFIX."url="."data/".basename($_GET['url'])."&metric=dc&rank=10"); 
					}else{
						$hashlink = $_GET['id'];
						echo "<h3> Degree Centrality | <a href=\"\#\" id=\"dcHover\" rel=\"tooltip\" >(?)</a> | <a href=\"view.php?url=".$ServletPREFIX."id=".$hashlink."&metric=dc&rank=10000\">show all</a></h3>";
						echo file_get_contents($ServletPREFIX."id=".$hashlink."&metric=dc&rank=10"); 
					}
				?>
	        </div>
	        <div id="ccBox" class="span4">
	          <?php 
					if($_GET['url'] != null){
						echo "<h3> Closeness Centrality | <a href=\"\#\" id=\"ccHover\" rel=\"tooltip\" >(?)</a> | <a href=\"view.php?url=".$ServletPREFIX."url="."data/".basename($_GET['url'])."&metric=cc&rank=10000\">show all</a></h3>";
						echo file_get_contents($ServletPREFIX."url="."data/".basename($_GET['url'])."&metric=cc&rank=10"); 
					}else{
						$hashlink = $_GET['id'];
						echo "<h3> Closeness Centrality | <a href=\"\#\" id=\"ccHover\" rel=\"tooltip\" >(?)</a> | <a href=\"view.php?url=".$ServletPREFIX."id=".$hashlink."&metric=cc&rank=10000\">show all</a></h3>";
						echo file_get_contents($ServletPREFIX."id=".$hashlink."&metric=cc&rank=10"); 
					}
				?>
	       </div>
	        <div id="bcBox" class="span4">
				<?php 
					if($_GET['url'] != null){
						echo "<h3> Betweenness Centrality | <a href=\"\#\" id=\"bcHover\" rel=\"tooltip\" >(?)</a> | <a href=\"view.php?url=".$ServletPREFIX."url="."data/".basename($_GET['url'])."&metric=bc&rank=10000\">show all</a></h3>";
						echo file_get_contents($ServletPREFIX."url="."data/".basename($_GET['url'])."&metric=bc&rank=10"); 
					}else{
						$hashlink = $_GET['id'];
						echo "<h3> Betweenness Centrality | <a href=\"\#\" id=\"bcHover\" rel=\"tooltip\" >(?)</a> | <a href=\"view.php?url=".$ServletPREFIX."id=".$hashlink."&metric=bc&rank=10000\">show all</a></h3>";
						echo file_get_contents($ServletPREFIX."id=".$hashlink."&metric=bc&rank=10"); 
					}
				?>
	        </div>
	      </div>
	      <hr>

	      <footer>
	        <p>developed by J&ouml;rg Amelunxen - 2012 - Bachelor Thesis</p>
	      </footer>
    </div> <!-- /container -->
  </body>
</html>
