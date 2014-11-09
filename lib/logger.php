<?php
require_once 'storage.php';

class Logger {
    
    private static $storage;
    
    /// Sets the $storage instance.
    public static setStorageInstance($s) {
        self::$storage = $s;
    }
    
    /// If $name isn't specified, this function returns a list of all loggers.
    /// If $name is specified, it returns an instance of Logger associated with the apps $name.
    public static function get($name = null) {
        if ($name == null) return self::getList();
        
        
    }
    
    /// Returns a list of all registered loggers
    private static function getList() {
        
    }
    
    
    function __construct() {
        
    }
    
    public function append($data) {
        
    }
    
    public function fetch($query) {
        
    }
    
    public function validateDrain($token) {
        
    }
    
    /// Returns a list of all draintokens.
    public function drains() {
        
    }
    
    public function drainAdd($token) {
        
    }
    
    public function drainRemove($token) {
        
    }
    
}
