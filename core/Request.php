<?php

// namespace core;

// class Request {
//     public static function url(){
//         return $_SERVER['QUERY_STRING'];

//     }
//     public static function method(){

//         return $_SERVER['REQUEST_METHOD'];
//     }


// }

namespace Core;

class Request
{
    public static function url()
    {
        return trim($_SERVER['REQUEST_URI'], '/');
    }

    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}

?>