<?php
namespace backend\controllers;

use Yii;
use yii\db\Query;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use backend\models\Information;
use backend\models\Order;
use yii\data\Pagination;
use backend\models\Commodity;
use yii\data\Sort;
/**
 * Site controller
 */
class OrderController extends Controller
{
    public $enableCsrfValidation=false;
    /*
     * 首页
     *
     * 编写：Xwc
     * */
    public function actionIndex()
    {
        return $this->renderPartial('show');
    }

    /*
     * 订单管理
     *
     * */
    public function actionOrderform()
    {
        $where['order_sn']=Yii::$app->request->post('order_sn');
        $where['create_time']=Yii::$app->request->post('create_time');
        $query = new Query();
        $query->from('order');
        if (!empty($where['order_sn'])||!empty($where['create_time'])){
            $query->andFilterWhere(['like','order_sn',$where['order_sn']])->orFilterWhere(['like','create_time',$where['create_time']]);
        }
        $data=$query->from('order')->all();
        $pages = new Pagination(['totalCount' =>$query->count(),'pageSize'=>'2']);
        $data = $query->offset($pages->offset)->limit($pages->limit)->all();


        return  $this->renderPartial('orderform',['data'=>$data,'where'=>$where,'pagination'=>$pages]);
    }

    /*
     * 发货
     *
     * */
    public function actionStock()
    {
        $order_id = Yii::$app->request->get('order_id');

        $shipping_comp_name = Yii::$app->request->get('shipping_comp_name');
        $data = Order::findOne($order_id);
        $data->order_status = "5";
        $data->shipping_comp_name = $shipping_comp_name;
        $res = $data->save(false);

        if ($res){
            return json_encode(['code'=>200,'msg'=>"发货成功"]);
        }else{
            return json_encode(['code'=>400,'msg'=>"发货失败"]);
        }
    }
    /*
     * 订单处理
     *
     * */
    public function actionAmounts()
    {
        $query = new Query();
        $query->from('order');
        $data=$query->from('order')->all();
        $pages = new Pagination(['totalCount' =>$query->count(),'pageSize'=>'2']);
        $data = $query->offset($pages->offset)->limit($pages->limit)->all();
        return  $this->renderPartial('amounts',['data'=>$data,'pagination'=>$pages]);
    }

    /*
     * 退款管理
     *
     * */
    public function actionRefund()
    {
        $where['order_sn']=Yii::$app->request->post('order_sn');
        $where['commodity']=Yii::$app->request->post('commodity');
        $query = new Query();
        $query->from('order');
        if (!empty($where['order_sn'])||!empty($where['create_time'])){
            $query->andFilterWhere(['like','order_sn',$where['order_sn']])->orFilterWhere(['like','commodity',$where['commodity']]);
        }
        $data=$query->from('order')->all();
        $pages = new Pagination(['totalCount' =>$query->count(),'pageSize'=>'2']);
        $data = $query->offset($pages->offset)->limit($pages->limit)->all();
        return $this->renderPartial('refund',['data'=>$data,'where'=>$where,'pagination'=>$pages]);
    }
    /*
     *
     * 退款
     * */
    public function actionArefund()
    {
        $order_id = Yii::$app->request->post('order_id');

        $data = Order::findOne($order_id);
        $data->order_status = "6";
        if ($data->save()){
            return json_encode(['code'=>200,'msg'=>'退款成功']);
        }else{
            return json_encode(['code'=>400,'msg'=>'退款失败']);
        }
    }

    /*
     * 订单详情页
     *
     * */
    public function actionDetailed()
    {
        $order_id = Yii::$app->request->get('id');
//        var_dump($order_id);die();
        $orders = Order::find()->where(['order_id'=>$order_id])->joinWith('commodity')->select('order.order_id,order.order_sn,order.shipping_user,order.address')->asArray()->one();
        return $this->renderPartial('detailed',['orders'=>$orders]);
    }
}