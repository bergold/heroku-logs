<?php

// class Router
class Router {
    
    private $path = "";
    private $matched = false;
    
    function __construct($path) {
        $this->path = $path;
    }
    
    public function when($path, $handler) {
        if ($this->matched) return;
        
        $route = $this->pathRegExp($path);
        $route['handler'] = $handler;
        
        $params = $this->switchRouteMatcher($this->path, $route);
        
        if (false !== $params) {
            $this->matched = true;
            call_user_func($handler, $params);
        }
    }
    
    public function otherwise($handler) {
        if ($this->matched) return;
        
        call_user_func($handler);
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
