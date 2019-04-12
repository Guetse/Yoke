<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/2
 * Time: 13:32
 */
namespace app\index\controller;

use think\Controller;
use think\Db;
use app\index\model\Link as links;
use think\Session;

class Link extends Controller
{
    public function links(){
        $tid = session('type_id');

        $strs="QWERTYUIOPASDFGHJKLZXCVBNM1234567890qwertyuiopasdfghjklzxcvbnm";
        $name=substr(str_shuffle($strs),mt_rand(0,strlen($strs)-11),5);
//        $sUrl = urlShort($name);
//        $url = 'http://www.goods.com/index/Link/link_list/'.$name;
        $url = 'http://img.boxinid.com/index/Link/link_list/'.$name;
        $data = [
            'url'=>$url,
            'addtime'=>time(),
            'tid'=>$tid,
        ];
        $add = links::insertGetId($data);
        if ($add){
            return json(['status' => '1', 'msg' => '生成成功']);
        } else {
            return json(['status' => '2', 'msg' => "生成失败"]);
        }
    }

    public function lists(){
        $list = Db::table('links')->order('id','desc')->find();
        return view('',['list'=>$list]);
    }

    public function link_list(){
//        $id=input('id');
        $url=$_SERVER['PHP_SELF'];
        $str=strrchr($url,'/');
        $id=substr($str,1,2);
        if($id){
            $data = Db::table('type a')
                ->join('links b','b.tid=a.id')
                ->join('goods c','c.tid=a.id')
                ->join('goods_imgs d','a.id=d.tid')
                ->order('c.id','desc')
                ->where('b.id',$id)
                ->field('a.cover as img,a.uname,c.*,d.imgs')
                ->select();
            //顶头预览图
            $li =explode(',',$data[0]['imgs']);
            //
            foreach($data as $k => $v){
                $data[$k]['cover'] = explode(',',$v['cover']);
            }

            return $this->fetch('link_list',['data'=>$data,'li'=>$li]);
        }else{
            dump("未找到商品!");
        }


    }


}