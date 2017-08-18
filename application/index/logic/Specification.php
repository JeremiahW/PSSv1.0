<?php
/**
 * Created by PhpStorm.
 * User: Jixiao
 * Date: 8/17/2017
 * Time: 11:16 PM
 */

namespace app\index\logic;


use app\common\BaseModel;
use think\Db;
use think\Loader;

class Specification extends BaseModel
{
    private $type;
    private $specification;
    public function __construct(array $data = [])
    {
        parent::__construct($data);

        $this->type = Loader::model("SpecificationType");
        $this->specification = Loader::model("Specification");
    }

    public function GetType($page, $offset=-1, $pageSize = -1, $condition=[])
    {
        if($pageSize==-1){
            $pageSize = config('paginate.list_rows');
        }

        if($offset==-1){
            $page = 0;
            $offset = $page *  $pageSize;
        }


        $count = Db::table($this->prefix."specification_type")->where($condition)->count();
        $rows = Db::table($this->prefix."specification_type")->where($condition)->limit($offset, $pageSize)->select();
        return ["rows"=>$rows, "count"=>$count];
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


        $model = Loader::model("Specification");

        $count =  $model->with("type")->count();
        $rows = $model->with("type")->limit($offset, $pageSize)->select();
        return ["rows"=>$rows, "count"=>$count];
    }

    public function SaveType($id, $subject)
    {
        $data=[
            "subject"=>$subject,
        ];

        $validate = Loader::validate("SpecificationType");
        $m = Loader::model("SpecificationType");
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

    public function Save($id, $code, $subject, $description,$typeId)
    {
        $data=[
            "subject"=>$subject,
            "code"=>$code,
            "description"=>$description,
            "type_id"=>$typeId,
        ];

        $validate = Loader::validate("Specification");
        $m = Loader::model("Specification");
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
}