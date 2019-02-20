<?php
/**
 * Created by PhpStorm.
 * User: Pashted
 * Date: 18.02.2019
 * Time: 18:15
 */

require('functions.php');

global $filename;
$filename = 'file.txt';

$uploadfile = $_SERVER['DOCUMENT_ROOT'] . "/$filename";

$client_id = "d44388c9758a435b97d62e9894c12fc5"; // идентификатор приложения на oath.yandex.ru


include('template.php');