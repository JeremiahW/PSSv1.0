<?php
/**
 * Created by PhpStorm.
 * User: Jixiao
 * Date: 7/27/2017
 * Time: 3:40 PM
 */

namespace app\index\controller;


use app\common\BaseController;
use think\Loader;
use think\Request;

class Module extends BaseController
{
    protected $module;

    function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->module = Loader::model("Module", "logic");
    }

    function index(){
        $this->assign("pageSize", $this->pageSize);
        $this->assign("serverRoot", $this->serverRoot);
        return $this->fetch( ":index");
    }

    function get(){
        $offset = Request::instance()->param("offset");
        $pageSize = Request::instance()->param("limit");
        $resultSet = $this->module->Get(-1, $offset, $pageSize);
        return json(["total"=>$resultSet["count"], "rows"=>$resultSet["rows"]]);
    }

    function getMenus(){
        $resultSet = $this->module->GetForMenu();
        return json($resultSet);
    }

    function getParent(){

        $term = Request::instance()->param("q");
        $page = Request::instance()->param("page");
        $pageSize = config('paginate.list_rows');

        $condition['subject'] = array('like', "%$term%");

        $resultSet = $this->module->Get2($condition, $page, $pageSize);

        return json(["total"=>$resultSet["count"], "rows"=>$resultSet["rows"]]);

    }

    function save(){
        if(Request::instance()->isPost()){
            $id = Request::instance()->param("id");
            $parent_id = Request::instance()->param("pid");
            $subject = Request::instance()->param("subject");
            $module = Request::instance()->param("module");
            $controller = Request::instance()->param("controller");
            $action = Request::instance()->param("action");
            $icon = Request::instance()->param("icon");
            $description = Request::instance()->param("description");
            $seqno = Request::instance()->param("seqno");

            $m = Loader::model("Module","logic");

            $result =  $m->Save($id, $subject, $module, $controller, $action, $parent_id, $icon, $description,$seqno);

        }
        else{
            $result = false;
        }

        return json($result);
    }

    function inactive(){
        $modules = Request::instance()->param("modules");
        $result = $this->module->UpdateStatus($modules, 1);
        return $result;
    }

    function active(){
        $modules = Request::instance()->param("modules");
        $result = $this->module->UpdateStatus($modules, 0);
        return $result;
    }
}