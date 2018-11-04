<?php
// header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once $_SERVER['DOCUMENT_ROOT'] . '/api/__config/database.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/api/__objects/user.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/api/__shared/utilities.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = validOrThrow($_POST['username'], "'username' isn't set");
  $password = validOrThrow($_POST['password'], "'password' isn't set");

  // Connect to database
  $database = new Database();
  $db = $database->getConnection();

  // Get user in database
  $user = User::getByUsername($db, $username);
  validOrThrow($user, "User doesn't exist", 404);

  // Is password valid
  if(!$user->doesPasswordMatch($password)) {
    printJSONError("Password doesn't match", 401);
  }

  // Print data logged in successfully
  printJSONData($user -> toSafe());
} else {
  printJSON(array("error" => "Bad request"), 405);
}

?>
