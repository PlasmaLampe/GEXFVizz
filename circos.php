<!DOCTYPE html>
<html lang="en">
  <head>
	<?php
		$url = $_GET['url'];
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
		$cc_pic = file_get_contents("http://84.200.8.141:8080/GEXFServer/Servlet?url=".$_GET['url']."&metric=cc&rank=20&circos=true"); 
		echo "<h3> Closeness centrality </h3>";
		echo "<p><a href=\"".$cc_pic."\"><img src=\"".$cc_pic."\" width=\"700\" height=\"700\"></a></p>";
		?>
		
		
    </div> <!-- /container -->
  </body>
</html>
