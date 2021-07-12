<?php
include_once "./database.php";
    function is_username_exists($username){
        $con = get_connection();
        $stmt = $con->prepare("SELECT * FROM xmember WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $res = $stmt->get_result();
        $stmt->close();
        $con->close();
        return mysqli_num_rows($res) > 0;
    }
    function is_nickname_exists($username){
        $con = get_connection();
        $stmt = $con->prepare("SELECT * FROM xmember WHERE nickname=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $res = $stmt->get_result();
        $stmt->close();
        $con->close();
        return mysqli_num_rows($res) > 0;
    }
    function session_validate(){
        session_start();
        if(isset($_SESSION['nickname'])){
            echo "<span style='padding-left: 20%; padding-right: 20px;'>".$_SESSION['nickname'].'님 환영합니다!</span><span style="padding-right: 10px;"><button type="button" class="btn btn-success" id="lgn-btn" style="padding-left: 10px;" onclick="location.href=\'/\'">홈</button></span><button type="button" class="btn btn-info" id="lgn-btn" style="padding-left: 10px;" onclick="location.href=\'/note_write.php\'">쪽지 보내기</button><button type="button" class="btn btn-info" id="lgn-btn" style="padding-left: 10px;" onclick="location.href=\'/note_list.php\'">받은 쪽지함</button>';
        }else{
            echo "<script>location.href='/login.html'</script>";
        }
    }
?>
