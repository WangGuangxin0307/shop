<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "goods".
 *
 * @property int $id 商品id
 * @property int $active_id 活动id
 * @property string $title 商品名称
 * @property string $description 商品描述
 * @property string $img 列表页小图标
 * @property int $price_normal 原价
 * @property int $price_discount 秒杀价
 * @property int $num_total 总数量
 * @property int $num_user 单个用户限购数量
 * @property int $num_rem 剩余可购买数量
 * @property int $status 状态 ： 0待上线、1已上线、2已下线
 */
class Goods extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'goods';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['active_id', 'price_normal', 'price_discount', 'num_total', 'num_user', 'num_rem', 'status'], 'integer'],
            [['title', 'description', 'img'], 'required'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 100],
            [['img'], 'string', 'max' => 255],
        ];
    }
    public function getActive()
    {
        return $this->hasOne(Active::className(), ['id' => 'active_id']);
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '商品id',
            'active_id' => '活动id',
            'title' => '商品名称',
            'description' => '商品描述',
            'img' => '列表页小图标',
            'price_normal' => '原价',
            'price_discount' => '秒杀价',
            'num_total' => '总数量',
            'num_user' => '单个用户限购数量',
            'num_rem' => '剩余可购买数量',
            'status' => '状态 ： 0待上线、1已上线、2已下线',
        ];
    }
}
