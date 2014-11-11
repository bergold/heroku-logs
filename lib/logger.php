<?php
require_once 'storage.php';

stream_context_set_default([
    "gs" => [ "Content-Type" => "text/plain" ]
]);

class Logger {
    
    private static $storage = null;
    
    /// Sets the $storage instance.
    public static function setStorageInstance($s) {
        self::$storage = $s;
    }
    
    /// Returns the Socket instance.
    /// Throws an Exception if no Socket instance is set.
    public static function getStorageInstance() {
        if (self::$storage == null) throw new Exception("No Storage instance set.");
        return self::$storage;
    }
    
    /// If $name isn't specified, this function returns a list of all loggers.
    /// If $name is specified, it returns an instance of Logger associated with the apps $name.
    public static function get($name = null) {
        if ($name == null) return self::getList();
        
        $sh = self::getStorageInstance();
        $file = $name . ".log";
        if (!$sh->fileExists($file)) return false;
        return new Logger($file);
    }
    
    /// Returns a list of all registered loggers
    private static function getList() {
        $sh = self::getStorageInstance();
        $loggers = array();
        foreach ($sh->dirRead() as $file) {
            $loggers[] = new Logger($file);
        }
        return $loggers;
    }
    
    /// Creates a new logger.
    /// This function creates a new log file and returns the Logger instance.
    /// It returns false if the name is not available or writing the file fails.
    public static function create($name) {
        if (self::get($name) !== false) return false;
        $sh = self::getStorageInstance();
        $file = $name . ".log";
        $succeed = $sh->fileWrite($file, '');
        if ($succeed === false) return false;
        return new Logger($file);
    }
    
    /// Removes a logger.
    /// This function removes the log file and makes it so unavailable for logging.
    public static function remove($name) {
        $sh = self::getStorageInstance();
        $file = $name . ".log";
        return $sh->fileDelete($file);
    }
    
    private $file;
    
    function __construct($file) {
        $this->file = $file;
    }
    
    public function getName() {
        return substr($this->file, 0, -4);
    }
    
    public function append($data) {
        return self::getStorageInstance()->fileAppend($this->file, $data);
    }
    
    public function fetch($query) {
        return self::getStorageInstance()->fileRead($this->file);
    }
    
    public function validateDrain($token) {
        return true;
    }
    
    /// Returns a list of all draintokens.
    public function drains() {
        
    }
    
    public function drainAdd($token) {
        
    }
    
    public function drainRemove($token) {
        
    }
    
}
