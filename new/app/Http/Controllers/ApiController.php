<?php namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Input;

class ApiController extends BaseController
{

  /*
   * statusCodeMessage()
   *
   * Returns the specifc message of a given status code
   *
   * @param int $status status code
   * @return string $status_code_message status message
   */

  function statusCodeMessage($status){
    $status_code_map = array(
      300 => 'DNSBL: listed',
      200 => 'DNSBL: not listed',
      401 => 'API/check: missing "host" GET parameter',
      402 => 'API/check: missing "dnsbl" GET parameter',
      403 => 'API/check: invalid input "host" GET parameter'
    );

    return $status_code_map[$status];
  }

  /*
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

  public function check(){
    $host = Input::get('host');
    $dnsbl = Input::get('dnsbl');

    if (empty($host)) {
      $status = 401;
    }

    if (empty($dnsbl)) {
      $status = 402;
    }

    if (!isset($status)) {
      if (!$this->probeDnsbl($host, $dnsbl)) {
        $status = 300;
      } else {
        $status = 200;
      }
    }

    if ($status > 300) {
      $success = false;
    } else {
      $success = true;
    }

    $payload = array();
    $payload['host'] = $host;
    $payload['dnsbl'] = $dnsbl;
    $payload['result'] = $this->statusCodeMessage($status);
    $payload['status'] = $status;

    $json = array();
    $json['payload'] = $payload;
    $json['success'] = $success;

    return response($json, 200, [ "Content-Type" => "application/json" ]);
  }
}
