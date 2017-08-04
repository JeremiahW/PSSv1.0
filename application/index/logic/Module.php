<?php
/**
 * Created by PhpStorm.
 * User: Jixiao
 * Date: 7/27/2017
 * Time: 3:43 PM
 */

namespace app\index\logic;


use app\common\BaseModel;
use think\Db;
use think\Loader;

class Module extends BaseModel
{
    private $module;
    private $resultSet;
    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->module = new \app\index\model\Module();
        $this->resultSet = [];
    }

    public function UpdateStatus($modules, $status = 1){
        $decodeModules = json_decode($modules, true);

        Db::startTrans();
        $result = true;

        try{
            for($i=0;$i< count($decodeModules);$i++) {
                $id = $decodeModules[$i]["id"];
                Db::table($this->prefix."module")->where("id", $id)->update(['is_deleted'=>$status]);
            }
            Db::commit();
        }
        catch (\Exception $e){
            Db::rollback();
            $result = $e->getMessage();
        }

        return $result;
    }

    public function Save($id,$subject, $module, $controller, $action, $pid, $icon, $description, $seqno)
    {
        $data=[
            "subject"=>$subject,
            "module"=>$module,
            "controller"=>$controller,
            "action"=>$action,
            "icon"=>$icon,
            "description"=>$description,
            "parent_id"=>$pid,
            "seqno"=>$seqno,
        ];

        $validate = Loader::validate("Module");
        $module = Loader::model("Module");
        $result = $validate->batch()->check($data);
        if($result == true){
            if(empty($id))
            {
               $module->allowField(true)->save($data);
            }
            else
            {
                $module->allowField(true)->save($data, ["id"=>$id]);
            }
        }

        if(!$result)
            return $validate->getError();
        else
            return $result;
    }

    public function Get2($condition, $page, $pageSize){

        if(empty($page) || $page == -1) $page = 1;
        if(empty($pageSize) || $pageSize==-1) $pageSize = config('paginate.list_rows');

        $offset = ($page-1) * $pageSize;

        $count =  $this->module->with("parent")->where($condition)->count();
        $rows =  $this->module->with("parent")->where($condition)->limit($offset, $pageSize)->select();

        return ["rows"=>$rows, "count"=>$count];
    }

    public function GetForMenu(){
       // $rows = Db::table($this->prefix."module")->with("parent, children")->select();
         $rows = $this->module->with("parent,children")->where(["parent_id"=>-1,"is_deleted"=>0])->select();
        return $rows;
    }

    /*
     * 不会有太多的模块， 因此采用递归将模块一次性取出。不采用分页的形式取出模块。
     * */
    public function Get($page, $offset = -1, $pageSize=-1){
        if($pageSize==-1){
            $pageSize = config('paginate.list_rows');
        }

        if($offset==-1){
            $page = 0;
            $offset = $page *  $pageSize;
        }

        //$count = Db::table($this->prefix."module")->count();
        //$rows = Db::table($this->prefix."module")->limit($offset, $pageSize)->select();

        $count =  $this->module->with("parent")->where("parent_id=-1")->count();
        $rows = $this->GetParents();
        return ["rows"=>$rows, "count"=>$count];
    }

    protected function GetParents(){
        $rows = $this->module->with("parent")->where("parent_id=-1")->select();
        $this->resultSet = [];

        for( $i=0;$i<sizeof($rows);$i++){
            $id = $rows[$i]->id;
            $level = $rows[$i]->level;
            array_push($this->resultSet, $rows[$i]);
            $this->GetChildren($id,$level);
        }

        return $this->resultSet;
    }

    protected function GetChildren($pid, $level){
        $rows = $this->module->with("parent")->where("parent_id=".$pid)->select();
        $level++;
        if(sizeof($rows)==0) return;
        for ($i=0; $i<sizeof($rows);$i++){
            $id = $rows[$i]->id;
            $rows[$i]->level = $level;
            array_push($this->resultSet, $rows[$i]);

            //递归了
            $this->GetChildren($id, $level);
        }
    }

}