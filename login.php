<?php
include_once "./database.php";
    $con = get_connection();
    $userid = $_POST['id'];
    $userpw = $_POST['pw'];
    $stmt = $con->prepare("SELECT * FROM xmember WHERE username=? AND password=?");
    $stmt->bind_param("ss", $userid, $userpw);
    $stmt->execute();
    $arr = mysqli_fetch_array($stmt->get_result());
    if($arr['username'] == $userid){
        session_start();
        $_SESSION['username'] = $arr['username'];
        $_SESSION['password'] = $arr['password'];
        $_SESSION['nickname'] = $arr['nickname'];
        echo "success";
    }else{
        echo "fail";
    }
?>
