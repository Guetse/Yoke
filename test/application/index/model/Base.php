<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/2/20
 * Time: 9:55
 */
namespace app\index\model;


use think\Model;
use think\Collection;
class Base extends Model
{
    public function findOne($options=[])
    {
        //查询条件
        $where = isset($options['where']) ? $options['where'] : [];
        $field = isset($options['field']) ? $options['field'] : [];

        $info = $this->where($where)->field($field)->find();
        return empty($info) ? [] : $info->toArray();
    }

    public function findAll($options=[])
    {
        //查询条件
        $where = isset($options['where']) ? $options['where'] : [];
        $field = isset($options['field']) ? $options['field'] : [];
        $paginate = isset($options['paginate']) ? $options['paginate'] : [];
        if(isset($options['paginate'])){
            $list = $this->where($where)->field($field)->paginate($paginate);
            return $list;
        }else{
            $list = $this->where($where)->field($field)->select();
//            return empty($list) ? [] : collection($list)->toArray();
            return $list;
        }

    }
    //添加一条数据
    public function addOne($data)
    {
        $insert_id = $this->isUpdate(false)->allowField(true)->save($data);
        if (!$insert_id) {
            return ['code'=>201,'msg'=>'操作失败'];
        }
        return ['code'=>200,'msg'=>'操作成功'];
    }

    //修改数据
    public function updateRes($options=[]){
        //查询条件
        $where = isset($options['where']) ? $options['where'] : [];
        $dataUpdate = isset($options['data']) ? $options['data'] : [];
        $updateRes = $this->where($where)->update($dataUpdate);
        if(!isset($updateRes) ||empty($updateRes)){
            return ['code'=>201,'msg'=>'修改失败'];
        }
        return ['code'=>200,'msg'=>'修改成功'];
    }
    //删除数据
    public function deleteRes($id)
    {
        if (empty ($id)) {
            return ['code'=>201,'msg'=>'主键不能为空'];
        }
        $info = $this->get($id);
        if (empty($info)) {
            return ['code'=>201,'msg'=>'数据不存在'];
        }
        $num = $this->destroy($id);
        if ($num != 1) {
            return ['code'=>201,'msg'=>'操作失败'];
        }
        return ['code'=>200,'msg'=>'操作成功'];
    }

}