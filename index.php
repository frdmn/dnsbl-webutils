<?php
  // Include functions
  // require_once("functions.php");

  // Include configuration file
  require_once("config.php");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="assets/img/favicon.ico">

    <title><?php echo $settings['title'] ?></title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/style.css" rel="stylesheet">
  </head>

  <body role="document">
    <!-- Fixed navbar -->
    <nav class="navbar navbar-fixed-top <?php echo (isset($theme['navbar-dark']) && $theme['navbar-dark'] ? 'navbar-inverse' : 'navbar-default' ) ?>">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo $settings['website'] ?>">DNSBL Monitor</a>
        </div><!--/.navbar-header -->
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Check</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div><!--/.container -->
    </nav>

    <div class="container theme-showcase" role="main">

      <!-- Main jumbotron for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1>DNSBL Monitor</h1>
      </div><!--/.jumbotron -->

      <p>test</p>

      <footer>
        <hr>
        <p>&copy; frdmn 2015 - <a href="https://github.com/frdmn/dnsbl-monitor" target="_blank">dnsbl-monitor</a></p>
      </footer>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/build.js"></script>
  </body>
</html>
