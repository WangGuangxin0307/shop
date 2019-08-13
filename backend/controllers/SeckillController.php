<?php

/**
 * description : 秒杀实现
 * @Author: 王广鑫
 * @Date: 2019/8/7 9:15
 * @package backend\controllers
 */


namespace backend\controllers;

use common\models\Active;
use common\models\Order;
use Yii;
use common\models\Goods;
use yii\web\Controller;

class SeckillController extends Controller
{
    public $layout=false;

    public $redis = null;


    public function beforeAction($action)
    {
        //连接配置
//        $this->redis = new \Redis();
//        $this->redis->connect('127.0.0.1',6379);
//        $this->redis->select(0);

        return parent::beforeAction($action); // TODO: Change the autogenerated stub

    }

    public function actionTest(){
        for($i=0;$i<20000;$i++){
            $this->actionKillstart();
        }
    }
    /**
     * 秒杀开始执行
     */
    public function actionKillstart(){

        $req = Yii::$app->request;
        $uid = mt_rand(1000,9999);
        $goodsId = $req->get('gid')?$req->get('gid'):1;
        $key = 'goods:id:'.$goodsId;
        $redis = new \Redis();
        $redis->connect('127.0.0.1',6379);
        $redis->select(2);  //切换到goods库

        //从缓存中获取当前商品的秒杀信息

        $goodsData = $redis->hGetAll($key);
        //print_r($goodsData);
        if (empty($goodsData)){
            echo '该商品没有秒杀信息';
            die();
        }


        $redis->select(1);  //切换到active库
        $hashKey = 'active:id:'.$goodsData['active_id'];
        //获取商品活动时间
        $activeData = $redis->hmGet($hashKey,['time_begin','time_end']);
        //获取当前时间
        $time = time();
        //检测活动是否开始或停止
        if ($time > $activeData['time_begin'])
        {
            if ($time<$activeData['time_end']){
                //检测商品库存
                if ($goodsData['num_rem']>0){
                    $this->Killrun($uid,$goodsId,$goodsData['price_normal'],$goodsData['price_discount']);
                }else{
                    echo '商品库存不足';
                }
            }else{
                echo '该商品秒杀活动已结束';
            }
        }else{
            echo '该商品秒杀活动未开始';
        }

    }

    /**
     * 处理秒杀
     * @param $uId  用户id
     * @param $goodsId  商品id
     * @param $price_normal  原价
     * @param $price_discount   秒杀价
     */
    public function Killrun($uId,$goodsId,$price_normal,$price_discount){
        $redis = new \Redis();
        $redis->connect('127.0.0.1',6379);
        $redis->select(3);
        $order_number = 'k'.$uId.date('YmdHis').mt_rand(1000,9999).mt_rand(1000,9999);
        $order = [
            'user_id'=>$uId,
            'goods_id'=>$goodsId,
            'trande_status'=>0,
            'pay_status'=>0,
            'order_number' => $order_number,
            'order_amount'=>$price_normal,
            'pay_amount'=>$price_discount,
            'create_time'=>time()
        ];
        //存入订单缓存
        $res = $redis->lPush('order',json_encode($order));
        if($res){

            $goodsKey = 'goods:id:'.$goodsId;
            $redis->select(4);
            $redis->setex($order_number,5*60,$goodsKey);
            if ($res){
                //将缓存中的库存减1
                $redis->select(2);
                $res = $redis->hIncrBy($goodsKey,'num_rem',-1);
                if ($res){
                    echo '秒杀成功';
                }
            }
        }
    }

    /**
     * 秒杀结束
     */
    public function Killstop(){
        $redis = new \Redis();
        $redis->connect('127.0.0.1',6379);
        $redis->select(0);
        //进行循环读取redis里面的数据，写入数据库
        for ($i = 1; $i <= 30; $i++)
        {
            $userkey = 'user:id:' . $i;
            $info[$i] = $redis->hgetall($userkey);
            $info[$i]['username'] = "'" . $info[$i]['username'] . "'";
            $info[$i]['email'] = "'" . $info[$i]['email'] . "'";

            //将数组转化为字符串写入数据库
            $info[$i] = implode(",", $info[$i]);
            $sql = "insert into redistest (id,username,age,email) values ($info[$i])";

        }
    }
}