<?php
include_once "./database.php";
    session_start();
    $name = htmlspecialchars($_POST['name']);
    $content = htmlspecialchars($_POST['content']);
    if(!isset($_SESSION['nickname']) || !isset($name) || !isset($content)){
        echo '세션이 유효하지 않습니다';
        return;
    }
    $date = date('Y-m-d h:i:s');
    if(isset($_SESSION['lastUpload'])){
        try{
            $se = (new DateTime($_SESSION['lastUpload']))->add(new DateInterval('PT' . 10 . 'S'));
            if($se > new DateTime($date)){
                echo '연속으로 업로드할 수 없습니다. 잠시 후 이용해주세요.';
                return;
            }
        }catch(Exception $ex){

        }
    }
    $con = get_connection();
    $stmt = $con->prepare("INSERT INTO xboard (`name`, `content`, `author`, `regdate`, `private`) VALUES (?, ?, ?, ?, ?)");

    $i = $_POST['private']=='true'?1:0;
    $stmt->bind_param("ssssi", $name, $content, $_SESSION['nickname'], $date, $i);
    $res = $stmt->execute();
    $stmt->close();
    mysqli_close($con);
    if($res){
        $_SESSION['lastUpload'] = $date;
        echo 'success';
    }else{
        echo 'SQL 연결이 유효하지 않습니다.';
    }
?>
