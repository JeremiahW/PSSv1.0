<?php
/**
 * Created by PhpStorm.
 * User: Jixiao
 * Date: 8/3/2017
 * Time: 8:50 AM
 */

namespace app\index\validate;


use think\Validate;

class Department extends Validate
{
    protected $rule = [
        'subject'=>'require|max:20',
        'seqno'=>'require|number',
    ];

    protected $message = [
        'subject.require'=>'菜单名称为必填字段',
        'subject.max'=>'菜单名称的长度为20个字符',

        'seqno.require'=>'显示顺序为必填字段',
        'seqno.number'=>'显示顺序为序号',
    ];
}