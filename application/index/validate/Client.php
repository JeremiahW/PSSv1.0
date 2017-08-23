<?php
/**
 * Created by PhpStorm.
 * User: Jixiao
 * Date: 8/23/2017
 * Time: 5:18 AM
 */

namespace app\index\validate;


use think\Validate;

class Client extends Validate
{
    protected $rule = [
        'name'=>'require|max:255',
        'phone'=>'require|max:255',
        'email'=>'require|email',
        'address'=>'require|max:255',
    ];

    protected $message = [
        'name.require'=>'姓名为必填字段',
        'name.max'=>'姓名的长度为20个字符',

        'phone.require'=>'电话为必填字段',
        'phone.max'=>'电话的长度太长了',

        'email.require'=>'邮箱地址为必填字段',
        'email.email'=>'邮箱格式错误',

        'address.require'=>'地址为必填字段',
        'address.max'=>'地址填写的太长了.',
    ];
}