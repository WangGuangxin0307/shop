<?php
namespace backend\controllers;


class LoginController
{
    public $layout=false;
    public function actionIndex()
    {
        return $this->render('index');
    }
}