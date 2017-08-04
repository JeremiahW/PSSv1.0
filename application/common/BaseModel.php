<?php
/**
 * Created by PhpStorm.
 * User: Jixiao
 * Date: 7/25/2017
 * Time: 11:19 AM
 */

namespace app\common;


class BaseModel
{
    protected $prefix;
    public function __construct($data = [])
    {
        //parent::__construct($data);
        $this->prefix = config("database.prefix");
    }

}