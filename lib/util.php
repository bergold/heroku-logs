<?php

function get_appname($prefix = '\/syslog\/') {
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $m = preg_match("/(?<=^$prefix)[a-z-]*$/", $path, $match);
    if (!$m || $m == 0) return false;
    return $match[0];
}
