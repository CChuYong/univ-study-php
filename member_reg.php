<?php
include_once "./database.php";
    init_table();
    $userid = htmlspecialchars($_POST['username']);
    $userpw = htmlspecialchars($_POST['password']);
    $usernn = htmlspecialchars($_POST['nickname']);

    if(strlen($userid) >= 36 || strlen($userpw) >= 36 || strlen($usernn) >= 36) {
        echo "닉네임, 비밀번호, 닉네임은 각각 36자를 초과할 수 없습니다.";
        return;
    }
    $con = get_connection();



    $psmt = $con->prepare('INSERT INTO xmember (username, password, nickname) VALUES (?, ?, ?)');
    $psmt->bind_param("sss", $userid, $userpw, $usernn);
    $res = $psmt->execute();
    $psmt->close();
    mysqli_close($con);

    if($res == 1){
        echo('success');
    }else{
        echo('이미 존재하는 아이디입니다.');
    }
?>
