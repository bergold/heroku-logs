<?php

// class Router
class Router {
    
    private $path = "";
    private $matched = false;
    
    function __construct($path) {
        $this->path = $path;
    }
    
    public function when($method, $path, $handler) {
        if ($this->matched) return;
        
        if (!$this->validateMethod($method)) return;
        
        $route = $this->pathRegExp($path);
        $route['handler'] = $handler;
        
        $params = $this->switchRouteMatcher($this->path, $route);
        
        if (false !== $params) {
            $this->matched = true;
            call_user_func($handler, $params);
        }
    }
    
    public function any($path, $handler) { return $this->when("any", $path, $handler); }
    public function get($path, $handler) { return $this->when("get", $path, $handler); }
    public function post($path, $handler) { return $this->when("post", $path, $handler); }
    public function put($path, $handler) { return $this->when("put", $path, $handler); }
    public function delete($path, $handler) { return $this->when("delete", $path, $handler); }
    
    public function otherwise($handler) {
        if ($this->matched) return;
        
        call_user_func($handler);
    }
    
    private function validateMethod($expected) {
        $expected = strtoupper($expected);
        $real = strtoupper($_SERVER["REQUEST_METHOD"]);
        if ($expected == "ANY") return true;
        return $expected == $real;
    }
    
    private function pathRegExp($path) {
        $ret = array(
            "originalPath" => $path,
            "regexp"       => $path
        );
        $keys = array();
        $callback = function($matches) use (&$keys) {
            $_      = $matches[0];
            $slash  = isset($matches[1]) ? $matches[1] : null;
            $key    = isset($matches[2]) ? $matches[2] : null;
            $option = isset($matches[3]) ? $matches[3] : null;
            $optional = ($option === "?") ? $option : null;
            $star     = ($option === "*") ? $option : null;
            $slash    = $slash ? $slash : '';
            array_push($keys, array("name" => $key, "optional" => !!$optional));
            return ''
                . ($optional ? '' : $slash)
                . '(?:'
                . ($optional ? $slash : '')
                . ($star ? '(.+?)' : '([^/]+)')
                . ($optional ? $optional : '')
                . ')'
                . ($optional ? $optional : '');
        };
        $path = preg_replace("/([().])/", "\\\\$1", $path);
        $path = preg_replace_callback("/(\/)?:(\w+)([\?\*])?/", $callback, $path);
        $path = preg_replace("/([\/$\*])/", "\\\\$1", $path);
        $ret['regexp'] = "/^" . $path . "$/i";
        $ret['keys'] = $keys;
        return $ret;
    }
    
    private function switchRouteMatcher($on, $route) {
        $keys = $route['keys'];
        $params = array();
        
        if (!$route['regexp']) return false;
        
        preg_match($route['regexp'], $on, $m);
        if (!$m) return false;
        
        for ($i = 1; $i < count($m); ++$i) {
            $key = $keys[$i - 1];
            
            $val = gettype($m[$i]) == 'string' ? urldecode($m[$i]) : $m[$i];
            if ($key && $val) {
                $params[$key['name']] = $val;
            }
        }
        return $params;
    }
    
}
