<?php

namespace console\models;

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
class Goods
{
   public static function test($redis){

   }


// 回调函数,这里写处理逻辑
    public function keyCallback()
    {
      echo 1;
    }
}
