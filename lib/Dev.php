<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

function debug($str)
{
    echo '<pre>';
    var_dump($str);
    echo '</pre>';
    exit;
}