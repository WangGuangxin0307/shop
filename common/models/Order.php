<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $order_id 订单id
 * @property string $order_number 唯一订单号
 * @property int $buyer_id 买家id
 * @property int $trade_status 交易状态：0进行中、1已完成、2取消交易、3已结束
 * @property int $pay_status 支付状态：1未付款、2已付款、3支付失败
 * @property int $order_amount 订单金额
 * @property int $pay_amount 付款金额
 * @property int $total_amount 最终付款金额
 * @property int $pay_time 订单支付时间
 * @property string $out_trade_no 交易订单号,服务商的订单号
 * @property int $create_time 订单创建时间
 * @property int $address_id 收获地址
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
            [['order_number', 'buyer_id'], 'required'],
            [['buyer_id', 'trade_status', 'pay_status', 'order_amount', 'pay_amount', 'total_amount', 'pay_time', 'create_time', 'address_id'], 'integer'],
            [['order_number'], 'string', 'max' => 32],
            [['out_trade_no'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'order_id' => '订单id',
            'order_number' => '唯一订单号',
            'buyer_id' => '买家id',
            'trade_status' => '交易状态：0进行中、1已完成、2取消交易、3已结束',
            'pay_status' => '支付状态：1未付款、2已付款、3支付失败',
            'order_amount' => '订单金额',
            'pay_amount' => '付款金额',
            'total_amount' => '最终付款金额',
            'pay_time' => '订单支付时间',
            'out_trade_no' => '交易订单号,服务商的订单号',
            'create_time' => '订单创建时间',
            'address_id' => '收获地址',
        ];
    }
}
