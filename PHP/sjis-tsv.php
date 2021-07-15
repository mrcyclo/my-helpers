<?php

if (!function_exists('tsv_get_contents')) {
    function tsv_get_contents($contents)
    {
        $data = [];

        $contents = mb_convert_encoding($contents, 'UTF-8', 'SJIS');
        $contents = trim($contents);

        $handle = fopen('php://temp', 'w+');
        fwrite($handle, $contents);
        fseek($handle, 0);
        while (($row = fgetcsv($handle, 0, "\t")) !== false) {
            $data[] = $row;
        }
        fclose($handle);

        return $data;
    }
}

if (!function_exists('tsv_put_contents')) {
    function tsv_put_contents($path, $data = [])
    {
        $handle = fopen('php://temp', 'w+');
        foreach ($data as $row) {
            fputcsv($handle, $row, "\t");
        }
        fseek($handle, 0);
        $contents = stream_get_contents($handle);
        fclose($handle);
        $contents = mb_convert_encoding($contents, 'SJIS', 'UTF-8');
        $contents = trim($contents);

        file_put_contents($path, $contents);
    }
}
