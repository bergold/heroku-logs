<?php
use google\appengine\api\cloud_storage\CloudStorageTools;

class Storage {
    
    /// Creates a new Storage instance providing access to the deault bucket.
    public static function fromDefaultBucket($pathprefix = '/') {
        $default_bucket = CloudStorageTools::getDefaultGoogleStorageBucketName();
        if ($default_bucket == '') throw new Exception('No default bucket defined');
        return new Storage($default_bucket, $pathprefix);
    }
    
    private $bucket;
    
    function __construct($bucket, $pathprefix = '/') {
        $this->bucket = $bucket . $pathprefix;
    }
    
    public function buildPath($path = '') {
        return "gs://{$this->bucket}$path";
    }
    
    public function buildContext($ctx) {
        return stream_context_create([
            'gs' => $ctx
        ]);
    }
    
    public function dirRead($path = '') {
        
    }
    
    public function fileRead($file) {
        return file_get_contents($this->buildPath($file));
    }
    
    public function fileWrite($file, $content, $ctx = null) {
        if ($ctx == null)
            return file_put_contents($this->buildPath($file), $content);
        else
            return file_put_contents($this->buildPath($file), $content, 0, $this->buildContext($ctx));
    }
    
    public function fileAppend($file, $content) {
        $path = $this->buildPath($file);
        $data = file_exists($path) ? $this->fileRead($file) : '';
        $data .= $content;
        return $this->fileWrite($file, $data);
    }
    
}
