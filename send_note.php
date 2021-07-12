<?php
    include_once "./user.php";
    include_once "./database.php";
    session_start();
    $target = htmlspecialchars($_POST['target']);
    $target = str_replace(' ', '', $target);
    $splitted = explode(',', $target);
    $content = htmlspecialchars($_POST['content']);
    if(!isset($_SESSION['nickname'])){
        echo '세션이 유효하지 않습니다';
        return;
    }
    $i = 0;
    $date = date('Y-m-d h:i:s');
    $con = get_connection();
    $stmt = $con->prepare("INSERT INTO xnote (`user_from`, `user_to`, `content`, `sentdate`) VALUES (?, ?, ?, ?)");
    foreach($splitted as $targetname){
        if(!is_nickname_exists($targetname) || $targetname == $_SESSION['nickname']){
            continue;
        }
        $stmt->bind_param("ssss", $_SESSION['nickname'], $targetname, $content, $date);
        $stmt->execute();
        $i++;
    }
    $stmt->close();
    mysqli_close($con);
    if($i == count($splitted)){
        echo 'success';
    }else{
        echo '총 '.count($splitted).'명중 '.$i.'명에게 보냈습니다';
    }
?>