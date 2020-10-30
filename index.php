<?php
require_once 'Functions.php';
$fun = new Functions();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"));

    if(isset($data -> operation)){
        $operation = $data -> operation;

        if(!empty($operation)){

            if($operation == 'register'){
                if(isset($data -> user )
                    && !empty($data -> user)
                    && isset($data -> user -> name)
                    && isset($data -> user -> email)
                    && isset($data -> user -> password)){

                    $user = $data -> user;
                    $name = $user -> name;
                    $email = $user -> email;
                    $password = $user -> password;
                    if ($fun -> isEmailValid($email)) {
                        echo $fun -> registerUser($name, $email, $password);
                    } else {
                        echo $fun -> getMsgInvalidEmail();
                    }
                } else {
                    echo $fun -> getMsgInvalidParam();
                }
            }

            else if ($operation == 'login') {
                if(isset($data -> user ) && !empty($data -> user) && isset($data -> user -> email) && isset($data -> user -> password)){
                    $user = $data -> user;
                    $email = $user -> email;
                    $password = $user -> password;

                    echo $fun -> loginUser($email, $password);
                } else {
                    echo $fun -> getMsgInvalidParam();
                }
            }

            else if ($operation == 'chgPass') {
                if(isset($data -> user ) && !empty($data -> user) && isset($data -> user -> email) && isset($data -> user -> old_password)
                    && isset($data -> user -> new_password)){
                    $user = $data -> user;
                    $email = $user -> email;
                    $old_password = $user -> old_password;
                    $new_password = $user -> new_password;

                    echo $fun -> changePassword($email, $old_password, $new_password);
                } else {
                    echo $fun -> getMsgInvalidParam();
                }
            }

            else if ($operation == 'newinfo') {
                if(isset($data -> user )
                    && !empty($data -> user)
                    && isset($data -> user -> email)
                    && isset($data -> user -> old_password)
                    && isset($data -> user -> head)
                    && isset($data -> user -> type)
                    && isset($data -> user -> text)
                    && isset($data -> user -> unique_id)
                    && isset($data -> user -> longitude)
                    && isset($data -> user -> latitude)
                ){
                    $user = $data -> user;
                    $email = $user -> email;
                    $old_password = $user -> old_password;
                    $head = $user -> head;
                    $type = $user ->  type;
                    $text = $user ->  text;
                    $unique_id = $user -> unique_id;
                    $longitude = $user ->  longitude;
                    $latitude = $user -> latitude;
                    //$new_info = $user -> new_info;

                    echo $fun ->changeInfo($email, $old_password, $head , $type ,$text  , $unique_id , $longitude , $latitude);
                } else {
                    echo $fun -> getMsgInvalidParam();
                }
            }

            else if ($operation == 'updateinfo') {
                if(isset($data -> user )
                    && !empty($data -> user)
                    && isset($data -> user -> email)
                    && isset($data -> user -> old_password)
                    && isset($data -> user -> head)
                    && isset($data -> user -> type)
                    && isset($data -> user -> text)
                    && isset($data -> user -> unique_id)
                ){
                    $user = $data -> user;
                    $email = $user -> email;
                    $old_password = $user -> old_password;
                    $head = $user -> head;
                    $type = $user ->  type;
                    $text = $user ->  text;
                    $unique_id = $user -> unique_id;

                    echo $fun ->changeInfo($email, $old_password, $head , $type ,$text  , $unique_id);
                } else {
                    echo $fun -> getMsgInvalidParam();
                }
            }

            else if ($operation == 'removeinfo') {
                if(isset($data -> user )
                    && !empty($data -> user)

                    && isset($data -> user -> sno)
                    && isset($data -> user -> head)
                    && isset($data -> user -> unique_id)
                ){
                    $user = $data -> user;
                    $sno = $user -> sno;
                    $head = $user -> head;
                    $unique_id = $user -> unique_id;

                    echo $fun ->InfoRemove( $head , $sno , $unique_id);
                } else {
                    echo $fun -> getMsgInvalidParam();
                }
            }

            else if ($operation == 'unijson') {

                if(isset($data -> user )
                    && !empty($data -> user)
                    && isset($data -> user -> email)
                    && isset($data -> user -> unique_id)
                ){
                    $user = $data -> user;
                    $email = $user -> email;
                    $unique_id = $user -> unique_id;

                    echo $fun ->unijson($email,$unique_id);
                } else {
                    echo $fun -> getMsgInvalidParam();
                }
            }

        }else{
            echo $fun -> getMsgParamNotEmpty();
        }

    } else {
        echo $fun -> getMsgInvalidParam();
    }
}
else if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    echo "Login API";
}
?>