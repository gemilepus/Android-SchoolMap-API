<?php
class DBOperations{
    private $conn;

    public function __construct() {
        include "connMysqlObj.php";
        $this -> conn = new PDO("mysql:host=".$dbhost.";dbname=".$dbname.";charset=utf8mb4", $dbuser, $dbpass);
    }

    public function insertData($name,$email,$password){
        $unique_id = uniqid('', true);
        $hash = $this->getHash($password);
        $encrypted_password = $hash["encrypted"];
        $salt = $hash["salt"];

        $sql = 'INSERT INTO users SET unique_id =:unique_id,name =:name,
    email =:email,encrypted_password =:encrypted_password,salt =:salt,created_at = NOW()';
        $query = $this ->conn ->prepare($sql);
        $query -> bindParam(':unique_id', $unique_id, PDO::PARAM_STR);
        $query -> bindParam(':name', $name, PDO::PARAM_STR);
        $query -> bindParam(':email', $email, PDO::PARAM_STR);
        $query -> bindParam(':encrypted_password', $encrypted_password, PDO::PARAM_STR);
        $query -> bindParam(':salt', $salt, PDO::PARAM_STR);
        $query -> execute();

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function checkLogin($email, $password) {
        $sql = 'SELECT * FROM users WHERE email = :email';
        $query = $this -> conn -> prepare($sql);
        $query -> bindParam(':email', $email, PDO::PARAM_STR);
        $query -> execute();
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
        $query -> bindParam(':email', $email, PDO::PARAM_STR);
        $query -> bindParam(':encrypted_password', $encrypted_password, PDO::PARAM_STR);
        $query -> bindParam(':salt', $salt, PDO::PARAM_STR);
        $query -> execute();

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function newinfo($head, $type ,$text , $unique_id, $longitude , $latitude){
        $sql = 'INSERT INTO info SET head = :head, type = :type , text = :text , unique_id = :unique_id , longitude = :longitude , latitude = :latitude' ;
        $query = $this -> conn -> prepare($sql);
        $query -> bindParam(':head', $head, PDO::PARAM_STR);
        $query -> bindParam(':type', $type, PDO::PARAM_STR);
        $query -> bindParam(':text', $text, PDO::PARAM_STR);
        $query -> bindParam(':unique_id', $unique_id, PDO::PARAM_STR);
        $query -> bindParam(':longitude', $longitude, PDO::PARAM_STR);
        $query -> bindParam(':latitude', $latitude, PDO::PARAM_STR);
        $query -> execute();

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function InfoRemove($head , $sno , $unique_id) {
        $sql = 'DELETE FROM info WHERE head = :head AND sno = :sno AND unique_id = :unique_id' ;
        $query = $this -> conn -> prepare($sql);
        $query -> bindParam(':head', $head, PDO::PARAM_STR);
        $query -> bindParam(':sno', $sno, PDO::PARAM_INT);
        $query -> bindParam(':unique_id', $unique_id, PDO::PARAM_STR);
        $query -> execute();

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function checkUserExist($email){
        $sql = 'SELECT COUNT(*) from users WHERE email =:email';
        $query = $this -> conn -> prepare($sql);
        $query -> bindParam(':email', $email, PDO::PARAM_STR);
        $query -> execute();
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

    public function getdata() {

        $sql = 'SELECT * FROM info ORDER BY sno';
        $query = $this -> conn -> prepare($sql);
        $query -> execute();

        $res = array();
        $res['android'] = array();
        
        while ($row_result = $query->fetch(PDO::FETCH_ASSOC)) {
    
            $row_array['head'] = $row_result['head'];
    
            $row_array['type'] = $row_result['type'];
    
            $row_array['text'] = $row_result['text'];
            
            $row_array['sno'] = $row_result['sno'];
    
            array_push($res['android'], $row_array);
    
        }

        return $res;
    }

    public function getdatabyid($id) {

        $sql = 'SELECT * FROM info WHERE unique_id = :id';
        $query = $this -> conn -> prepare($sql);
        $query -> bindParam(':id', $id, PDO::PARAM_STR);
        $query -> execute();

        $res = array();
        $res['android'] = array();

        while ($row_result = $query->fetch(PDO::FETCH_ASSOC)) {

            $row_array['head'] = $row_result['head'];

            $row_array['type'] = $row_result['type'];

            $row_array['text'] = $row_result['text'];

            $row_array['sno'] = $row_result['sno'];

            $row_array['longitude'] = $row_result['longitude'];

            $row_array['latitude'] = $row_result['latitude'];

            array_push($res['android'], $row_array);

        }

        return $res;
    }

}
?>