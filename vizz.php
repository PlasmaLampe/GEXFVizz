<!doctype html>
<html>
<head>
	<title> GEXF Vizz </title>
	
	<?php
		file_put_contents("data/".basename($_GET['url']), file_get_contents($_GET['url']));
	?>
		
  	<link rel="stylesheet" href="css/bootstrap.min.css">
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
<div id='page' class="wrapper">
	<div id='header'>
		<h2> GEXF Vizz (0.8)</h2>
		<hr>
	</div>
	
	<!-- <div class="ribbon-wrapper-green">
		<div class="ribbon-green">GEXF Vizz</div>
	</div> -->
	
	<div class='out'>
		babab
	</div>
	
	<div id='mainAndListing'>
		<div id='main' class="layered-paper">
			<div class="span12 sigma-parent" id="sigma-example-parent">
			  	<div class="sigma-expand" id="sigma-example">
  		
			  	</div>
			</div>

			<div class='from'>from</div>
			<div class='to'>to</div>

			<div id="slider" >
				<div id="sliderBox"></div>
				<div class="buttons-container">
					<input style="width:80px" type="button" id='Day-' value="Step -" onclick="sigInst.HideWrongTimeNodes(-1)">
					<input style="width:140px" type="button" id='PlayAnimation' value="Play animation" onclick="playAnimation()">
					<input style="width:80px" type="button" id='Day+' value="Step +" onclick="sigInst.HideWrongTimeNodes(+1)">
				</div>
			</div>
		</div>

		<div id="listing">
			Other files on this server:
			<?php
				if ($handle = opendir('data/')) {
					echo "<table border='1'>\n\t<tr><th>File</th></tr>";
				    while (false !== ($file = readdir($handle))) {
						if ($file != "." && $file != "..") {
				        	echo "<tr><td><a href='http://jadev.dyndns.org:81/vizz.php?gexf=data/$file'>$file</a></td></tr>\n";
						}
				    }
				    closedir($handle);
				}
				echo "</table>";
			?>
		</div>
	</div><br>
	<div class="vspace"></div>
	
	<div class="container">
	 <div id="dcBox" class="left"><h3><a id="zoomDC" href="#">Degree Centrality</a></h3>
		<?php 
		echo $_GET['url'];
			echo file_get_contents("http://jadev.dyndns.org:1321/GEXFServer/Servlet?gexf=".$_GET['url']."&metric=dc&rank=3"); 
		?>	
		</div>
	    <div id="ccBox" class="middle"><h3><a id="zoomCC" href="#">Closeness Centrality</a></h3>
		<?php 
			echo file_get_contents("http://jadev.dyndns.org:1321/GEXFServer/Servlet?gexf=".$_GET['url']."&metric=cc&rank=3"); 
		?>
		</div>
	    <div id="bcBox" class="right"><h3><a id="zoomBC" href="#">Betweenness Centrality</a></h3>
		<?php 
			echo file_get_contents("http://jadev.dyndns.org:1321/GEXFServer/Servlet?gexf=".$_GET['url']."&metric=bc&rank=3"); 
		?>
		</div>
	    <div class="clear"></div>
	</div>
</div>

</body>
</html>
