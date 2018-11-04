<?php
// header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once $_SERVER['DOCUMENT_ROOT'] . '/api/__config/database.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/api/__objects/user.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/api/__shared/utilities.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = validOrThrow($_POST['username'], "'username' isn't set");
  $email = validOrThrow($_POST['email'], "'email' isn't set");
  $password = validOrThrow($_POST['password'], "'password' isn't set");

  // Connect to database
  $database = new Database();
  $db = $database->getConnection();

  if(!User::registerUser($db, $username, $email, $password)){
    printJSONError("Username is already taken", 409);
  }

  $user = User::withUsername($db, $username);

  session_start();
  $_SESSION['user'] = $user;

  printJSONData($user->toSafe());
} else {
  printJSON(array("error" => "Bad request"), 405);
}

?>
