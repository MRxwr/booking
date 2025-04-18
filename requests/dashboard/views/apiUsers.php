<?php
if( isset($_GET["action"]) && !empty($_GET["action"]) ){
    $action = $_GET["action"];
    $data = (isset($_POST["data"]) && !empty($_POST["data"])) ? $_POST["data"] : array();
    if( $action == "register" ){
        if( !isset($data["name"]) || empty($data["name"]) ){
            $response = array("msg" => checkAPILanguege("Name is required.", "الاسم مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["email"]) || empty($data["email"]) ){
            $response = array("msg" => checkAPILanguege("Email is required.", "البريد الالكتروني مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["password"]) || empty($data["password"]) ){
            $response = array("msg" => checkAPILanguege("Password is required.", "كلمة المرور مطلوبة."));
            echo outputError($response);die();
        }
        if( !isset($data["phone"]) || empty($data["phone"]) ){
            $response = array("msg" => checkAPILanguege("Phone number is required.", "رقم الهاتف مطلوب."));
            echo outputError($response);die();
        }
        if( insertDB("employees", $data) ){
            $response = array("msg" => checkAPILanguege("User registered successfully.", "تم تسجيل المستخدم بنجاح."));
            echo outputData($response);die();
        }else{
            $response = array("msg" => checkAPILanguege("User registration failed.", "فشل تسجيل المستخدم."));
            echo outputError($response);die();
        }
    }elseif( $action == "login" ){
        if( !isset($data["username"]) || empty($data["username"]) ){
            $response = array("msg" => checkAPILanguege("Username is required.", "اسم المستخدم مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["password"]) || empty($data["password"]) ){
            $response = array("msg" => checkAPILanguege("Password is required.", "كلمة المرور مطلوبة."));
            echo outputError($response);die();
        }
        if( $user = selectDBNew("employees",[$data["username"],$data["password"]],"`username` = ? AND `password` = ?","") ){
            if( $user[0]["status"] == 1 ){
                $response = array("msg" => checkAPILanguege("User is blocked.", "المستخدم محظور."));
                echo outputError($response);die();
            }
            if( $user[0]["status"] == 2 ){
                $response = array("msg" => checkAPILanguege("no user found.", "لم يتم العثور على مستخدم."));
                echo outputError($response);die();
            }
            $token = sha1(uniqid(rand(), true));
            if( updateDB("employees", array("keepMeAlive" => $token), "`id` = '{$user[0]["id"]}'") ){
                $response = array("msg" => checkAPILanguege("User logged in successfully.", "تم تسجيل الدخول بنجاح."), "token" => $user[0]["keepMeAlive"]);
                echo outputData($response);die();
            }else{
                $response = array("msg" => checkAPILanguege("User login failed.", "فشل تسجيل الدخول للمستخدم."));
                echo outputError($response);die();
            }
        }else{
            $response = array("msg" => checkAPILanguege("Invalid username or password.", "اسم المستخدم أو كلمة المرور غير صحيحة."));
            echo outputError($response);die();
        }
    }elseif( $action == "logout" ){
        if( !isset($data["token"]) || empty($data["token"]) ){
            $response = array("msg" => checkAPILanguege("Token is required.", "التوكن مطلوب."));
            echo outputError($response);die();
        }else{
            if( updateDB("employees", array("keepMeAlive" => ""), "`keepMeAlive` = '{$data["token"]}'") ){
                $response = array("msg" => checkAPILanguege("User logged out successfully.", "تم تسجيل الخروج بنجاح."));
                echo outputData($response);die();
            }else{
                $response = array("msg" => checkAPILanguege("User logout failed.", "فشل تسجيل الخروج للمستخدم."));
                echo outputError($response);die();
            }
        }
    }elseif( $action == "update" ){
        if ( $token ){
            if( !isset($data["email"]) || empty($data["email"]) ){
                $response = array("msg" => checkAPILanguege("Email is required.", "البريد الالكتروني مطلوب."));
                echo outputError($response);die();
            }
            if( !isset($data["phone"]) || empty($data["phone"]) ){
                $response = array("msg" => checkAPILanguege("Phone number is required.", "رقم الهاتف مطلوب."));
                echo outputError($response);die();
            }
            if( !isset($data["name"]) || empty($data["name"]) ){
                $response = array("msg" => checkAPILanguege("Name is required.", "الاسم مطلوب."));
                echo outputError($response);die();
            }
            if( updateDB("employees", $data, "`id` = '{$data["id"]}'") ){
                $response = array("msg" => checkAPILanguege("User updated successfully.", "تم تحديث المستخدم بنجاح."));
                echo outputData($response);die();
            }else{
                $response = array("msg" => checkAPILanguege("User update failed.", "فشل تحديث المستخدم."));
                echo outputError($response);die();
            }
        }else{
            $response = array("msg" => checkAPILanguege("Invalid token.", "التوكن غير صالح."));
            echo outputError($response);die();
        }
    }elseif( $action == "delete" ){
        if ( $token ){
            if( $user = selectDBNew("employees",[$token],"`keepMeAlive` LIKE ? AND `status` = 0","") ){
                if( updateDB("employees", array("status" => 2), "`id` = '{$user[0]["id"]}'") ){
                    $response = array("msg" => checkAPILanguege("User deleted successfully.", "تم حذف المستخدم بنجاح."));
                    echo outputData($response);die();
                }else{
                    $response = array("msg" => checkAPILanguege("User deletion failed.", "فشل حذف المستخدم."));
                    echo outputError($response);die();
                }
            }else{
                $response = array("msg" => checkAPILanguege("Invalid token.", "التوكن غير صالح."));
                echo outputError($response);die();
            }
        }else{
            $response = array("msg" => checkAPILanguege("Invalid token.", "التوكن غير صالح."));
            echo outputError($response);die();
        }
    }elseif( $action == "changePassword" ){
        if( !$token ){
            $response = array("msg" => checkAPILanguege("Token is required.", "التوكن مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["oldPassword"]) || empty($data["oldPassword"]) ){
            $response = array("msg" => checkAPILanguege("Old password is required.", "كلمة المرور القديمة مطلوبة."));
            echo outputError($response);die();
        }
        if( !isset($data["newPassword"]) || empty($data["newPassword"]) ){
            $response = array("msg" => checkAPILanguege("New password is required.", "كلمة المرور الجديدة مطلوبة."));
            echo outputError($response);die();
        }
        if( $user = selectDBNew("employees",[$token],"`keepMeAlive` LIKE ? AND `status` = 0","") ){
            if( sha1($data["oldPassword"]) == $user[0]["password"] ){
                if( updateDB("employees", array("password" => sha1($data["newPassword"])), "`id` = '{$user[0]["id"]}'") ){
                    $response = array("msg" => checkAPILanguege("Password changed successfully.", "تم تغيير كلمة المرور بنجاح."));
                    echo outputData($response);die();
                }else{
                    $response = array("msg" => checkAPILanguege("Password change failed.", "فشل تغيير كلمة المرور."));
                    echo outputError($response);die();
                }
            }else{
                $response = array("msg" => checkAPILanguege("Old password is incorrect.", "كلمة المرور القديمة غير صحيحة."));
                echo outputError($response);die();
            }
        }else{
            $response = array("msg" => checkAPILanguege("Invalid token.", "التوكن غير صالح."));
            echo outputError($response);die();
        }
    }elseif( $action == "forgetPassword" ){
        if( !isset($data["email"]) || empty($data["email"]) ){
            $response = array("msg" => checkAPILanguege("Email is required.", "البريد الالكتروني مطلوب."));
            echo outputError($response);die();
        }
        if( $user = selectDBNew("employees",[$data["email"]],"`email` = ? AND `status` = 0","") ){
            $newPassword = rand(00000000,99999999);
            if( updateDB("employees", array("password" => sha1($newPassword)), "`id` = '{$user[0]["id"]}'") ){
                // send email with new password
                forgetPass(array("email" => $user[0]["email"], "password" => $newPassword));
                $response = array("msg" => checkAPILanguege("New password sent to your email.", "تم ارسال كلمة المرور الجديدة الى بريدك الالكتروني."));
                echo outputData($response);die();
            }else{
                $response = array("msg" => checkAPILanguege("Password reset failed.", "فشل اعادة تعيين كلمة المرور."));
                echo outputError($response);die();
            }
        }else{
            $response = array("msg" => checkAPILanguege("Email not found.", "البريد الالكتروني غير موجود."));
            echo outputError($response);die();
        }
    }else{
        $response = array("msg" => checkAPILanguege("Invalid action.", "الاجراء غير صالح."));
        echo outputError($response);die();
    }
}
?>