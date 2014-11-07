<?php
require_once 'lib/util.php';
require_once 'lib/storage.php';

$app_name = get_appname();
$drain_token = $_SERVER['HTTP_LOGPLEX_DRAIN_TOKEN'];
$msg_count = $_SERVER['HTTP_LOGPLEX_MSG_COUNT'];

if ($app_name === false) {
  syslog(LOG_WARNING, "Invalid request format: $path");
  http_response_code(400);
  exit(1);
}

// [Todo] Validate app_name with drain_token by checking a config file.

$data = @file_get_contents('php://input');

$storage_handle = Storage::fromDefaultBucket();
$storage_handle->fileAppend("logs/$app_name.log", ["\n", $data]);

syslog(LOG_INFO, "Got $msg_count log" . ($msg_count == 1 ? "" : "s") . " from $app_name ($drain_token)");

http_response_code(204);
exit(0);
