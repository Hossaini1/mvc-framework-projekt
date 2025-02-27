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
        if (array_key_exists($url, $this->routes[$requestType][])) {
            return $this->callAction(
                ...explode('@', $this->routes[$requestType][$url])
            );
        }
    }
    public function callAction($controller, $action, $vars = [])
    {
        $controller = "APP\\Controllers\\{$controller}";
        $controller = new $controller;
        if (!method_exists($controller, $action)) {
            throw new Exception("{$controller} not {$action} action !!!");
            // In PHP ist Exception ein zentrales Konzept der Fehlerbehandlung. Es ermöglicht dir, Fehler auf eine strukturierte und kontrollierte Weise zu behandeln, anstatt das Skript einfach abstürzen zu lassen.

        }

        return $controller->$action($vars);
    }
}
