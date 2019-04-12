<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/6
 * Time: 10:03
 */
namespace app\index\controller;

use think\Controller;
use think\Db;
class Category extends Controller
{
    public function category_list(){
        $list = Db::table('type')->select();
        return view('', ['list' => $list]);
    }
    public function add(){
        if(request()->isPost()) {
            $file = request()->file("cover");
            if (!empty($file)) {
                $info = $file->validate(['ext' => 'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'upload');
                if ($info) {
                    //返回文件路径
                    $attrurl = 'upload' . '/' . $info->getSaveName();
                    //文件目录根转义
                    $imgp = str_replace("\\", "/", $attrurl);
                    $data['cover'] = $imgp;
                } else {
                    return json(['status' => 3, 'msg' => '图片格式不正确']);
                }
                $data['uname'] = input('uname');
                $data['addtime'] = time();
                $add = Db::table('type')->insert($data);
                if($add){
                    return json(['status' => '1','msg' => '添加成功']);
                }else{
                    return json(['status' => '2', 'msg' => "添加失败"]);
                }
            }else{
                return json(['status' => '3', 'msg' => "请选择图片"]);
            }
        }

        return view();
    }

    public function del(){

        $id = input('id');
        if(Db::table('type')->delete($id)){
            return json(['status'=>'ok','msg'=>'删除成功']);
        }else{
            return json(['status'=>'error','msg'=>'删除失败']);
        }
    }
}