<?php

if (!function_exists('s3_temporary_url')) {
    function s3_temporary_url($path, $expirationMinutes = 5, $downloadable = false, $filename = null) {
        $responseContentDisposition = '';
        if ($downloadable) {
            $responseContentDisposition .= 'attachment;';
        }
        if ($filename !== null) {
            $responseContentDisposition .= 'filename=' . rawurlencode($filename);
        }

        $options = [];
        if ($responseContentDisposition) {
            $options['ResponseContentDisposition'] = $responseContentDisposition;
        }

        $temporaryUrl = Storage::disk('s3')->temporaryUrl(
            $path,
            now()->addMinutes($expirationMinutes),
            $options
        );

        return $temporaryUrl;
    }
}
