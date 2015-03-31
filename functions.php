<?php
  // Function to probe a specific DNSBL
  function probe_dnsbl($ip, $dnsbl) {
    if (!isset($ip)) {
      return 401;
    }
    if (!isset($dnsbl)) {
      return 402;
    }
    if($ip && $dnsbl){
      $rip=implode('.',array_reverse(explode(".",$ip)));
      if(checkdnsrr($rip.'.'.$dnsbl.'.','A')){
        return 300;
      }
    }
    return 200;
  }
?>
