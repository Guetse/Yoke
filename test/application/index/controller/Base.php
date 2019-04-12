<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2019/2/17
 * Time: 15:38
 */
namespace app\index\Controller;

use think\Controller;
use think\Db;
class Base extends Controller
{
    public function _initialize()
    {
        $controller = $this->request->controller();
        $action = $this->request->action();
        if (!session('admin_name') || !session('admin_id')) {

            if ($action == 'login' && $controller == 'Login') {
                return;
            } else {
                $this->error('请先登录', 'index/login/login');
            }
        }


    }


}