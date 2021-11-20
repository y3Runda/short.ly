<?php

namespace application\controllers;
use application\core\Controller;

class UserController extends Controller
{
    public function signupAction()
    {
        if (!empty($_POST)) {
            if (!$this->model->validate(['email', 'password'])) {
                $this->view->message('error', $this->model->error);
            } else if ($this->model->checkEmailExists($_POST['email'])) {
                $this->view->message('error', 'This E-mail is already in use');
            }
            $this->model->register($_POST);
            $this->view->message('success', 'Registration completed, confirm your E-mail');
        }
        $this->view->render('Signup');
    }

    // TODO: create confirmAction()

    public function loginAction()
    {
        if (!empty($_POST)) {
            if (!$this->model->validate(['email', 'password'], $_POST)) {
                echo '';
            } elseif (!$this->model->checkData($_POST['email'], $_POST['password'])) {
                echo 'Login or password is incorrect';
            } elseif (!$this->model->checkStatus('email', $_POST['email'])) {
                echo '';
            }
            $this->model->login($_POST['login']);
            $this->view->location('/');
        }
        $this->view->render('Login');
    }

    // TODO: create logoutAction()

    // TODO: create recoveryAction()

    // TODO: create confirmAction()

    // TODO: create resetAction()
}