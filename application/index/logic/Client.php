<?php
/**
 * Created by PhpStorm.
 * User: Jixiao
 * Date: 8/23/2017
 * Time: 4:53 AM
 */

namespace app\index\logic;


use app\common\BaseModel;
use think\Loader;

class Client extends BaseModel
{
    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }

    public function Get($page, $offset = -1, $pageSize=-1, $condition=[])
    {
        if($pageSize==-1){
            $pageSize = config('paginate.list_rows');
        }

        if($offset==-1){
            $page = 0;
            $offset = $page *  $pageSize;
        }


        $model = Loader::model("Client");

        $count = $model->where($condition)->count();
        $rows = $model->where($condition)->limit($offset, $pageSize)->select();
        return ["rows"=>$rows, "count"=>$count];
    }

    public function Save($client,$id)
    {
        $validate = Loader::validate("Client");
        $m = Loader::model("Client");
        $result = $validate->batch()->check($client);
        if($result == true){
            if(empty($id))
            {
                $m->allowField(true)->save($client);
            }
            else
            {
                $m->allowField(true)->save($client, ["id"=>$id]);
            }
        }

        if(!$result)
            return $validate->getError();
        else
            return $result;
    }

}