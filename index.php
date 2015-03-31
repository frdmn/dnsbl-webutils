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

    <title><?= $settings['title'] ?></title>

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
          <a class="navbar-brand" href="#"><?= $settings['title'] ?></a>
        </div><!--/.navbar-header -->
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="">Check</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div><!--/.container -->
    </nav>

    <div class="container theme-showcase" role="main">

      <!-- Main jumbotron for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1><?= $settings['title'] ?></h1>
      </div><!--/.jumbotron -->

      <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        Enter the hostname or the IP address of your mail server below and hit <strong>Check</strong>.
      </div><!--/.alert -->

      <form class="form-horizontal">
        <div class="form-group">
          <label for="inputMailserver" class="col-sm-2 control-label">Mail server</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="inputMailserver" placeholder="Hostname/IP address">
          </div>
        </div><!-- /.form-group -->
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default btn-submit-check">Check</button>
            <a href="" class="btn btn-danger btn-abort-check">Abort</a>
          </div>
        </div><!-- /.form-group -->
      </form><!-- /.form-horizontal -->

      <div class="clearfix"></div>

      <div class="results">
        <hr/>
        <table class="table">
          <thead>
            <tr>
              <th></th>
              <th>Blacklist</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
      </div><!-- /.results -->

      <div class="clearfix"></div>

      <footer>
        <hr>
        <p>Powered by <a href="https://github.com/frdmn/dnsbl-monitor" target="_blank">dnsbl-monitor</a> - &copy; <a href="http://frd.mn" target="_blank">frdmn</a> <?= date("Y"); ?></p>
      </footer>
    </div><!-- /.container -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/build.js"></script>
  </body>
</html>
