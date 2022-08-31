<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class connection
{
    public static function connect(){
        try {
            $conn = new mysqli(host, userName, password, dbname);
            $conn->set_charset("utf8");
            return $conn;
        }
        catch (Exception $e){
            die($e);
        }
    }
    public static function disconnect($conn){
        unset($conn);
    }
    public static function hashPassword($password,$type="sha1"){
        switch ($type){
            case "sha1":
                return sha1($password);
                break;
            case "md5":
                return md5($password);
                break;
            case "crc32":
                return crc32($password);
                break;
            default:
                return sha1($password);
        }
    }
    public static function sanitize($field){
        $level1=trim($field);
        $level2=strip_tags($level1);
        return $level2;
    }
    public static function checkEmail($email){
        $email=self::sanitize($email);
        $query="SELECT * FROM `users` WHERE `email`='$email'";
        $conn=self::connect();
        $result=$conn->query($query);
        if ($result->num_rows){
            $res= false;
        }
        else
            $res=true;
        self::disconnect($conn);
        return $res;
    }
    public static function checkLogin($email,$password){
        $email=self::sanitize($email);
        $password=self::sanitize($password);
        $conn=connection::connect();
        $sql="SELECT * FROM `users` WHERE `email`='$email' AND `password`='$password'";
        $result=$conn->query($sql);
        if ($result->num_rows){
            $ress=$result->fetch_assoc();
            $infoArray=array(
                "id"=>$ress["id"],
                "fullName"=>$ress["firstName"]." ".$ress["lastName"],
                "userName"=>$ress["userName"],
                "phone"=>$ress["phone"],
                "password"=>$ress["password"],
                "email"=>$ress["email"],
                "time"=>time()+30000
            );
            $_SESSION["userInfo"]=$infoArray;
            $ret= true;
        }
        else
            $ret=false;
        connection::disconnect($conn);
        return $ret;
    }
    public static function resetEmail($subject,$Body,$SMTPAddress){
        $mail = new PHPMailer(true);
        try{
            $mail->SMTPDebug=2;
            $mail->IsSMTP();
            $mail->Host ="smtp.gmail.com";
            $mail->SMTPAuth=true;
            $mail->Username="tahajob1382@gmail.com";
            $mail->Password="NeverGiveUp";
            $mail->SMTPSecure = "ssl";
            $mail->Port=465;
            $mail->IsHTML(true);
            $mail->Subject=$subject;
            $mail->Body=$Body ;
            $mail->CharSet="utf-8";
            $mail->ContentType="text/html;charset=utf8";
            $mail->AddAddress("tahajob1382@gmail.com","CUE");

            $mail->Send();
            echo "<div class='col-4 mx-auto'><div class='alert alert-info'>ایمیل ارسال شد</div></div>";

        }
        catch (Exception $e){

            echo "ایمیل ارسال نشد" . $mail->ErrorInfo;
        }

        $mail->SmtpClose();
        return $mail ;
    }
    public static function sendEmail($subject,$Body,$SMTPAddress){
        $mail = new PHPMailer(true);
        try{
            $mail->SMTPDebug = 2 ;
            $mail->IsSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true ;
            $mail->Username = "tahajob1382@gmail.com";
            $mail->Password="solxzworzrrinsjy";
            $mail->SMTPSecure = "ssl";
            $mail->Port = 465 ;

            $mail->IsHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $Body ;
            $mail->CharSet = "utf-8";
            $mail->ContentType = "text/html;charset=utf8";
            $mail->AddAddress($SMTPAddress,"CUE");

            $mail->Send();
            echo "<div class='col-4 mx-auto'><div class='alert alert-info'>ایمیل ارسال شد</div></div>";

        }
        catch (Exception $e){

            echo "ایمیل ارسال نشد" . $mail->ErrorInfo;
        }

        $mail->SmtpClose();
        return $mail ;
    }
    public static function error(){
        echo "<script>$(document).ready(function() {
          const Toast = Swal.mixin({
  toast: true,
  position: 'top-start',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})

Toast.fire({
  icon: 'error',
  title: 'فیلد های خالی را پرکنید'
})
        })</script>";
    } 
}