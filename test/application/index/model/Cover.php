<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/6
 * Time: 17:07
 */
namespace app\index\model;

use think\Model;

class Cover extends Model
{
    protected $table = 'goods_imgs';
    public function good(){
        return $this->hasOne('type','id','tid');
    }
}