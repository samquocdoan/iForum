<?php

class Router
{
    private $routes = [];
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function get($uri, $controller)
    {
        if (!isset($this->routes['GET'])) {
            $this->routes['GET'] = [];
        }
        $this->routes['GET'][$this->convertUriToRegex($uri)] = $controller;
    }

    public function post($uri, $controller)
    {
        if (!isset($this->routes['POST'])) {
            $this->routes['POST'] = [];
        }
        $this->routes['POST'][$this->convertUriToRegex($uri)] = $controller;
    }

    private function convertUriToRegex($uri)
    {
        return '#^' . preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<\1>[a-zA-Z0-9_-]+)', $uri) . '$#';
    }

    public function handleRequest($requestUri, $requestMethod)
    {
        foreach ($this->routes[$requestMethod] as $uriPattern => $controller) {
            if (preg_match($uriPattern, $requestUri, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                $controllerAction = explode('@', $controller);
                $controllerName = $controllerAction[0];
                $methodName = $controllerAction[1];

                require_once "src/controllers/$controllerName.php";
                $controllerInstance = new $controllerName($this->db);

                if (!method_exists($controllerInstance, $methodName)) {
                    throw new Exception("Method $methodName not found in controller $controllerName");
                }

                call_user_func_array([$controllerInstance, $methodName], $params);
                return;
            }
        }

        http_response_code(404);
        require __DIR__ . '/../views/404.php';
    }
}
