<?php
/**
 * Created by PhpStorm.
 * User: Jixiao
 * Date: 8/15/2017
 * Time: 10:57 PM
 */

namespace app\index\validate;


use think\Validate;

class SupplierContact extends Validate
{
    protected $rule = [
        'company_id'=>'require|number',
        'name'=>'require|max:50',
        'phone'=>'require|max:50',
        'email'=>'require|max:50',
        'position'=>'require|max:20',

    ];

    protected $message = [
        'name.require'=>'名称为必填字段',
        'name.max'=>'名称的长度为50个字符',
        'phone.require'=>'电话为必填字段',
        'phone.max'=>'电话长度为50个字符',
        'email.require'=>'邮箱为必填字段',
        'email.max'=>'路径长度为50',
        'position.require'=>'职务为必填字段',
        'position.max'=>'职务长度为20',
        'company_id.require'=>'上一级公司需要选择',
        'company_id.max'=>'上一级公司字段必需为数值',

    ];
}