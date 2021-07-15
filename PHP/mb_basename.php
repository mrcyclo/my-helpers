<?php

if (!function_exists('mb_basename')) {
    // /home/ramki/ramki.pdf -> ramki.pdf
    function mb_basename($path)
    {
        setlocale(LC_ALL, 'C.UTF-8');
        return pathinfo($path, PATHINFO_BASENAME);
    }
}

if (!function_exists('mb_filename')) {
    // /home/ramki/ramki.pdf -> ramki
    function mb_filename($path)
    {
        setlocale(LC_ALL, 'C.UTF-8');
        return pathinfo($path, PATHINFO_FILENAME);
    }
}
