<?php

namespace components;

class View
{
    public $path;
    public $route;
    public $layout = 'default';

    public function __construct($route)
    {
        $this->route = $route;
        $this->path = $route['name'] . '/' . $route['action'];
    }

    public function render($vars = [])
    {
        extract($vars);

        $path = ROOT . '/views/' . $this->path . '.php';

        if (file_exists($path)) {
            ob_start();
            require_once($path);
            $content = ob_get_clean();

            require_once(ROOT . '/views/layouts/' . $this->layout . '.php');
        }
    }
}
