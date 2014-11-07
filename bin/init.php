<?php
require_once 'lib/storage.php';

$sh = Storage::fromDefaultBucket();

unlink($sh->buildPath('logs/iniii.log'));
unlink($sh->buildPath('logs/ricochetrobots.log'));

$sh->fileWrite('logs/iniii.log', '\nApphend');
