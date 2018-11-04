<?php
class User {
  private static $table_name = 'Users';


  public static function withID($conn, $id) {
    $query = "SELECT * FROM " . self::$table_name . " WHERE id=:id";
    $stmt = $conn -> prepare($query);

    // Validate
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    return self::fromQuery($stmt);
  }
  public static function withUsername($conn, $username) {
    $query = "SELECT * FROM " . self::$table_name . " WHERE username=:username";
    $stmt = $conn -> prepare($query);

    // Validate
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);

    return self::fromQuery($stmt);
  }

  private static function fromQuery($stmt) {
    $stmt -> execute();

    // If user doesn't exist
    if($stmt -> rowCount() == 0) return NULL;

    // Set data
    return self::fromFetch($stmt->fetch());
  }
  private static function fromFetch($dbUser) {
    $user = new self();
    $user->id = $dbUser['id'];
    $user->username = $dbUser['username'];
    $user->email = $dbUser['email'];
    $user->password = $dbUser['password'];
    $user->created = $dbUser['created'];

    return $user;
  }


  public static function registerUser($conn, $username, $email, $password) {
    $password = password_hash($password, PASSWORD_BCRYPT);

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
