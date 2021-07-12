<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>게시물 읽기 - 에브리타임</title>
    <link rel="stylesheet" href="/table.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
</head>
<style>
    #log-button button{
        display: block;
        margin: 0px auto;
    }
    .centerize{
        width: 60%;
        margin-left: 20%;
        padding-top: 10px;
    }
</style>
<body>
<div style="padding-top: 10px;">
    <?php
    include_once "./user.php";
    session_validate();
    ?>
    <button type="button" class="btn btn-primary" id="lgn-btn" style="padding-left: 10px;" onclick="location.href='/logout.php'">로그아웃</button>
</div>
<div class="centerize">
    <?php
    include_once "./database.php";
    session_start();
    $con = get_connection();
    $stmt = $con->prepare("SELECT * FROM xboard WHERE `articleid`=?");
    $stmt->bind_param("i", $_GET['articleId']);
    $stmt->execute();
    $res = $stmt->get_result();
    $art = mysqli_fetch_array($res);
    if($art['private'] != 0 && $_SESSION['username'] != $art['author']){
        echo "<script>alert('게시물을 열람할 권한이 없습니다.'); location.href = '/'</script>";
        $stmt->close();
        $con->close();
        return;
    }
    echo '    
    <section class="article-content" style="width: 100%">
        <div class="article-header" style="background-color: #F1EFEC; border: 1px #DDDDDD solid; border-top-left-radius: 1em; border-top-right-radius: 1em">
            <td><h2 style="padding-top: 5px; padding-left: 5px;">'.$art['name'].'</h2></td>
            <div style="padding-left: 5px;">
                <td><span>작성자:'.$art['author'].'</span></td>
                <td><span>작성일:'.$art['regdate'].'</span></td>
            </div>
        </div>
            <div class="article-maincontent" style="border: 1px #DDDDDD solid; padding-inline-start: 10px">
                <td><h5 style="padding-top: 10px; padding-bottom: 10px">'.$art['content'].'</h5></td>
            </div>

        </tr>
    </section>
    <div class="btn-group">
        <button type="button" class="btn btn-light" onclick="location.href=\'/\'">목록</button>
        <button type="button" class="btn btn-danger" onclick="location.href=\'/del_article.php?articleId='.$art['articleid'].'\'">삭제</button>
    </div>';
    $stmt->close();
    $con->close();
    ?>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $('#brd-write').click(function(){
        var name = $('#brd-name').val();
        var content = $('#brd-content').val();
        var isCheck = $('#priv').prop("checked");
        if(name == ''){
            alert("제목은 공백일 수 없습니다");
            return;
        }
        if(content == ''){
            alert("내용은 공백일 수 없습니다");
            return;
        }
        $.ajax({
            type: "POST",
            url: "/post_article.php",
            dataType: "text",
            data:{
                content: content,
                name: name,
                private: isCheck
            },
            success: function(r){
                if(r == 'success'){
                    alert('게시물을 성공적으로 업로드했습니다!');
                    location.href = '/';
                }else{
                    alert('업로드에 실패했습니다. ' + r);
                }
            },error: function(req,st,err){
                alert(err);
            }
        }) ;
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</body>
</html>