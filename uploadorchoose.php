
<!DOCTYPE html>
<html lang="en">
  <head>
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
	
	<?php
		include("include/db.php"); // .htaccess secured :)
	?>
	
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
		  <li class="active">
		    Upload or choose
		  </li>
		</ul>
		<h2>Hold on! We are not ready yet ...</h2>
		GEXFVizz can use a MYSQL database to create GEXF files about some conferences or you can <br>
		upload your own files to visualize them. It's up to you ...
		<ul class="nav nav-pills">
		  <li class="active">
		    <a href="uploadorchoose.php">... take the information from the MYSQL DB</a>
		  </li>
		  <li><a href="uploadown.php">... no, let me upload my own gexf file</a></li>
		</ul>
		
		<hr>

		<form class="form-horizontal" action="download_extern.php" method="post">  
		        <fieldset>  
		          <legend>Still, some configuration is needed</legend>  
		          <div class="control-group">  
		            <label class="control-label" for="select0">Select conference series</label>  
		            <div class="controls">  
		              <select name="conferenceseries" id="select0">  
						<?php
							$result = mysql_query("SELECT text FROM eventseries");
							while($row = mysql_fetch_object($result)){
						  		echo "<option>".$row->text."</option>";
							}	
						?>
		              </select>  
		            </div>  
		          </div>
				
		          <div class="control-group">  
		            <label class="control-label" for="input01">Start year</label>  
		            <div class="controls">  
		              <input name="syear" type="text" value="2006"class="input-xlarge" id="startyear">  
		            </div>  
		          </div> 
		 
		          <div class="control-group">  
		            <label class="control-label" for="input02">End year</label>  
		            <div class="controls">  
		              <input name="eyear" type="text" value="2012" class="input-xlarge" id="endyear">  
		            </div>  
		          </div>
		
		          <div class="control-group">  
		            <label class="control-label" for="select01">Select metric</label>  
		            <div class="controls">  
		              <select name="chosenmetric" id="metric">  		                
						<option>co-authorship</option> 
		                <option>co-citation</option>  
		                <option>bibliographic coupling</option>  
		              </select>  
		            </div>  
		          </div>
		
		          <div class="control-group">  
		            <label class="control-label" for="optionsCheckbox">Visualize with Sigma.js</label>  
		            <div class="controls">  
		              <label class="checkbox">  
		                <input type="checkbox" name="checkedSigma" id="sigma" value="true" checked>  
		                Check this, if you want to get a whole graph
		              </label>  
		            </div>  
		          </div>  
 
		          <div class="control-group">  
		            <label class="control-label" for="optionsCheckbox">Visualize with Circos</label>  
		            <div class="controls">  
		              <label class="checkbox">  
		                <input type="checkbox" name="checkedCircos" id="circos" value="true">  
		                Check this, if you want to get a circular layout
		              </label>  
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
