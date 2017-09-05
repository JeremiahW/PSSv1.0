<?php
/**
 * Created by PhpStorm.
 * User: Jixiao
 * Date: 8/25/2017
 * Time: 2:03 AM
 */

namespace app\index\model;


use think\Model;

class Purchase extends Model
{
    public function items()
    {
        return $this->hasMany("PurchaseItem","purchase_id","id");
    }

    public function type()
    {
        return $this->belongsTo("PurchaseType", "state","id");
    }

    public function sale()
    {
        return $this->belongsTo("Sale", "sale_id", "id");
    }

}