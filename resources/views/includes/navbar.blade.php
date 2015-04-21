<nav class="navbar navbar-fixed-top navbar-default">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">DNSBL</a>
    </div><!--/.navbar-header -->
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <li class="{{ (Request::is('/') ? 'active' : '') }}"><a href="/">Check</a></li>
        <li class="{{ (Request::is('api') ? 'active' : '') }}"><a href="/api">API</a></li>
        <li class="{{ (Request::is('monitor') ? 'active' : '') }}"><a href="/monitor">Monitor</a></li>
      </ul>
    </div><!--/.nav-collapse -->
  </div><!--/.container -->
</nav>
