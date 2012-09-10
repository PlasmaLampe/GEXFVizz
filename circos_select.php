<!DOCTYPE html>
<html lang="en">
  <head>
	<?php
		$url = $_GET['url'];
		$ServletPREFIX = "http://131.234.31.148:8080/GEXFServer/Servlet?";
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
		    <a href="uploadorchoose.php">Upload or choose</a> <span class="divider">/</span>
		  </li>
		  <li class="active">Visualization</li>
		</ul>

		<form class="form-horizontal" <?php echo "action=\"circos.php?url=".$url."\""; ?> method="post">  
		        <fieldset>  
		          <legend>Still, some configuration is needed</legend>  
		          <div class="control-group">  
		            <label class="control-label" for="select01">Select a sna metric</label>  
		            <div class="controls">  
		              <select name="metric" id="metricBox">  		                
						<option value="dc">Degree centrality</option> 
		                <option value="cc">Closeness centrality</option>   
						<option value="bc">Betweenness centrality</option>   
		              </select>  
		            </div>  
		          </div>
		
		          <div class="control-group">  
		            <label class="control-label" for="input01">Number of shown items</label>  
		            <div class="controls">  
		              <input name="itemcount" type="text" value="20"class="input-xlarge" id="itemcountBox">  
		            </div>  
		          </div> 		
		
		          <div class="control-group">  
		            <label class="control-label" for="select02">Select level of detail</label>  
		            <div class="controls">  
		              <select name="style" id="styleBox">  		                
						<option value="false">full visualization</option> 
		                <option value="true">preview only</option>   
		              </select>  
		            </div>  
		          </div>
		
		          <div class="form-actions">  
		            <button type="submit" class="btn btn-primary">Let's go</button>  
		            <button class="btn">Reset</button>  
		          </div>  
		        </fieldset>  
		</form>
		
		
    </div> <!-- /container -->
  </body>
</html>
