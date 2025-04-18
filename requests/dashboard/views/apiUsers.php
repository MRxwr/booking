<?php
if( isset($_GET["action"]) && !empty($_GET["action"]) ){
    $action = $_GET["action"];
    $data = (isset($_POST) && !empty($_POST)) ? $_POST : array();
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
        //user selectDBNew to check the email exists or not
        if( $user = selectDBNew("employees",[$data["email"]],"`email` = ? AND `status` = 0 AND `hidden` = 0","") ){
            $response = array("msg" => checkAPILanguege("Email already exists.", "البريد الالكتروني موجود مسبقاً."));
            echo outputError($response);die();
        }
        $data["empType"] = 2;
        $data["password"] = sha1($data["password"]);
        if( insertDB("employees", $data) ){
            $response = array("msg" => checkAPILanguege("User registered successfully.", "تم تسجيل المستخدم بنجاح."));
            echo outputData($response);die();
        }else{
            $response = array("msg" => checkAPILanguege("User registration failed.", "فشل تسجيل المستخدم."));
            echo outputError($response);die();
        }
    }elseif( $action == "login" ){
        if( !isset($data["email"]) || empty($data["email"]) ){
            $response = array("msg" => checkAPILanguege("Email is required.", "اسم المستخدم مطلوب."));
            echo outputError($response);die();
        }
        if( !isset($data["password"]) || empty($data["password"]) ){
            $response = array("msg" => checkAPILanguege("Password is required.", "كلمة المرور مطلوبة."));
            echo outputError($response);die();
        }
        if( $user = selectDBNew("employees",[$data["email"],sha1($data["password"])],"`email` = ? AND `password` = ?","") ){
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
                $response = array("msg" => checkAPILanguege("User logged in successfully.", "تم تسجيل الدخول بنجاح."), "token" => $token);
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
        if( !$token ){
            $response = array("msg" => checkAPILanguege("Token is required.", "التوكن مطلوب."));
            echo outputError($response);die();
        }else{
            if ( $user = selectDBNew("employees",[$token],"`keepMeAlive` LIKE ?","") ){
                if( updateDB("employees", array("keepMeAlive" => ""), "`keepMeAlive` = '{$token}'") ){
                    $response = array("msg" => checkAPILanguege("User logged out successfully.", "تم تسجيل الخروج بنجاح."));
                    echo outputData($response);die();
                }else{
                    $response = array("msg" => checkAPILanguege("User logout failed.", "فشل تسجيل الخروج للمستخدم."));
                    echo outputError($response);die();
                }
            }else{
                $response = array("msg" => checkAPILanguege("Invalid token.", "التوكن غير صالح."));
                echo outputError($response);die();
            }
        }
    }elseif( $action == "update" ){
        if ( !$token ){
            $response = array("msg" => checkAPILanguege("Invalid token.", "التوكن غير صالح."));
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
        if( updateDB("employees", $data, "`keepMeAlive` LIKE '{$token}'") ){
            $response = array("msg" => checkAPILanguege("User updated successfully.", "تم تحديث المستخدم بنجاح."));
            echo outputData($response);die();
        }else{
            $response = array("msg" => checkAPILanguege("User update failed.", "فشل تحديث المستخدم."));
            echo outputError($response);die();
        }
    }elseif( $action == "delete" ){
        if ( !$token ){
            $response = array("msg" => checkAPILanguege("Invalid token.", "التوكن غير صالح."));
            echo outputError($response);die();
        }
        if( $user = selectDBNew("employees",[$token],"`keepMeAlive` LIKE ? AND `status` = 0","") ){
            if( updateDB("employees", array("status" => 2, "keepMeAlive" => ""), "`id` = '{$user[0]["id"]}'") ){
                $response = array("msg" => checkAPILanguege("User deleted successfully.", "تم حذف المستخدم بنجاح."));
                echo outputData($response);die();
            }else{
                $response = array("msg" => checkAPILanguege("User deletion failed.", "فشل حذف المستخدم."));
                echo outputError($response);die();
            }
        }else{
            $response = array("msg" => checkAPILanguege("Error deleting user.", "خطأ في حذف المستخدم."));
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
                forgetPassWhatsapp(array("password" => $newPassword, "name" => $user[0]["name"], "phone" => $user[0]["phone"]));
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