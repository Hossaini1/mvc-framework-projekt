<?php

namespace Core;

class Error
{
    public static function errorHandler($level, $message, $file, $line)
    {
        if (error_reporting() !== 0) {
            throw new \Exception($message, 0, $level,  $file, $line);
        }
    }

    public static function exceptionHandler($exception)
    {
        $code = $exception->getCode();

        if ($code != 404) {
            $code = 500;
        }

        http_response_code($code);

        if (Config::SHOW_ERRORS) {
            echo "<h1>Error1</h1>";
            echo "<p>exeption : " . get_class($exception) . "</p>";
            echo "<p>message :" . $exception->getMessage() . "</p>";
            echo "<p>trace: <pre>" . $exception->getTraceAsString() . "</pre> </p>";
            echo "<p> in : " . $exception->getFile() . " on line " . $exception->getLine() . " </p>";
        } else {
            $log = dirname(__DIR__) . "/logs/" . date('Y-M-D') . 'txt';
            ini_set("error_log", $log);

            $message = " Exception : " . get_class($exception);
            $message .= " Message : " . $exception->getMessage();
            $message .= " Exception : " . $exception->getTraceAsString();
            $message .=  "in : " . $exception->getFile() . " on line " . $exception->getLine();

            error_log($message);

            View::render("$code.html");
        }
    }
}
