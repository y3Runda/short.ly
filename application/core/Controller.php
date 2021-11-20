<?php

namespace application\core;
use application\core\View;

abstract class Controller
{
    public $route;
    public $view;
    public $acl;
    /**
     * @var mixed|void
     */

    public function __construct($route)
    {
        $this->route = $route;
        if (!$this->checkAcl()) {
            View::errorCode(403);
        }
        $this->view = new View($route);
        $this->model = $this->loadModel($route['controller']);
    }

    public function loadModel($name)
    {
        $path = 'application\models\\'.ucfirst($name);
        if (class_exists($path))
        {
            return new $path;
        }
    }

    public function checkAcl(): bool
    {
        $this->acl = require 'application/acl/'.$this->route['controller'].'.php';
        $flag = false;
        if ($this->isAcl('all')) $flag = true;
        if (isset($_SESSION['user']['id']) and $this->isAcl('authorized'))      $flag = true;
        if (isset($_SESSION['user']['id']) and $this->isAcl('admin'))           $flag = true;
        if (isset($_SESSION['user']['id']) and $this->isAcl('expert'))          $flag = true;
        if (isset($_SESSION['user']['id']) and $this->isAcl('moderator'))       $flag = true;
        if (!isset($_SESSION['user']['id']) and $this->isAcl('guest'))          $flag = true;
        return $flag;
    }

    public function isAcl($key): bool
    {
        return in_array($this->route['action'], $this->acl[$key]);
    }
}