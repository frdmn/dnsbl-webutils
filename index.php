<?php
  // Include functions
  // require_once("functions.php");

  // Include configuration file
  if (file_exists('config.php')) {
    require_once("config.php");
  } else {
    die('Error: couldn\'t find "config.php". Perhaps you didn\'t rename the example configuration yet?');
  }

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
        <p>A DNS-based Blackhole List (<i>DNSBL</i>) or Real-time Blackhole List (<i>RBL</i>) is an effort to stop email spamming. Most mail server software can be configured to reject or flag messages which have been sent from a site listed on one or more such lists.</p>
        <p>Below you can <a class="a-tooltip" href="#" data-toggle="tooltip" data-original-title="Default tooltip">mass test</a> such <i>DNSBL</i>'s against the IPs of your mail servers to possible listings.</p>
      </div><!--/.jumbotron -->

      <div class="alert alert-warning alert-dismissible alert-hint" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        Enter the IP address or hostname of your mail server below and hit <strong>Check</strong>.
      </div><!--/.alert -->

      <form class="form-horizontal form-input">
        <div class="form-group">
          <label for="inputMailserverHost" class="col-sm-2 control-label">Mail server</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="inputMailserverHost" name="inputMailserverHost" placeholder="IP address/hostname">
          </div>
        </div><!-- /.form-group -->
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default btn-submit-check">Check</button>
            <a href="" class="btn btn-danger btn-cancel-check">Cancel</a>
            <img src="assets/img/spinner.gif" class="spinner pull-right">
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
          <tbody></tbody>
        </table>
      </div><!-- /.results -->

      <div class="clearfix"></div>

      <footer>
        <hr>
        <p>Powered by <a href="https://github.com/frdmn/dnsbl-utils" target="_blank">dnsbl-utils</a> - &copy; <a href="http://frd.mn" target="_blank">frdmn</a> <?= date("Y"); ?></p>
      </footer>
    </div><!-- /.container -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/build.js"></script>
  </body>
</html>
