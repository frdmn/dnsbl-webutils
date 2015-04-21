<!DOCTYPE html>
<html lang="en">
  <head>
    @include('includes.head')
  </head>

  <body role="document">
    <!-- Fixed navbar -->
    @include('includes.navbar')

    <div class="container theme-showcase container--check" role="main">
      @yield('content')

      @include('includes.footer')
    </div><!-- /.container -->

      <!-- Bootstrap core JavaScript
      ================================================== -->
      <!-- Placed at the end of the document so the pages load faster -->
      <script src="assets/js/modernizr.js"></script>
      <script src="assets/js/build.js"></script>
    </body>
  </html>
