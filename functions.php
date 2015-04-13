<?php
  // Function to write to log
  function write_log($message, $logfile='') {
    // Determine log file
    if($logfile == '') {
      // checking if the constant for the log file is defined
      if (defined(DEFAULT_LOG) == TRUE) {
          $logfile = DEFAULT_LOG;
      }
      // the constant is not defined and there is no log file given as input
      else {
          error_log('No log file defined!',0);
          return array('status' => false, message => 'No log file defined!');
      }
    }

    // Get time of request
    if( ($time = $_SERVER['REQUEST_TIME']) == '') {
      $time = time();
    }

    // Get IP address
    if( ($remote_addr = $_SERVER['REMOTE_ADDR']) == '') {
      $remote_addr = "REMOTE_ADDR_UNKNOWN";
    }

    // Format the date and time
    $date = date("Y-m-d H:i:s", $time);

    // Append to the log file
    if($fd = @fopen($logfile, "a")) {
      $result = fputcsv($fd, array($date, $remote_addr, $message));
      fclose($fd);

      if($result > 0)
        return array('status' => true);
      else
        return array('status' => false, 'message' => 'Unable to write to '.$logfile.'!');
    }
    else {
      return array('status' => false, 'message' => 'Unable to open log '.$logfile.'!');
    }
  }
?>
