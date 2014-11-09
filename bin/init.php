<?php
require_once 'lib/storage.php';
require_once 'lib/logger.php';

header('Content-Type: text/plain');

$sh = Storage::fromDefaultBucket('/logs/');
Logger::setStorageInstance($sh);

Logger::remove('ricochet-robots');
Logger::remove('ricochetrobots');

Logger::create('ricochet-robots');
Logger::create('ricochetrobots');
