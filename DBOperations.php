<?php
class DBOperations{
    private $host = '127.0.0.1';
    private $user = 'root';
    private $db = 'login-register-system';
    private $pass = '';
    private $conn;

    public function __construct() {
        $this -> conn = new PDO("mysql:host=".$this -> host.";dbname=".$this -> db.";charset=utf8mb4",$this -> user, $this -> pass);
        //$this -> conn = @new mysqli($db_host, $db_username, $db_password, $db_name);
    }

    public function insertData($name,$email,$password){
        $unique_id = uniqid('', true);
        $hash = $this->getHash($password);
        $encrypted_password = $hash["encrypted"];
        $salt = $hash["salt"];

        $sql = 'INSERT INTO users SET unique_id =:unique_id,name =:name,
    email =:email,encrypted_password =:encrypted_password,salt =:salt,created_at = NOW()';
        $query = $this ->conn ->prepare($sql);
        $query->execute(array('unique_id' => $unique_id, ':name' => $name, ':email' => $email,
            ':encrypted_password' => $encrypted_password, ':salt' => $salt));
        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function checkLogin($email, $password) {
        $sql = 'SELECT * FROM users WHERE email = :email';
        $query = $this -> conn -> prepare($sql);
        $query -> execute(array(':email' => $email));
        $data = $query -> fetchObject();
        $salt = $data -> salt;
        $db_encrypted_password = $data -> encrypted_password;
        if ($this -> verifyHash($password.$salt,$db_encrypted_password) ) {
            $user["name"] = $data -> name;
            $user["email"] = $data -> email;
            $user["unique_id"] = $data -> unique_id;
            return $user;
        } else {
            return false;
        }
    }

    public function changePassword($email, $password){
        $hash = $this -> getHash($password);
        $encrypted_password = $hash["encrypted"];
        $salt = $hash["salt"];

        $sql = 'UPDATE users SET encrypted_password = :encrypted_password, salt = :salt WHERE email = :email';
        $query = $this -> conn -> prepare($sql);
        $query -> execute(array(':email' => $email, ':encrypted_password' => $encrypted_password, ':salt' => $salt));
        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function changeInfo($head, $type ,$text , $unique_id, $longitude , $latitude){
        $sql = 'INSERT INTO info SET head = :head, type = :type , text = :text , unique_id = :unique_id , longitude = :longitude , latitude = :latitude' ;
        $query = $this -> conn -> prepare($sql);
        $query -> execute(array( ':head' => $head, ':type' =>$type , ':text' => $text ,':unique_id' => $unique_id ,':longitude' => $longitude , ':latitude' => $latitude ));
        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function InfoRemove($head , $sno , $unique_id) {
        $sql = 'DELETE FROM info WHERE head = :head AND sno = :sno AND unique_id = :unique_id' ;
        $query = $this -> conn -> prepare($sql);
        $query -> execute(array( ':head' => $head , ':sno' => $sno ,':unique_id' => $unique_id));
        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function checkUserExist($email){
        $sql = 'SELECT COUNT(*) from users WHERE email =:email';
        $query = $this -> conn -> prepare($sql);
        $query -> execute(array('email' => $email));
        if($query){
            $row_count = $query -> fetchColumn();
            if ($row_count == 0){
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    public function getHash($password) {
        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = password_hash($password.$salt, PASSWORD_DEFAULT);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }

    public function verifyHash($password, $hash) {
        return password_verify ($password, $hash);
    }
}
?>