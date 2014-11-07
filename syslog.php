<?php
$data = @file_get_contents('php://input');

syslog(LOG_DEBUG, $data);
