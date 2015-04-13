<?php

  /**
  * This is the general configuaration file for dnsbl-webutils.
  **/

  date_default_timezone_set("Europe/Berlin"); // Set default timezone for date()

  // General

  $settings['title'] = "DNSBL";

  # Enable log files in "logs/"
  # (make sure the web server is allowed to create files in that directory)
  $settings['logs']['enabled'] = false;

  // Design

  $theme['navbar-dark'] = false; // Enable dark theme for the navbar
  $theme['jumbotron'] = true; // Display jumbotron
  $theme['explanation'] = true; // DNSBL explanation in jumbotron

?>
