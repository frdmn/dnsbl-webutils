<?php namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class ApiController extends BaseController
{

  /**
   * statusCodeMessage()
   *
   * Returns the specifc message of a given status code
   *
   * @param int $status status code
   * @return string $status_code_message status message
   */

  function statusCodeMessage($status){
    // Status code <-> status message map
    $status_code_map = array(
      300 => 'DNSBL: listed',
      200 => 'DNSBL: not listed',
      401 => 'API/probe: invalid IP in "hostname" GET parameter',
      402 => 'API/probe: invalid hostname input "hostname" GET parameter'
    );

    // Return messages based on input status code
    return $status_code_map[$status];
  }

  /**
   * probeDnsbl()
   *
   * Check a specific hostname against a specific DNSBL.
   *
   * @param string $host mail server
   * @param string $dnsbl sepecific DNSBL to check against
   * @return bool
   */

  function probeDnsbl($host, $dnsbl){
    $rip=implode('.',array_reverse(explode(".",$host)));
    if(checkdnsrr($rip.'.'.$dnsbl.'.','A')){
      // Listed = return false
      return false;
    } else {
      // Not listed = return true
      return true;
    }
  }

  /**
   * isValidIP()
   *
   * Small function to check if input
   * is a valid IPv4 address
   *
   * @param string $ip IPv4 address
   * @return bool
   */

  function isValidIP($ip){
    // Regex
    $validIpRegex = '^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$';

    // Check if valid IP
    if (preg_match("/$validIpRegex/", $ip)) {
      return true;
    } else {
      return false;
    }
  }

  /**
   * isValidHostname()
   *
   * Small function to check if input
   * is a valid hostname
   *
   * @param string $hostname
   * @return bool
   */

  function isValidHostname($hostname){
    // Check if valid hostname
    if (checkdnsrr($hostname)) {
      return true;
    } else {
      return false;
    }
  }

  /**
   * Route function to catch "/api/v1/check/:hostname"
   * @param string :hostname hostname/IP to check
   * @return JSON response
   */

  public function check($hostname){
    // Initialte Monolog log stream
    $monolog = new Logger('log');
    $monolog->pushHandler(new StreamHandler(storage_path('logs/dnsbl-'.date('Y-m-d').'.txt')), Logger::INFO);

    // Start timer to meassure execution time
    $time_start = microtime(true);

    // Initiate variables and arrays
    $success = true;
    $failed_probes = 0;
    $sucess_probes = 0;
    $json = array();
    $information = array();
    $dnsbl_json = array();

    // Check if $hostname is an IP address
    if (is_numeric(str_replace('.', '', $hostname))) {
      // Check if it's valid
      if (!$this->isValidIP($hostname)) {
        $status = 401;
        $success = false;
      }
    } else {
      // Otherwise check if it's a valid hostname
      if (!$this->isValidHostname($hostname)) {
        $status = 402;
        $success = false;
      } else {
        // Resolve $hostname to IP
        $hostname = gethostbyname($hostname);
      }
    }

    // Load DNSBLs from public/ folder
    $dnsbls = json_decode(file_get_contents(storage_path().'/../public/dnsbl.json'));

    // Loop over DNSBLs if success is still true
    if ($success) {
      foreach ($dnsbls->blacklists as $dnsbl) {
        // Probe against DNSBL
        if (!$this->probeDnsbl($hostname, $dnsbl)) {
          $status = 300;
          ++$failed_probes;
        } else {
          $status = 200;
          ++$sucess_probes;
        }

        // Create payload object
        $payload = array();
        $payload['dnsbl'] = $dnsbl;
        $payload['result'] = $this->statusCodeMessage($status);
        $payload['status'] = $status;

        array_push($dnsbl_json, $payload);
      }
    }

    // Stop timer to meassure execution time
    $time_end = microtime(true);

    // Add data to $information
    $information['execution_time'] = round(($time_end - $time_start) * 1000);
    $information['dnsbls_total'] = count($dnsbls->blacklists);

    // Add data to $json
    $json['success'] = $success;

    // Check if successful
    if (!$success) {
      $json['status'] = $status;
      $json['error'] = $this->statusCodeMessage($status);
      $json['information'] = $information;
    } else {
      $information['dnsbls_ok'] = $sucess_probes;
      $information['dnsbls_listed'] = $failed_probes;
      $json['information'] = $information;
    }

    $json['payload'] = $dnsbl_json;

    // Log API call if enabled in config
    if (config('config.logs.enabled')) {
      $monolog->addInfo('['.Request::ip().'] JSON result: ',$json);
    }

    // And finally return the JSON response
    return response($json, 200, [ "Content-Type" => "application/json" ]);
  }

  /**
   * Route function to catch "/api/v1/probe/:hostname/:dnsbl"
   * @param string :hostname hostname/IP to check
   * @param string :dnsbl DNSBL to check against
   * @return JSON response
   */

  public function probe($hostname, $dnsbl){
    // Initialte Monolog log stream
    $monolog = new Logger('log');
    $monolog->pushHandler(new StreamHandler(storage_path('logs/dnsbl-'.date('Y-m-d').'.txt')), Logger::INFO);

    // Check if $hostname is an IP address
    if (is_numeric(str_replace('.', '', $hostname))) {
      // Check if it's valid
      if (!$this->isValidIP($hostname)) {
        $status = 401;
      }
    } else {
      // Otherwise check if it's a valid hostname
      if (!$this->isValidHostname($hostname)) {
        $status = 402;
      } else {
        $hostname = gethostbyname($hostname);
      }
    }

    // Probe against DNSBL
    if (!isset($status)) {
      if (!$this->probeDnsbl($hostname, $dnsbl)) {
        $status = 300;
      } else {
        $status = 200;
      }
    }

    // Check if successful
    if ($status > 300) {
      $success = false;
    } else {
      $success = true;
    }

    // Create payload object
    $payload = array();
    $payload['host'] = $hostname;
    $payload['dnsbl'] = $dnsbl;
    $payload['result'] = $this->statusCodeMessage($status);
    $payload['status'] = $status;

    $json = array();
    $json['payload'] = $payload;
    $json['success'] = $success;

    // Log API call if enabled in config
    if (config('config.logs.enabled')) {
      $monolog->addInfo('['.Request::ip().'] JSON result: ',$json);
    }

    // And finally return the JSON response
    return response($json, 200, [ "Content-Type" => "application/json" ]);
  }
}
