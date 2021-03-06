
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
		  <li>
		    <a href="uploadorchoose.php">... take the information from the MYSQL DB</a>
		  </li>
		  <li class="active"><a href="uploadown.php">... no, let me upload my own gexf file</a></li>
		</ul>
		<hr>
		Please make sure, that your file has the following properties:
		<ul>
		  <li>Every edge has a value for weight (e.g. &lt;edge id=&quot;...&quot; source=&quot;...&quot; target=&quot;...&quot; weight=&quot;some integer&quot;/&gt;)</li>
		  <li>You have integer dates at your nodes (e.g. &lt;node id=&quot;...&quot; label=&quot;...&quot; start=&quot;some integer&quot;/&gt;)</li>
		</ul>
		
		<form action="vizz_neu.php" method="get" class="form-horizontal">  
		        <fieldset>  
		          <legend>Ok, now we need a file to work with ...</legend>  
		          <div class="control-group">  
		            <label class="control-label" for="input01">... which is somewhere on the web</label>  
		            <div class="controls">  
		              <input type="text" name="url" value="input your link to your gexf file" class="input-xlarge" id="urlinput">  
		            </div>  
		          </div>    
 					<input type='hidden' name='type' value='node' />
		          <div class="form-actions">  
		            <button type="submit" id="submitButton" class="btn btn-primary">Upload and visualize</button>  
		            <button class="btn">Reset</button>  
		          </div>  
		        </fieldset>  
		</form>
    </div> <!-- /container -->
  </body>
</html>
