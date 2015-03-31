<?php
  // Include functions
  require_once("functions.php");

  // Disable notice errors that might break JSON
  error_reporting(E_ALL ^ E_NOTICE);

  // Define status/error code dictionary
  $status_codes = array(
    '300' => 'listed',
    '200' => 'not listed',
    '401' => 'missing "ip" GET parameter',
    '402' => 'missing "dnsbl" GET parameter',
    '403' => 'invalid IP format',
  );

  // Check for GET variables
  if (!isset($_GET['ip'])) {
    $error_message = '"ip" GET request is missing';
  }
  if (!isset($_GET['dnsbl'])) {
    $error_message = '"dnsbl" GET request is missing';
  }

  // Create empty array
  $json = array();

  $dnsbl_result=probe_dnsbl($_GET['ip'], $_GET['dnsbl']);

  // Check DNSBL result
  if (isset($dnsbl_result)) {
    // Check for error codes
    if ($dnsbl_result == 401 || $dnsbl_result == 402 || $dnsbl_result == 403 ) {
      $error_message = $status_codes[$dnsbl_result];
    // if no error, store returned data
    } elseif ($dnsbl_result == 200 || $dnsbl_result == 300) {
      $result_json = array();
      $result_json['ip'] = $_GET['ip'];
      $result_json['dnsbl'] = $_GET['dnsbl'];
      $result_json['result'] = $dnsbl_result;
      $json['payload'] = $result_json;
    // Otherwise return generic error message
    } else {
      $error_message = "probe_dnsbl() returned unknown error code";
    }
  }

  // Check for possible errors
  if (isset($error_message)) {
    $json['success'] = false;
    $json['error'] = $error_message;
  } else {
    $json['success'] = true;
  }

  // Encode to JSON and display
  echo json_encode($json);
?>
