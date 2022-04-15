<?php
require 'vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require_once 'DBOperations.php';

class Functions{
    public static $key = "test_key";
    private $db;

    public function __construct() {
        $this -> db = new DBOperations();
    }

    public function registerUser($name, $email, $password) {
        $db = $this -> db;

        if (!empty($name) && !empty($email) && !empty($password)) {
            if ($db -> checkUserExist($email)) {
                $response["result"] = "failure";
                $response["message"] = "User Already Registered !";
                return json_encode($response);
            } else {
                $result = $db -> insertData($name, $email, $password);
                if ($result) {
                    $response["result"] = "success";
                    $response["message"] = "User Registered Successfully !";
                    return json_encode($response);
                } else {
                    $response["result"] = "failure";
                    $response["message"] = "Registration Failure";
                    return json_encode($response);
                }
            }
        } else {
            return $this -> getMsgParamNotEmpty();
        }
    }

    public function loginUser($email, $password) {
        $db = $this -> db;

        if (!empty($email) && !empty($password)) {
            if ($db -> checkUserExist($email)) {
                $result =  $db -> checkLogin($email, $password);
                if(!$result) {
                    $response["result"] = "failure";
                    $response["message"] = "Invaild Login Credentials";
                    return json_encode($response);
                } else {
                   
                    $payload = array(
                        "name" => $result["name"],
                        "unique_id" => $result["unique_id"],
                        "iat" => time(),
                        "exp" => time() + 300,
                    );
                    $jwt = JWT::encode($payload, static::$key, 'HS256');
                    
                    $response["result"] = "success";
                    $response["message"] = "Login Successful";
                    $response["user"] = $result;
                    $response["token"] = $jwt;
                    return json_encode($response);
                }
            } else {
                $response["result"] = "failure";
                $response["message"] = "Invaild Login Credentials";
                return json_encode($response);
            }
        } else {
            return $this -> getMsgParamNotEmpty();
        }
    }

    public function changePassword($email, $old_password, $new_password) {
        $db = $this -> db;

        if (!empty($email) && !empty($old_password) && !empty($new_password)) {
            if(!$db -> checkLogin($email, $old_password)){

                $response["result"] = "failure";
                $response["message"] = 'Error Old Password';
                return json_encode($response);
            } else {
                $result = $db -> changePassword($email, $new_password);
                if($result) {
                    $response["result"] = "success";
                    $response["message"] = "Password Changed Successfully";
                    return json_encode($response);
                } else {
                    $response["result"] = "failure";
                    $response["message"] = 'Error Updating Password';
                    return json_encode($response);
                }
            }
        } else {
            return $this -> getMsgParamNotEmpty();
        }
    }

    public function newinfo($email, $old_password , $head , $type ,$text , $unique_id , $longitude , $latitude, $token) {
        $db = $this -> db;

        if (!empty($email) && !empty($old_password) && !empty($head)) {
            if(!$db -> checkLogin($email, $old_password)){
                $response["result"] = "failure";
                $response["message"] = 'Password Error';
                return json_encode($response);
            } else {

                try{
                    JWT::$leeway = 30;
                    $decoded = JWT::decode($token, new Key(static::$key, 'HS256'));

                    $result = $db -> newinfo($head, $type , $text , $unique_id , $longitude , $latitude);
                    if($result) {
                        $response["result"] = "success";
                        $response["message"] = "Done";
                        return json_encode($response);
                    } else {
                        $response["result"] = "failure";
                        $response["message"] = "Error";
                        return json_encode($response);
                    }
                  
                  } catch( Exception $e ){
                    $response["result"] = "failure";
                    $response["message"] = "Authentication failed";
                    return json_encode($response);
                  }
               
            }
        } else {
            return $this -> getMsgParamNotEmpty();
        }
    }

    public function InfoRemove( $head , $sno  , $unique_id) {
        $db = $this -> db;
        $result = $db -> InfoRemove($head , $sno  , $unique_id);
        if($result) {
            $response["result"] = "success";
            $response["message"] = "Done";
            return json_encode($response);
        } else {
            $response["result"] = "failure";
            $response["message"] = 'Error';
            return json_encode($response);
        }
    }

    public function isEmailValid($email){
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public function getMsgParamNotEmpty(){
        $response["result"] = "failure";
        $response["message"] = "Parameters should not be empty !";
        return json_encode($response);
    }

    public function getMsgInvalidParam(){
        $response["result"] = "failure";
        $response["message"] = "Invalid Parameters";
        return json_encode($response);
    }

    public function getMsgInvalidEmail(){
        $response["result"] = "failure";
        $response["message"] = "Invalid Email";
        return json_encode($response);
    }
}
?>