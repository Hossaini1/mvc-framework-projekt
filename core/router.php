<?php
// In PHP ist ein Namespace ein Weg, um Klassen, Funktionen und Konstanten zu gruppieren und Namenskonflikte zu vermeiden. Es ist besonders nützlich, wenn du große Projekte entwickelst oder Bibliotheken verwendest// zb. hier haben wir gesagt die klassen namen gehoren nur zu diesem pfad core.
namespace core;

use Exception;

class Router
{
    // Die Methode load ist eine statische Methode, d.h., sie kann aufgerufen werden, ohne eine Instanz der Klasse Router zu erstellen.
    // Ihr Zweck ist es, eine Instanz der Router-Klasse zu erstellen und zurückzugeben.

    public $routes = ['GET' => [], 'POST' => []];
    // alle route kommen in array routes rein

    public static function load($file)
    {

        $router = new static;

        require $file;
        return $router;
    }

    public function get($url, $controller)
    {
        $this->routes['GET'][$url] = $controller;
    }

    public function post($url, $controller)
    {
        $this->routes['POST'][$url] = $controller;
    }

    public function direct($url, $requestType)
    {
        if (array_key_exists($url, $this->routes[$requestType])) {
            return $this->callAction(
                ...explode('@', $this->routes[$requestType][$url])
            );
        }

        foreach ($this->routes[$requestType] as $key => $value) { 
            $pattern = "@^" . preg_replace('/{([\w]+)}/', '([\w]+)' ,$key). "$@D";
            // preg_replace ist eine Funktion in PHP, die verwendet wird, um Zeichenketten (Strings) basierend auf einem regulären Ausdruck (Regex) zu durchsuchen und zu ersetzen. Das Konzept dahinter ist, dass du einen Suchmuster (Regex) definierst, und alle Teile des Strings, die diesem Muster entsprechen, werden durch einen anderen String ersetzt. // preg_replace($muster, $ersatz, $eingabe);
            // Dieser reguläre Ausdruck würde dann auf einen String passen, der aus einem oder mehr alphanumerischen Zeichen besteht, z.B. "123" oder "abc".
            preg_match($pattern, $url, $matches);

            array_shift($matches);
            
            if ($matches) {
               $action = explode("@",$value);
               return $this->callAction($action[0], $action[1],$matches);
            }
        }
    }

    // public function direct($url, $requestType)
    // {
    //     var_dump($url); // Debugging: Zeige die angeforderte URL an
    //     var_dump($this->routes); // Debugging: Zeige alle registrierten Routen an
    
    //     foreach ($this->routes[$requestType] as $key => $value) {
    //         $pattern = "@^" . preg_replace('/{([\w]+)}/', '([\w]+)', $key) . "$@D";
    //         preg_match($pattern, $url, $matches);
    
    //         array_shift($matches);
    
    //         if ($matches) {
    //             var_dump($matches); // Debugging: Zeige die extrahierte ID an
    //             $action = explode("@", $value);
    //             return $this->callAction($action[0], $action[1], $matches);
    //         }
    //     }
    
    //     echo "Route nicht gefunden!"; // Debugging: Zeige an, wenn keine Route gefunden wurde
    // }

    // public function callAction($controller, $action, $vars = [])
    // {
    //     $controller = "App\\Controllers\\{$controller}";
    //     $controller = new $controller;
    //     if (!method_exists($controller, $action)) {
    //         throw new Exception("{$controller} not {$action} action !!!");
    //         // In PHP ist Exception ein zentrales Konzept der Fehlerbehandlung. Es ermöglicht dir, Fehler auf eine strukturierte und kontrollierte Weise zu behandeln, anstatt das Skript einfach abstürzen zu lassen.

    //     }

    //     return $controller->$action($vars);
    // }

    public function callAction($controller, $action, $vars = [])
    {
        $controllerClass = "App\\Controllers\\{$controller}";
        
        // Überprüfe, ob die Controller-Klasse existiert
        if (!class_exists($controllerClass)) {
            throw new Exception("Controller {$controllerClass} existiert nicht!");
        }
    
        $controllerInstance = new $controllerClass;
    
        // Überprüfe, ob die Methode existiert
        if (!method_exists($controllerInstance, $action)) {
            throw new Exception("{$controllerClass} hat keine Methode {$action}!");
        }
    
        // Rufe die Methode auf und übergebe die Variablen
        return $controllerInstance->$action(...$vars);
    }
}
