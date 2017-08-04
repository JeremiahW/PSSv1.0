<?php
/**
 * Created by PhpStorm.
 * User: Jixiao
 * Date: 7/24/2017
 * Time: 4:02 PM
 */

namespace app\index\validate;


use think\Validate;

class User extends Validate
{
    protected $rule = [
        'username'=>'require|max:15',
        'chinese'=>'require|max:20',
        'email'=>'require|email|max:100',
        'phone'=>'require|max:1000',
        'password'=>'require|max:20',
        'repassword'=>'require|confirm:password',
    ];

    protected $message = [
        'username.require'=>'用户名为必填字段',
        'username.max'=>'用户名的长度为15个字符',
        'chinese.require'=>'中文名称为必填字段',
        'chinese.max'=>'中文名的长度为20个字符',
        'email.require'=>'邮箱为必填字段',
        'email.max'=>'邮箱的长度为100个字符',
        'email.email'=>'请输入正确的邮箱格式',
        'password.require'=>'密码为必填字段',
        'password.max'=>'密码的长度为20个字符',
        'repassword.require'=>'重复密码为必填字段',
        'repassword.confirm'=>'两次密码输入不一致',
     ];

    protected $scene = [
        'add'=>['username','chinese','email','phone', 'password','repassword'],
        'edit'=>['chinese','email','phone', 'password','repassword'],
        'nopassword'=>['username','chinese','email','phone'],
    ];
}