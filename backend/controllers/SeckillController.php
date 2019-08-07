<?php

/**
 * description : 秒杀实现
 * @Author: 王广鑫
 * @Date: 2019/8/7 9:15
 * @package backend\controllers
 */


namespace backend\controllers;


use common\models\Goods;
use yii\web\Controller;

class SeckillController extends Controller
{
    public $layout=false;
    public function actionDec()
    {

        $model = Goods::findOne(1);
        $data = $model->toArray();
        if($data['num_rem']==0)
        {
            die;
        }
        $model->updateCounters(['num_rem'=>-1]);
    }
}