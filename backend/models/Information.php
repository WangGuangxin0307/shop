<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "information".
 *
 * @property int $transaction_id 交易id
 * @property string $amount 交易金额
 * @property int $number 订单数量
 * @property int $successful 交易成功
 * @property int $failure 交易失败
 * @property string $refund 退款金额
 */
class Information extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'information';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['amount', 'number', 'successful', 'failure', 'refund'], 'required'],
            [['amount', 'refund'], 'number'],
            [['number', 'successful', 'failure'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'transaction_id' => 'Transaction ID',
            'amount' => 'Amount',
            'number' => 'Number',
            'successful' => 'Successful',
            'failure' => 'Failure',
            'refund' => 'Refund',
        ];
    }
}
