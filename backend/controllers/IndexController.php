<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

/**
 * Site controller
 */
class IndexController extends Controller
{

    /**
     * Displays homepage.
     *
     * @return string
     */
    public $layout=false;
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionHome()
    {
        return $this->render('home');
    }
}
