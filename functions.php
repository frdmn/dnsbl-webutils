<?php
  // Function to probe a specific DNSBL
  function probe_dnsbl($ip, $dnsbl) {
    // Check if first ($ip) argument is set properly
    if (!isset($ip)) {
      return 401;
    }
    // Check if second ($dnsbl) argument is set properly
    if (!isset($dnsbl)) {
      return 402;
    }
    if($ip && $dnsbl){
      // Check for valid IP
      if(!filter_var($ip, FILTER_VALIDATE_IP)) {
        return 403;
      }

      $rip=implode('.',array_reverse(explode(".",$ip)));
      if(checkdnsrr($rip.'.'.$dnsbl.'.','A')){
        // Listed!
        return 300;
      }
    }
    // Not listed
    return 200;
  }
?>
