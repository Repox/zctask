<?php

// Simple helpers

function issetOr(&$first, $alternative = NULL)
{
    $output = '';
    if (isset($first)) {
        $output = $first;
    } else {
        $output = $alternative;
    }
    return $output;
}

function app_path()
{
	return getcwd()."/app";
}

function redirect($url, $response_code = null)
{
	header('Location: '. url($url), $response_code);
	exit;
}

function url($uri){
	return sprintf("%s://%s%s", isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http', $_SERVER['SERVER_NAME'], $uri);
}

function now()
{
    return date("Y-m-d H:i:s");
}