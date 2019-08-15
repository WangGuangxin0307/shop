<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $order_id 订单id
 * @property string $order_sn 订单编号
 * @property int $customer_id 下单id
 * @property string $shipping_user 收货人姓名
 * @property string $province 省
 * @property string $city 市
 * @property string $district 区
 * @property string $address 地址
 * @property int $payment_method 支付方式：1现金 2余额 3网银 4支付宝 5微信
 * @property string $order_money 订单金额
 * @property string $district_money 优惠金额
 * @property string $payment_money 支付金额
 * @property string $shipping_comp_name 快递公司名称
 * @property string $shipping_time 发货时间
 * @property string $pay_time 支付时间
 * @property string $receive_time 收货时间
 * @property int $order_status 订单状态 0代付款 1已付款 2代发货
 * @property int $order_point 订单积分
 * @property string $invoice 发票抬头
 * @property string $create_time 下单时间
 * @property string $shipping_sn 快递单号
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_sn', 'customer_id', 'shipping_user', 'province', 'city', 'district', 'address', 'order_money', 'district_money', 'payment_money', 'shipping_comp_name', 'shipping_time', 'pay_time', 'receive_time', 'invoice', 'shipping_sn'], 'required'],
            [['customer_id', 'payment_method', 'order_status', 'order_point'], 'integer'],
            [['order_money', 'district_money', 'payment_money'], 'number'],
            [['shipping_time', 'pay_time', 'receive_time', 'create_time'], 'safe'],
            [['order_sn'], 'string', 'max' => 20],
            [['shipping_user', 'province', 'city', 'district', 'shipping_comp_name'], 'string', 'max' => 10],
            [['address', 'invoice'], 'string', 'max' => 100],
            [['shipping_sn'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'order_id' => 'Order ID',
            'order_sn' => 'Order Sn',
            'customer_id' => 'Customer ID',
            'shipping_user' => 'Shipping User',
            'province' => 'Province',
            'city' => 'City',
            'district' => 'District',
            'address' => 'Address',
            'payment_method' => 'Payment Method',
            'order_money' => 'Order Money',
            'district_money' => 'District Money',
            'payment_money' => 'Payment Money',
            'shipping_comp_name' => 'Shipping Comp Name',
            'shipping_time' => 'Shipping Time',
            'pay_time' => 'Pay Time',
            'receive_time' => 'Receive Time',
            'order_status' => 'Order Status',
            'order_point' => 'Order Point',
            'invoice' => 'Invoice',
            'create_time' => 'Create Time',
            'shipping_sn' => 'Shipping Sn',
        ];
    }

    public function getCommodity()
    {
        return $this->hasOne(Commodity::className(), ['commo_id' => 'order_id']);
    }
}
