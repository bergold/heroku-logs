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
        $this->bucket = $bucket;
    }
    
    public function fileRead($file) {
        return file_get_contents($this->buildPath($file));
    }
    
    public function fileWrite($file, $content, $ctx = null) {
        return file_put_contents($this->buildPath($file), $content, 0, $this->gsContext($ctx));
    }
    
    public function fileAppend($file, $content) {
        $fh = fopen($this->buildPath($file), 'a');
        if ($fh === false) throw new Exception('File could not be opened.');
        fwrite($fh, $content);
        fclose($fh);
        return true;
    }
    
    public function buildPath($path = '') {
        return "gs://{$this->bucket}/$path";
    }
    
    public function gsContext($ctx = null) {
        if ($ctx == null) $ctx = ['Content-Type' => 'text/plain'];
        return stream_context_create([
            'gs' => $ctx,
        ]);
    }
    
}
