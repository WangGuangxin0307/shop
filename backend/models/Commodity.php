<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "commodity".
 *
 * @property int $commo_id 商品id
 * @property string $information 商品信息
 * @property string $introduction 商品简介
 * @property string $specifications 规格
 * @property string $weight 重量
 * @property string $state 状态 0 无货  1有货
 * @property string $imges 图片
 */
class Commodity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'commodity';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['information', 'introduction', 'specifications', 'weight', 'imges'], 'required'],
            [['information', 'introduction'], 'string', 'max' => 40],
            [['specifications', 'weight'], 'string', 'max' => 10],
            [['state'], 'string', 'max' => 2],
            [['imges'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'commo_id' => 'Commo ID',
            'information' => 'Information',
            'introduction' => 'Introduction',
            'specifications' => 'Specifications',
            'weight' => 'Weight',
            'state' => 'State',
            'imges' => 'Imges',
        ];
    }
}
