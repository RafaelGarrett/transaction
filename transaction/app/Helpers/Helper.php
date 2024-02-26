<?php

namespace App\Helpers;

use GuzzleHttp;

class Helper
{
    static function requestAPI($url): object{
        $client = new GuzzleHttp\Client();
        $res = $client->get($url, ['verify' => false]);
        return $res;
    }
}