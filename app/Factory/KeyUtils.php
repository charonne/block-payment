<?php

namespace App\Factory;

class KeyUtils
{
    /**
     * Generate key
     */
    public function generate($length = 10)
    {
        $key = md5(microtime().rand());
        $key = substr($key, 0, $length);
        return $key;
    }
    
}