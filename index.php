<?php
  // Include configuration file
  if (file_exists('config.php')) {
    require_once("config.php");
  } else {
    die('Error: couldn\'t find "config.php". Perhaps you didn\'t rename the example configuration yet?');
  }

  // Create URI constant
  $uri = "http".(!empty($_SERVER['HTTPS'])?"s":"")."://".$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME'];

  // Check for any passed actions
  if (!isset($_GET['action']) || empty($_GET['action'])) {
    // Redirect to default "check" if none set
    header('Location: '.$uri.'?action=check');
    exit;
  } else {
    // Store action for later use
    $action = $_GET['action'];
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

    <title><?= $settings['title'] ?> - <?= ucfirst($_GET['action']) ?></title>

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
            <?php
              $navbarPages = array( 'check' );
              foreach ($navbarPages as $navbarPage) {
                if ($action == $navbarPage) {
                  $possibleActiveClass = 'active';
                } else {
                  $possibleActiveClass = '';
                }
                echo '<li class="'.$possibleActiveClass.'"><a href="'.$uri.'?action='.$navbarPage.'">'.ucfirst($navbarPage).'</a></li>';
              }
            ?>
          </ul>
        </div><!--/.nav-collapse -->
      </div><!--/.container -->
    </nav>

    <div class="container theme-showcase container--<?= $action ?>" role="main">
      <?php
        if (file_exists('views/'.$action.'.php')) {
          include('views/'.$action.'.php');
        } else {
      ?>
        <div class="alert alert-danger" role="alert">
          Couldn't find view "<?= $action ?>". Maybe try the <a href="<?=$uri?>">main page</a> instead?
        </div><!--/.alert -->
      <?php
        }
      ?>

      <div class="clearfix"></div>

      <footer>
        <hr>
        <p>Powered by <a href="https://github.com/frdmn/dnsbl-webutils" target="_blank">dnsbl-webutils</a> - &copy; <a href="http://frd.mn" target="_blank">frdmn</a> <?= date("Y"); ?></p>
      </footer>
    </div><!-- /.container -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/build.js"></script>
  </body>
</html>
