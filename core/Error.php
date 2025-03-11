<?php 
namespace Core;

class Error{

    public static function exeptionHandler($exeption){
        $code = $exeption->getCode();

        if($code != 404){
            $code = 500;

        }

        http_response_code($code);

        if (Config::SHOW_ERRORS) {
            
        }else{
            
        }
    }
}

?>