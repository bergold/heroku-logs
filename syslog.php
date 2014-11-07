<?php
$path_prefix = '\/syslog\/';

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$m = preg_match("/(?<=^$path_prefix)[a-z-]*$/", $path, $match);
if (!$m || $m == 0) {
  syslog(LOG_WARNING, "Invalid request format: $path");
  http_response_code(400);
  exit(1);
}

$app_name = $match[0];
$drain_token = $_SERVER['HTTP_LOGPLEX_DRAIN_TOKEN'];
$msg_count = $_SERVER['HTTP_LOGPLEX_MSG_COUNT'];

// [Todo] Validate app_name with drain_token by checking a config file.

$data = @file_get_contents('php://input');

// [Todo] Write the new logdata to the correct log file.

syslog(LOG_INFO, "Got $msg_count log" . ($msg_count == 1 ? "" : "s") . " from $app_name ($drain_token)");

http_response_code(204);
exit(0);
