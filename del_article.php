<?php
    include_once "./database.php";
    session_start();
    $con = get_connection();
    $stmt = $con->prepare("SELECT `private`, `author` FROM xboard WHERE `articleid`=?");
    $stmt->bind_param("i", $_GET['articleId']);
    $stmt->execute();
    $res = $stmt->get_result();
    $art = mysqli_fetch_array($res);
    if($_SESSION['username'] != $art['author']){
        echo "<script>alert('게시물을 삭제할 권한이 없습니다.'); history.back()</script>";
        $stmt->close();
        $con->close();
        return;
    }
    $stmt->close();
    $stmt = $con->prepare(get_del_article_query());
    $stmt->bind_param("i", $_GET['articleId']);
    $re = $stmt->execute();
    if($re){
        echo "<script>alert('게시물을 성공적으로 삭제했습니다!.'); location.href='/'</script>";
    }else{
        echo "<script>alert('알 수 없는 오류가 발생했습니다.'); history.back()</script>";
    }
    $stmt->close();
    $con->close();
?>
