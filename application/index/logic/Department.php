<?php
/**
 * Created by PhpStorm.
 * User: Jixiao
 * Date: 8/3/2017
 * Time: 8:49 AM
 */

namespace app\index\logic;


use app\common\BaseModel;
use think\Db;
use think\Loader;

class Department extends BaseModel
{
    private $model;
    private $resultSet;
    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->resultSet = [];
        $this->model = Loader::model("Department");
    }

    public function Get($page, $offset=-1, $pageSize = -1)
    {
        if($pageSize==-1){
            $pageSize = config('paginate.list_rows');
        }

        if($offset==-1){
            $page = 0;
            $offset = $page *  $pageSize;
        }

        $count = Db::table($this->prefix."department")->count();
        $rows = Db::table($this->prefix."department")->limit($offset, $pageSize)->select();
        return ["rows"=>$rows, "count"=>$count];
    }

    public function Save($id, $subject, $description, $seqno)
    {
        $data=[
            "subject"=>$subject,
            "description"=>$description,
            "seqno"=>$seqno,
        ];

        $validate = Loader::validate("Department");
        $m = Loader::model("Department");
        $result = $validate->batch()->check($data);
        if($result == true){
            if(empty($id))
            {
                $m->allowField(true)->save($data);
            }
            else
            {
                $m->allowField(true)->save($data, ["id"=>$id]);
            }
        }

        if(!$result)
            return $validate->getError();
        else
            return $result;
    }

    public function UpdateStatus($modules, $status = 1){
        $decodeModules = json_decode($modules, true);

        Db::startTrans();
        $result = true;

        try{
            for($i=0;$i< count($decodeModules);$i++) {
                $id = $decodeModules[$i]["id"];
                Db::table($this->prefix."department")->where("id", $id)->update(['is_deleted'=>$status]);
            }
            Db::commit();
        }
        catch (\Exception $e){
            Db::rollback();
            $result = $e->getMessage();
        }

        return $result;
    }
}