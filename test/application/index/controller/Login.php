<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/11
 * Time: 10:16
 */

namespace app\index\Controller;

use think\Controller;

use app\index\model\Login as LoginModel;
use think\Loader;
use think\Session;
use think\Validate;
/**
    登陆
 */
class Login extends Controller
{

    public function login()
    {
//        if(session('admin_id') && session('admin_id')>0){
//            $this->error("您已登录",url('Index/Index/index'));
//        }

        if(request()->isPost()){
            $uname = input('name');
            $upass = md5(input('password'));
            //验证用户名  密码
            $user = LoginModel::where('name','=',$uname) -> where('password', '=', $upass)-> find();
            if ($user) {
                session('admin_id', $user['id']);
                session('admin_name', $user['name']);
                $this -> redirect('/index');
            } else {
                $this -> error('账号或密码不对', 'index/login/login');
            }
    }else{
            return view();
        }
    }


    //退出
    public function logout(){
        session(null);
        $this->redirect('Index/Login/login');
    }
}