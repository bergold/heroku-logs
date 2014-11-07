<?php
use google\appengine\api\cloud_storage\CloudStorageTools;

class Storage {
    
    public static function fromDefaultBucket() {
        $default_bucket = CloudStorageTools::getDefaultGoogleStorageBucketName();
        if ($default_bucket == '') throw new Exception('No default bucket defined');
        return new Storage($default_bucket);
    }
    
    private $bucket;
    
    function __construct($bucket) {
        $this->$bucket = $bucket;
    }
    
    public function fileRead($file) {
        return file_get_contents($this->buildPath($file));
    }
    
    public function fileWrite($file, $content) {
        return file_put_contents($this->buildPath($file), $content);
    }
    
    public function fileAppend($file, $content) {
        return file_put_contents($this->buildPath($file), $content, FILE_APPEND);
    }
    
    public function buildPath($path = '') {
        return "gs://" . $this->$bucket . "/$path";
    }
    
}
