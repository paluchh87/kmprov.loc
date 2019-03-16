<?php

namespace components;

use models\Files;

abstract class Controller
{
    public $route;
    public $view;
    public $model;
    public $files;

    public function __construct($route)
    {
        $this->route = $route;

        $this->view = new View($route);
        $this->files = new Files();
        $this->model = $this->loadModel($route['name']);
    }

    public function loadModel($name)
    {
        $path = 'models\\' . $name;
        return new $path;
    }
}