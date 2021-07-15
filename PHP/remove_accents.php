<?php

if (!function_exists('remove_accents')) {
    function remove_accents($str) {
        setlocale(LC_CTYPE, 'en_US');
        return iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $str);
    }
}
