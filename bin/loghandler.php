<?php
require_once 'lib/util.php';
require_once 'lib/storage.php';
require_once 'lib/logger.php';

$app_name = get_appname();
$drain_token = $_SERVER["HTTP_LOGPLEX_DRAIN_TOKEN"];
$msg_count = $_SERVER["HTTP_LOGPLEX_MSG_COUNT"];

if ($app_name === false) {
    syslog(LOG_WARNING, "Invalid request format: $path.");
    http_response_code(400);
    exit(1);
}

$data = @file_get_contents("php://input");

$storage_handle = Storage::fromDefaultBucket("/logs/");
Logger::setStorageInstance($storage_handle);

$logger = Logger::get($app_name);
if ($logger === false) {
    syslog(LOG_WARNING, "For the app '$app_name' is no logger registered.");
    http_response_code(404);
    exit(1);
}

$valid = $logger->validateDrain($drain_token);
if (!$valid) {
    syslog(LOG_WARNING, "$drain_token is no valid token for $app_name.");
    http_response_code(403);
    exit(1);
}

$succeed = $logger->append($data);
if (!$succeed) {
    syslog(LOG_ERR, "Appending the data to the logs failed.");
    http_response_code(500);
    exit(2);
}

syslog(LOG_INFO, "Got $msg_count log" . ($msg_count == 1 ? "" : "s") . " from $app_name ($drain_token).");

http_response_code(204);
exit(0);
