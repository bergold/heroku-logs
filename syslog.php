<?php
$data = '';
$header = getallheaders();
  array_walk($final, function($val, $key) use(&$data){
	$data .= "$val: $key;";
});
$data .= @file_get_contents('php://input');

syslog(LOG_DEBUG, $data);
