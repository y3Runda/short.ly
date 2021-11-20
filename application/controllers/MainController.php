<?php

namespace application\controllers;
use application\core\Controller;

class MainController extends Controller
{
    public function indexAction() {
        if (!empty($_POST)) {
            $link = $_POST['link'];
            if ($this->model->addLink($link)) {
                echo '';
            }
        }
        $this->view->render('Main page');
    }

    public function shortenAction() {
        if ($this->model->checkCodeExists($this->route['code'])) {
            $url = $this->model->getUrl($this->route['code']);
            $this->view->redirect($url[0]['link']);
        }
        //$this->view->render('?');
    }

    public function aboutAction() {
        $this->view->render('About page');
    }

    public function helpAction() {
        $this->view->render('Help page');
    }
}