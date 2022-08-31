<?php

class adminClasses extends data
{
    public $data=array(
        'id'=>0,
        'firstName'=>'',
        'lastName'=>'',
        'phone'=>'',
        'email'=>'',
        'userName'=>'',
        'password'=>'',
        'created_at'=>'',
        'updated_at'=>''
    );
    public static $btnColor=["primary","danger","success","secondary"];
    public static function selectSpecialTable($tableName,$status=false){
        $conn=connection::connect();
        $sql="SELECT * FROM `$tableName`";
        if ($status){
            $sql="SELECT * FROM `$tableName` WHERE `status`='$status'";
        }
        $result=$conn->query($sql);
        if ($result->num_rows){
            $res=$result->fetch_all(MYSQLI_ASSOC);

        }
        else{
            $res=false;
        }

        connection::disconnect($conn);
        return $res;
    }
    public static function deleteRow($tableName,$idTable){
        $conn=connection::connect();
        $sql="DELETE FROM `$tableName` WHERE `id`='$idTable'";
        $result=$conn->query($sql);
        if ($result){
            $res=true;
        }
        else
            $res=false;
        connection::disconnect($conn);
        return $res;
    }
    public static function categoryId($id,$idNo){
        $conn=connection::connect();
        $ide=$id+$idNo;

        $sql="SELECT * FROM `products` WHERE `id_company`=$ide";
        $result=$conn->query($sql);
        if ($result->num_rows){
            $res=$result->fetch_all(MYSQLI_ASSOC);
        }
        else
            $res=false;
        connection::disconnect($conn);
        return $res;
    }
    public static function selectMessageUsers($status=false){
        $con=connection::connect();
        $sql="SELECT messagesuser.*,users.firstName,users.lastName FROM  messagesuser,users WHERE messagesuser.user_id=users.id";
        if ($status){
            $sql="SELECT messagesuser.*,users.firstName,users.lastName FROM  messagesuser,users WHERE messagesuser.user_id=users.id AND `status`='$status'";
        }
        $result=$con->query($sql);
        if ($result->num_rows){
            $res=$result->fetch_all(MYSQLI_ASSOC);
        }
        else
            $res=false;
        connection::disconnect($con);
        return $res;
    }
}