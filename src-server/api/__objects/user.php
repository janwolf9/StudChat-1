<?php
class User {
  private static $table_name = 'Users';

  private static function hashPassword($password){
    return password_hash($password, PASSWORD_BCRYPT);
  }

  public static function getByUsername($conn, $username) {
    $query = "SELECT * FROM " . self::$table_name . " WHERE username=:username";
    $stmt = $conn -> prepare($query);

    // Validate
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);

    $stmt -> execute();

    // If user doesn't exist
    if($stmt -> rowCount() == 0) return NULL;

    // Set data
    $dbUser = $stmt->fetch();

    // Set data
    $user = new self();
    $user->id = $dbUser['id'];
    $user->username = $dbUser['username'];
    $user->email = $dbUser['email'];
    $user->password = $dbUser['password'];
    $user->created = $dbUser['created'];

    return $user;
  }

  public static function registerUser($conn, $username, $email, $password) {
    $password = self::hashPassword($password);

    $query = "INSERT INTO " . self::$table_name . " (username, email, password) VALUES (:username, :email, :password)";
    $stmt = $conn -> prepare($query);

    // Validate
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':password', $password, PDO::PARAM_STR);

    return $stmt -> execute();
  }

  public $id;
  public $username;
  public $email;
  public $password;
  public $created;

  public function doesPasswordMatch($password) {
    return password_verify($password, $this->password);
  }

  public function toSafe() {
    return array(
      "id"=>$this->id,
      "username"=>$this->username,
      "email"=>$this->email,
      "created"=>$this->created,
    );
  }
}
?>
