<?php

namespace Core;

class Request {
    public static function url(){
        return $_SERVER['QUERY_STRING'];

    }
    public static function method(){

        return $_SERVER['REQUEST_METHOD']
    }


}

?>