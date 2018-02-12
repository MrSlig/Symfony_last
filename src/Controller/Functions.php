<?php

namespace App\Controller;

class Functions {
    /**
     * @param $length
     * @return string
     */
    public static function getRndStr($length) {
        $alphabet   =   '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $power = 10 + 26*2;
        $randStr = '';
        for ($i = 0; $i < $length; $i++)    {
            $randStr .= $alphabet[rand(0, $power - 1)];
        }
        return $randStr;
    }
}