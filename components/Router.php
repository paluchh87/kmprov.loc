<?php

namespace components;

class Router
{
    private $routes;
    protected $params = [];

    public function __construct()
    {
        $this->routes = require_once(ROOT . '/config/routes.php');
    }

    public function run()
    {
        if ($this->match()) {
            if (file_exists($this->params['controllerFile'])) {
                $controller = 'controllers\\' . $this->params['controllerName'];
                $controllerObject = new $controller($this->params);

                if (method_exists($controllerObject, $this->params['actionName'])) {
                    $result = call_user_func_array([$controllerObject, $this->params['actionName']],
                        $this->params['parameters']);
                    if ($result === false) {
                        echo 'Ошибка! <br>';
                    }
                } else {
                    echo 'Ошибка! Данного метода нет <br>';
                }
            } else {
                echo 'Ошибка! Данного контролера нет <br>';
            }
        } else {
            echo 'Ошибка! Совпадений нет <br>';
        }
    }

    private function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }

        return false;
    }

    public function match()
    {
        $uri = $this->getURI();

        foreach ($this->routes as $uriPattern => $path) {
            if (preg_match("~$uriPattern~", $uri)) {
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
                $segments = explode('/', $internalRoute);
                $this->params['name'] = ucfirst($segments[0]);
                $this->params['action'] = $segments[1];
                $this->params['controllerName'] = ucfirst(array_shift($segments)) . 'Controller';
                $this->params['actionName'] = 'action' . ucfirst(array_shift($segments));
                $this->params['parameters'] = $segments;
                $this->params['controllerFile'] = ROOT . '/controllers/' . $this->params['controllerName'] . '.php';

                return true;
            }
        }

        return false;
    }
}
