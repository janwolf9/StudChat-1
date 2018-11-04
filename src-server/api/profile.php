<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once $_SERVER['DOCUMENT_ROOT'] . '/api/__config/database.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/api/__objects/user.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/api/__shared/utilities.php';

session_start();
$user = validOrThrow($_SESSION['user'], "Unauthorized", 401);

printJSONData($user->toSafe());
?>
