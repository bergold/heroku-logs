<?php

function path($prefix = "") {
    $path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    if ($prefix == "") return $path;
    $regex = "/^" . preg_quote($prefix, "/") . "/";
    return preg_replace($regex, "", $path);
}

function get_appname($prefix = "/syslog/") {
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $prefix = preg_quote($prefix, "/");
    $m = preg_match("/(?<=^$prefix)[a-z-]*$/", $path, $match);
    if (!$m || $m == 0) return false;
    return $match[0];
}

function newline_ifabsent($str) {
    $str = rtrim($str, "\r\n");
    return $str . "\n";
}
