<?php
/**
 * Created by PhpStorm.
 * User: Jixiao
 * Date: 8/15/2017
 * Time: 1:21 AM
 */

namespace app\index\validate;


use think\Validate;

class Supplier extends Validate
{
    protected $rule = [
        'company'=>'require|max:100',
        'address'=>'require|max:100',
        'logo'=>'require|max:255',

    ];

    protected $message = [
        'company.require'=>'用户名为必填字段',
        'company.max'=>'用户名的长度为100个字符',
        'address.require'=>'中文名称为必填字段',
        'address.max'=>'中文名的长度为100个字符',
        'logo.require'=>'邮箱为必填字段',
        'logo.max'=>'路径长度为255',

    ];

    protected $scene = [
        'add'=>['company','address','logo'],
        'editNoImage'=>['company','address'],
        'edit'=>['company','address','logo'],

    ];
}