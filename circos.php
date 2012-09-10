<!DOCTYPE html>
<html lang="en">
  <head>
	<?php
		$url = $_GET['url'];
		$metric = $_POST['metric'];
		$rank = $_POST['itemcount'];
		$style = $_POST['style'];
		$ServletPREFIX = "http://131.234.31.148:8080/GEXFServer/Servlet?";
		$IP = "http://131.234.31.148/";
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
		    <a href="uploadorchoose.php">Upload or choose</a>
		  </li><span class="divider">/</span>
		  </li>
		  <li class="active">
		    Circos
		  </li>
		</ul>
		
		<?php
		$paras = "&circos=true&metric=".$metric."&rank=".$rank."&preview=".$style;
		$cc_pic = file_get_contents($ServletPREFIX."url=".$_GET['url'].$paras); 
		
		// restore hash name:
		$hash_with_postfix = substr(strrchr($cc_pic, "/"), 1);
		$hash_clean = strstr($hash_with_postfix, '_', true);
		
		// print all the things
		//$small_cc_pic = preg_replace("/\\.[^.\\s]{3,4}$/", "", $cc_pic)."_small.png";
		echo "<h3> ".$metric." (Top ".$rank.") | (<a href=\"".$IP."circos/gexfCircos.pdf\">I don't understand these diagrams!</a>)</h3>";
		echo "<p><a href=\"".$cc_pic."\"><img src=\"".$cc_pic."\" width=\"600\" height=\"600\"></a></p><br>";
		echo "<h4>Download the circos configuration files:</h4> <a href=\"".$IP."circos/data/".$hash_clean.".zip\">download</a>"; 
		?>
		
		
    </div> <!-- /container -->
  </body>
</html>
