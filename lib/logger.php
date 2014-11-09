<?php
require_once 'storage.php';

class Logger {
    
    private static $storage = null;
    
    /// Sets the $storage instance.
    public static function setStorageInstance($s) {
        self::$storage = $s;
    }
    
    /// Returns the Socket instance.
    /// Throws an Exception if no Socket instance is set.
    public static function getStorageInstance() {
        if (self::$storage == null) throw new Exception("No Storage instance sed.");
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
        
    }
    
    private $file;
    
    function __construct($file) {
        $this->file = $file;
    }
    
    public function append($data) {
        return self::getStorageInstance()->fileAppend($this->file, $data);
    }
    
    public function fetch($query) {
        
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
