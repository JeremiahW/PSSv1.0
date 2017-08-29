<?php
/**
 * Created by PhpStorm.
 * User: Jixiao
 * Date: 8/24/2017
 * Time: 11:50 PM
 */

namespace app\index\model;


use think\Model;

class Sale extends Model
{
    function client()
    {
        return $this->belongsTo("Client", "client_id", "id")->field("id, name, phone, email, address");
    }

    function user()
    {
        return $this->belongsTo("User", "user_id", "id")->field("id, username,chinese, phone, email");
    }

    function products()
    {
        //最终关联到Product的数据,通过中间表SaleProduct, 中间表的外键, 中间表的关联键关联到本Model(Sale)表的Id
        return $this->belongsToMany("Product", "SaleProduct", "product_id", "sale_id");
    }

    function items()
    {
        return $this->hasMany("SaleProduct", "sale_id","id");
    }

    function type()
    {
        return $this->belongsTo("SaleType", "type_id","id");
    }
}