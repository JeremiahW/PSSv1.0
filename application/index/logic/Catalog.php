<?php
/**
 * Created by PhpStorm.
 * User: Jixiao
 * Date: 8/17/2017
 * Time: 1:17 AM
 */

namespace app\index\logic;


use app\common\BaseModel;
use think\Loader;

class Catalog extends BaseModel
{
    private $model;
    private $resultSet;
    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->model = Loader::model("Catalog");
        $this->resultSet = [];
    }

    public function Get2($condition, $page, $pageSize)
    {
        if(empty($page) || $page == -1) $page = 1;
        if(empty($pageSize) || $pageSize==-1) $pageSize = config('paginate.list_rows');

        $offset = ($page-1) * $pageSize;

        $count =  $this->model->with("parent")->where($condition)->count();
        $rows =  $this->model->with("parent")->where($condition)->limit($offset, $pageSize)->select();

        return ["rows"=>$rows, "count"=>$count];
    }

    public function Get()
    {
        $rows = $this->GetParent();
        return ["rows"=>$rows, "count"=>sizeof($rows)];
    }

    public function GetParent()
    {
        $rows = $this->model->with("parent")->where("parent_id=-1")->select();
        $this->resultSet = [];

        for($i=0; $i<sizeof($rows); $i++)
        {
            $id = $rows[$i]["id"];
            $level = $rows[$i]["level"];
            array_push($this->resultSet, $rows[$i]);
            $this->GetChildren($id, $level);
        }

        return $this->resultSet;
    }

    public function GetChildren($pid, $level)
    {
        $rows = $this->model->with("parent")->where("parent_id=".$pid)->select();
        $level++;
        if(sizeof($rows)==0) return;
        for ($i=0; $i<sizeof($rows);$i++){
            $id = $rows[$i]["id"];
            $rows[$i]["level"] = $level;
            array_push($this->resultSet, $rows[$i]);

            //递归了
            $this->GetChildren($id, $level);
        }
    }

    public function Save($id, $subject, $description, $pid,$seqno)
    {
        $data=[
            "subject"=>$subject,
            "description"=>$description,
            "parent_id"=>$pid,
            "seqno"=>$seqno,
        ];

        $validate = Loader::validate("Catalog");
        $model = Loader::model("Catalog");
        $result = $validate->batch()->check($data);
        if($result == true)
        {
            if(empty($id))
            {
                $model->allowField(true)->save($data);
            }
            else
            {
                $model->allowField(true)->save($data, ["id"=>$id]);
            }
        }

        if(!$result)
            return $validate->getError();
        else
            return $result;
    }
}