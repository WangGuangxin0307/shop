<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "active".
 *
 * @property int $id 活动id
 * @property string $title 活动名称
 * @property int $time_begin 开始时间
 * @property int $time_end 结束时间
 * @property int $time_create 创建时间
 * @property int $time_update 修改时间
 * @property int $status 状态：0待上线 、1已上线、2已下线
 * @property int $type_id 活动类型：1秒杀 、2团购、3优惠
 */
class Active extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'active';
    }

  /*  public function getGoods(){
       // return $this->hasOne(Goods::className(),['active_id'=>'id']);
    }*/
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['time_begin', 'time_end', 'time_create', 'time_update', 'status','type_id'], 'integer'],
            [['title'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '活动id',
            'title' => '活动名称',
            'time_begin' => '开始时间',
            'time_end' => '结束时间',
            'time_create' => '创建时间',
            'time_update' => '修改时间',
            'status' => '状态：0待上线 、1已上线、2已下线',
            'type_id' => '活动类型：1秒杀 、2团购、3优惠',
        ];
    }

}
