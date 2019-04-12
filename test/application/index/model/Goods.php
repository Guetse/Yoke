<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/2
 * Time: 11:59
 */
namespace app\index\model;

use think\Model;

class Goods extends Model
{
    protected $table = 'goods';
    public function good(){
        return $this->hasOne('type','id','tid');
    }
}