<?php
if (!isset($_SESSION)){
    session_start();
}
if(isset($_SESSION["userInfo"])){
    if(time() - $_SESSION["userInfo"]["time"] > 1){
        session_unset();
        session_destroy();
        //header("location:admin_ui.php");
    }
}