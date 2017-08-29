<?php
/**
 * Created by PhpStorm.
 * User: Jixiao
 * Date: 8/30/2017
 * Time: 4:25 AM
 */

namespace app\common;


class PssUtils
{
    public static function validateDate($date, $format = 'Y-m-d H:i:s')
    {
        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

}