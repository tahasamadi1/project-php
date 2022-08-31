<?php

class userDashboard extends data
{
        public static $subjectMessage=array(
            1=>'محصولی که به دستم رسیده' ,
            2=>'درباره شرکت' ,
            3=>'نظارت و انتقادات' ,
        );
    public static function selectMessages(){
        $conn=connection::connect();
        $user_id=$_SESSION["userInfo"]["id"];
        $sql="SELECT `status`,`message`,`category_message`,`time` FROM `messagesuser` WHERE `user_id`='$user_id' ";
        $result=$conn->query($sql);
        if ($result->num_rows){
            $res=$result->fetch_all(MYSQLI_ASSOC);
        }
        else
            $res=false;
        connection::disconnect($conn);
        return $res;
    }
    public static function productButId($id){
        $conn=connection::connect();
        $sql="SELECT * FROM `buyproduct` WHERE `user_id`='$id'";
        $result=$conn->query($sql);
        if ($result->num_rows){
            $res=$result->fetch_all(MYSQLI_ASSOC);
        }
        else
            $res=false;
        connection::disconnect($conn);
        return $res;
    }
    public static function productByIds($id){
        $con=connection::connect();
        $sql="SELECT * FROM `products` WHERE `id`=$id";
        $result=$con->query($sql);
        if ($result->num_rows){
            $res=$result->fetch_assoc();
        }
        else
            $res=false;
        return $res;
    }
}