<?php

/**
 * description : 活动
 * @Author: 王广鑫
 * @Date: 2019/8/7 9:15
 * @package backend\controllers
 */


namespace backend\controllers;


use common\models\Active;
use yii\web\Controller;

class ActiveController extends Controller
{
    public $layout=false;

    /**
     * 秒杀活动列表页
     * @return string
     */
    public function actionSeckill()
    {
        $data = Active::find()->where(['type_id'=>1])->asArray()->all();
        var_dump($data);die;
        return $this->render('seckill');
    }

    /**
     * 团购活动列表页
     */
    public function actionGroup()
    {
        $data = Active::find()->where(['type_id'=>2])->asArray()->all();
        var_dump($data);die;
    }

    /**
     * 优惠活动列表页
     */
    public function actionDiscount()
    {
        $data = Active::find()->where(['type_id'=>3])->asArray()->all();
        var_dump($data);die;
    }
}