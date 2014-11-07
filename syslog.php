<?php
$path_prefix = '\/syslog\/';

$data = '';
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$m = preg_match("/(?<=^$path_prefix)[a-z-]*$/", $path, $m);
if (!$m || $m == 0) {
  syslog(LOG_WARNING, "Invalid requestformat: $path");
  http_response_code(400);
  exit(1);
}
$header = http_get_request_headers();
  array_walk($final, function($val, $key) use(&$data){
  	$data .= "$val: $key;";
});
$data .= @file_get_contents('php://input');

syslog(LOG_DEBUG, $data);
