<?php

//Ruta absoluta
function urlProtocol()
{

    $base_dir = __DIR__; // Absolute path to your installation, ex: /var/www/mywebsite
    // $doc_root = preg_replace("!{$_SERVER['SCRIPT_NAME']}$!", '', $_SERVER['SCRIPT_FILENAME']);
    $doc_root = preg_replace("!{$_SERVER['SCRIPT_NAME']}$!", '', $_SERVER['SCRIPT_FILENAME']);
    // $base_url = preg_replace("!^{$doc_root}!", '', $base_dir);
    $base_url = preg_replace("!^" . preg_quote($doc_root, '!') . "!", '', $base_dir);
    $base_url = str_replace('\\', '/', $base_url);
    $base_url = str_replace($doc_root, '', $base_url);
    $protocol = empty($_SERVER['HTTPS']) ? 'http' : 'https';

    return $protocol;
}

