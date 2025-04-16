<?php
if( isset($_GET["action"]) && !empty($_GET["action"]) ){
    $action = $_GET["action"];
    $data = (isset($_POST["data"]) && !empty($_POST["data"])) ? $_POST["data"] : array();
    if( $action == "register" ){
        if( !isset($data["name"]) || empty($data["name"]) ){
            $response = array("msg" => checkAPILanguege("Name is required.", "الاسم مطلوب."));
            echo outputData($response);die();
        }
        if( !isset($data["email"]) || empty($data["email"]) ){
            $response = array("msg" => checkAPILanguege("Email is required.", "البريد الالكتروني مطلوب."));
            echo outputData($response);die();
        }
        if( !isset($data["password"]) || empty($data["password"]) ){
            $response = array("msg" => checkAPILanguege("Password is required.", "كلمة المرور مطلوبة."));
            echo outputData($response);die();
        }
        if( !isset($data["mobile"]) || empty($data["mobile"]) ){
            $response = array("msg" => checkAPILanguege("Phone number is required.", "رقم الهاتف مطلوب."));
            echo outputData($response);die();
        }
        if( !isset($data["username"]) || empty($data["username"]) ){
            $response = array("msg" => checkAPILanguege("Username is required.", "اسم المستخدم مطلوب."));
            echo outputData($response);die();
        }
        if( insertDB("users", $data) ){
            $response = array("msg" => checkAPILanguege("User registered successfully.", "تم تسجيل المستخدم بنجاح."));
            echo outputData($response);die();
        }else{
            $response = array("msg" => checkAPILanguege("User registration failed.", "فشل تسجيل المستخدم."));
            echo outputData($response);die();
        }
    }elseif( $action == "login" ){
        if( !isset($data["username"]) || empty($data["username"]) ){
            $response = array("msg" => checkAPILanguege("Username is required.", "اسم المستخدم مطلوب."));
            echo outputData($response);die();
        }
        if( !isset($data["password"]) || empty($data["password"]) ){
            $response = array("msg" => checkAPILanguege("Password is required.", "كلمة المرور مطلوبة."));
            echo outputData($response);die();
        }
        if( $user = selectDBNew("users",[$data["username"],$data["password"]],"`username` = ? AND `password` = ?","") ){
            if( $user[0]["status"] == 1 ){
                $response = array("msg" => checkAPILanguege("User is blocked.", "المستخدم محظور."));
                echo outputData($response);die();
            }
            if( $user[0]["status"] == 2 ){
                $response = array("msg" => checkAPILanguege("no user found.", "لم يتم العثور على مستخدم."));
                echo outputData($response);die();
            }
            $response = array("msg" => checkAPILanguege("User logged in successfully.", "تم تسجيل الدخول بنجاح."));
            echo outputData($response);die();
        }else{
            $response = array("msg" => checkAPILanguege("Invalid username or password.", "اسم المستخدم أو كلمة المرور غير صحيحة."));
            echo outputData($response);die();
        }
    }
}
?>