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
class ProductController extends Controller
{

    /**
     * Displays homepage.
     *
     * @return string
     */
    public $layout=false;
    /**
     * 产品类表
     * @return string
     */
    public function actionList()
    {
        return $this->render('list');
    }

    /**
     * 品牌管理
     * @return string
     */
    public function actionManage(){

        return $this->render('manage');
    }

    /**
     * 分类管理
     * @return string
     */
    public function actionCategory(){

        return $this->render('manage');
    }
}
