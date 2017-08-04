<?php
/**
 * Created by PhpStorm.
 * User: Jixiao
 * Date: 7/27/2017
 * Time: 3:56 PM
 */

namespace app\index\model;


use think\Model;

class Module extends Model
{
    public function parent(){
        return $this->belongsTo("Module", "parent_id", "id")->field("id,subject");
    }

    public function children(){
        return $this->hasMany("Module","parent_id", "id")->where(["is_deleted"=>0]);
    }
}