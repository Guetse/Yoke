<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/6
 * Time: 16:06
 */
namespace app\index\controller;

use think\Controller;
use think\Db;
use app\index\model\Cover as covers;
class Cover extends Controller
{
    public function g_list(){
        $list = covers::order('id','desc')->select();
        return view('',['list'=>$list]);
    }

    public function add(){
        if(request()->isPost()){
            $files = request()->file('imgs');
            foreach ($files as $file) {
                // 移动到框架应用根目录/public/uploads/ 目录下
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
                if($info){
                    $arr[] = '/uploads/' . $info->getSaveName();
                    $imgp = str_replace("\\", "/", $arr);
                }else{
                    return json(['status'=>3,'msg'=>$file->getError()]);
                }
            }
            $data['tid'] = input('tid');
            $data['addtime'] = time();
            $data['imgs'] = implode(',', $imgp);
            $add = Db::table('goods_imgs')->insert($data);
            if ($add) {
                return json(['status' => '1', 'msg' => '添加成功']);
            } else {
                return json(['status' => '2', 'msg' => "添加失败"]);
            }
        }
        $list = Db::table('type')->select();
        return view('', ['list' => $list]);
    }

    public function show(){
        $id=input('id');
        $list = Db::table('goods_imgs')->where('id',$id)->find();
        $li = explode(',',$list['imgs']);
        return view('',['list'=>$list,'li'=>$li]);
    }

    public function edit(){
        if(request()->isPost()){
            $files = request()->file("imgs");
            foreach ($files as $file) {
                // 移动到框架应用根目录/public/uploads/ 目录下
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
                if($info){
                    $arr[] = '/uploads/' . $info->getSaveName();
                    $imgp = str_replace("\\", "/", $arr);
                }else{
                    return json(['status'=>3,'msg'=>$file->getError()]);
                }
            }
                $data['imgs'] = implode(',', $imgp);
                $data['update_time'] = time();
//                $data['tid'] = input('tid');
                $id= input('id');
                $res = Db::table('goods_imgs')->where('id',$id)->update($data);
            if($res){
                return json(['status' => '1','msg' => '修改成功']);
            }else{
                return json(['status' => '2', 'msg' =>'修改失败']);
            }
        }
        $id= input('id');
        $list = covers::where('id',$id)->find();
        return view('',['list'=>$list]);
    }


    public function del(){
            $id = input('id');
            if(covers::destroy($id)){
                return json(['status'=>'ok','msg'=>'删除成功']);
            }else{
                return json(['status'=>'error','msg'=>'删除失败']);
            }

    }
}