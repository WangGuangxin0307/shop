<?php

/**
 * description : 活动
 * @Author: 王广鑫
 * @Date: 2019/8/7 9:15
 * @package backend\controllers
 */


namespace backend\controllers;

use Yii;
use common\models\Active;
use yii\web\Controller;

class ActiveController extends Controller
{
    public $layout=false;
    public $enableCsrfValidation=false;

    public function beforeAction($action)
    {
        //检测活动记录
        $this->checkActive();
        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }

    /**
     * 检测数据表中的活动数与redis中的是否一致
     */
    public function checkActive(){
        $redis = new \Redis();
        $redis->connect('127.0.0.1',6379);
        $redis->select(1);
        //获取redis库键值数据个数
        $activeCount = $redis->dbSize();
        //获取数据表数据条数
        $count = Active::find()->count();
        if($activeCount != $count){
            $redis->flushAll();

            //取未下线的活动
            $data = Active::find()->where("status!=2")->asArray()->all();

            //开启管道操作
            $pipe = $redis->multi(\Redis::PIPELINE);
            //向redis中导入数据
            foreach ($data as $k=>$v){
                $key = 'active:id:'.$v['id'];
                $pipe->hMSet($key,$data[$k]);
            }

            //提交管道命令
            $pipe->exec();
        }
    }

    /**
     * 将数据表中数据读取到Redis 1库中
     */
    public function actionActiveadd()
    {
        //接收数据
        $request = Yii::$app->request;
        $title = $request->post('title');
        //转换时间格式为时间戳
        $time_begin = strtotime($request->post('time_begin')); //2019-08-29 15:03:26  -> 1567062206
        $time_end =   strtotime($request->post('time_end')); //2019-08-29 15:03:26  -> 1567062206
        $time_create = time();
        $status = $request->post('status');
        $type_id = $request->post('type');

        //处理待添加的数据
        $data = [
            'title' => $title ,
            'time_begin' => $time_begin ,
            'time_end' =>$time_end ,
            'time_create' =>$time_create ,
            'status' => $status ,
            'type_id' =>$type_id
        ];
        //插入数据到数据库
        $active = new Active();
        $active->attributes = $data ;
        $active->save();
        $id = $active->getPrimaryKey();
        $data['id']=$id;
        //将新插入的数据插入到redis 活动库
        $redis = new \Redis();
        $redis->connect('127.0.0.1',6379);
        $redis->select(1);
        $key = 'active:id:'.$id;
        $redis->hMSet($key,$data);
    }


    /**
     * 秒杀活动列表页
     * @return string
     */
    public function actionSeckill()
    {

        $data = Active::find()->where(['type_id'=>1])->asArray()->all();
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

    /**
     * 秒杀商品导入redis
     */
    public function actionKillgoodsadd()
    {
        $select = '`goods`.`id`, `goods`.`title`,`price_normal`,`price_discount`,`num_total`,`num_rem`,active_id,`active`.`time_begin`,`active`.`time_end` FROM `goods` LEFT JOIN `active` ON `goods`.`active_id` = `active`.`id`';
        $sql = "SELECT $select WHERE active.`status`!=2 AND active.type_id=1;";
        $data = Yii::$app->db
            ->createCommand($sql)
            ->queryAll();

        $redis = new \Redis();
        $redis->connect('127.0.0.1',6379);
        $redis->select(2);
        //开启管道操作
        $pipe = $redis->multi(\Redis::PIPELINE);
        //向redis中导入数据
        foreach ($data as $k=>$v){
            $pipe->hMSet('goods:id:'.$v['id'],$data[$k]);
        }

        //提交管道命令
        $pipe->exec();
    }
}