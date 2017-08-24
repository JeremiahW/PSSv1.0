<?php
/**
 * Created by PhpStorm.
 * User: Jixiao
 * Date: 7/25/2017
 * Time: 9:49 AM
 */

namespace app\index\logic;


use app\common\BaseModel;
use think\Db;
use think\Loader;


class User extends BaseModel
{

    private $serivce;
    public function __construct()
    {
        parent::__construct();
        $this->service = Loader::model("User", "service");
    }

    public function Save($id, $username,$password, $repassword, $chinese, $phone, $email){
        $data = [
            "username"=> $username,
            "password"=> $password,
            "repassword"=> $repassword,
            "chinese"=> $chinese,
            "phone"=> $phone,
            "email"=> $email,
        ];
        //$validate = Loader::validate('User');
        //$result = $validate->scene('add')->check($data);

        $validate = Loader::validate("User");
      //  $validate = new \app\index\validate\User();

        $user = Loader::model("User");

        if(empty($id)){
            //添加
            $result = $validate->batch()->scene("add")->check($data);
            if($result == true){
               $user->allowField(true)->save($data);
            }
        }
        else if(empty($password) && empty($repassword)) {
            //修改, 不修改密码
            $result = $validate->batch()->scene("nopassword")->check($data);
            if($result===true) {
                $user->allowField(true)->save(["username" => $username, "chinese" => $chinese, "phone" => $phone, "email" => $email]
                    , ["id" => $id]);
            }
        }
        else{
            //修改密码
            $result = $validate->batch()->scene("edit")->check($data);
            if($result){
                $user->allowField(true)->save($data, ["id"=>$id]);
            }
        }

        if(!$result)
            return $validate->getError();
        else
            return $result;
    }

    public function Get($page, $offset = -1, $pageSize=-1,$condition=[]){
        if($pageSize==-1){
            $pageSize = config('paginate.list_rows');
        }

        if($offset==-1){
            $page = 0;
            $offset = $page *  $pageSize;
        }
        $count = Db::table($this->prefix."user")->where($condition)->count();
        $users = Db::table($this->prefix."user")->where($condition)->limit($offset, $pageSize)->select();
        return ["users"=>$users, "count"=>$count];
    }

    public function GetUser($id){
        return $this->serivce->GetUser($id);
    }

    public function UpdateStatus($users, $status = 1){
        $decodeUsers = json_decode($users, true);

        Db::startTrans();
        $result = true;

        try{
            for($i=0;$i< count($decodeUsers);$i++) {
                $id = $decodeUsers[$i]["id"];
                Db::table($this->prefix."user")->where("id", $id)->update(['is_deleted'=>$status]);
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