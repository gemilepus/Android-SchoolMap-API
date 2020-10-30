<?php
require_once 'DBOperations.php';

class Functions{
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
                    $response["result"] = "success";
                    $response["message"] = "Login Successful";
                    $response["user"] = $result;
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
                $response["message"] = 'Invalid Old Password';
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

    public function changeInfo($email, $old_password , $head , $type ,$text , $unique_id , $longitude , $latitude) {
        $db = $this -> db;

        if (!empty($email) && !empty($old_password) && !empty($head)) {
            if(!$db -> checkLogin($email, $old_password)){   //  登入檢查
                $response["result"] = "failure";
                $response["message"] = 'Invalid Old Password';
                return json_encode($response);
            } else {
                $result = $db -> changeInfo($head, $type ,$text , $unique_id , $longitude , $latitude); //DBOperations.php
                if($result) {
                    $response["result"] = "success";
                    $response["message"] = "資料新增成功";
                    return json_encode($response);
                } else {
                    $response["result"] = "failure";
                    $response["message"] = 'Error';
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
            $response["message"] = "刪除成功";
            return json_encode($response);
        } else {
            $response["result"] = "failure";
            $response["message"] = 'Error';
            return json_encode($response);
        }
    }

    public function unijson($email,$unique_id) {
        $db = $this -> db;
        $response["result"] = "success";
        $response["message"] = "安安 JSON";

        include("connMysqlObj.php");
        $seldb = @mysqli_select_db($db_link, "login-register-system");
        if (!$seldb) die("資料庫選擇失敗！");

        $sql_query = "SELECT * FROM info";
        $result = mysqli_query($db_link, $sql_query);
        $code=array();
        while($row_result=mysqli_fetch_assoc($result)){
            $row_array['ver']=$row_result['head'];
            $row_array['name']= $row_result['type'];
            $row_array['api']= $row_result['text'];
            array_push($code,$row_array);
        }
        $response['android'] = $code;
        return json_encode($response);
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