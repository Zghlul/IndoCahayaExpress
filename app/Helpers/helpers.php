<?php

use App\Models\Setting;

if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        return Setting::get($key, $default);
    }
}

if (!function_exists('rupiah')) {
    function rupiah($angka)
    {
        return "Rp " . number_format($angka, 0, ',', '.');
    }
}

if (!function_exists('firstTwoSentences')) {
    function firstTwoSentences($text)
    {
        if (empty($text)) {
            return '—';
        }

        // Pecah berdasarkan tanda . ! ? diikuti spasi atau akhir string
        $sentences = preg_split('/(?<=[.!?])\s+/', $text, -1, PREG_SPLIT_NO_EMPTY);

        if (count($sentences) <= 2) {
            return $text;
        }

        $firstTwo = array_slice($sentences, 0, 2);
        return trim(implode('. ', $firstTwo)) . '.';
    }
}
