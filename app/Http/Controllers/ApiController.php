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
      401 => 'API/check: missing "host" GET parameter',
      402 => 'API/check: missing "dnsbl" GET parameter',
      403 => 'API/check: invalid input "host" GET parameter'
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
   * Route function to catch "/api/v1/check"
   * @param ignored
   * @return JSON response
   */

  public function check(){

    // Initialte Monolog log stream
    $monolog = new Logger('log');
    $monolog->pushHandler(new StreamHandler(storage_path('logs/dnsbl-'.date('Y-m-d').'.txt')), Logger::INFO);

    // Store input GET parameters
    $host = Input::get('host');
    $dnsbl = Input::get('dnsbl');

    // Return error if empty
    if (empty($host)) {
      $status = 401;
    }

    if (empty($dnsbl)) {
      $status = 402;
    }

    // Probe against DNSBL
    if (!isset($status)) {
      if (!$this->probeDnsbl($host, $dnsbl)) {
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
    $payload['host'] = $host;
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
