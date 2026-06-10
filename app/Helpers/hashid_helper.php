<?php

use Hashids\Hashids;

if (!function_exists('hashid_encode')) {
    function hashid_encode($id)
    {
        $hashids = new Hashids(config('app.key'), 10);
        return $hashids->encode($id);
    }
}

if (!function_exists('hashid_decode')) {
    function hashid_decode($hash)
    {
        $hashids = new Hashids(config('app.key'), 10);
        $decoded = $hashids->decode($hash);
        return $decoded[0] ?? null;
    }
}