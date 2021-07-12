<!DOCTYPE html>
<html lang="en">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:th="http://www.thymeleaf.org">
<head>
    <meta charset="UTF-8">
    <title>게시물 목록 - 에브리타임</title>
    <link rel="stylesheet" href="/table.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    </head>
<style>
    .centerize{
        width: 60%;
        display: -webkit-box;
        display: -moz-box;
        display: -ms-flexbox;
        display: flex;

        -webkit-box-align: center;
        -moz-box-align: center;
        -ms-flex-align: center;
        align-items: center;

        -webkit-box-pack: center;
        -moz-box-pack: center;
        -ms-flex-pack: center;

        margin-left: 20%;
        padding-top: 10px;
    }
    #log-button button{
        display: block;
        margin: 0px auto;
    }
    .board-main{
        width: 50%;
        height: 80%;
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
    <div>
        <div class="centerize">
            <table class="table" border="5px">
                <thead class="thead-light">
                <tr>
                    <th style="width: 5%"> <label class="customcheckbox m-b-20"> <input type="checkbox" id="mainCheckbox"> <span class="checkmark"></span> </label> </th>
                    <th scope="col" style="width: 5%">No</th>
                    <th scope="col" style="width: 60%">제목</th>
                    <th scope="col" style="width: 12%">작성자</th>
                    <th scope="col" style="width: 18%">날짜</th>
                </tr>
                </thead>
                <tbody class="sttable">
                <?php
                include_once "./database.php";
                    session_start();
                    $con = get_connection();
                    $stmt = $con->prepare("SELECT `articleid`, `name`, `author`, `regdate`, `private` FROM xboard ORDER BY `articleid` DESC");
                    $stmt->execute();
                    $res = $stmt->get_result();
                    while($art = mysqli_fetch_array($res)){
                        if($art['private'] != 0 && $_SESSION['username'] != $art['author']){
                            continue;
                        }
                        echo '<tr>
                        <th> <label class="customcheckbox"> <input type="checkbox" class="listCheckbox"> <span class="checkmark"></span> </label> </th>
                        <td>'.$art['articleid'].'</td>
                        <td><a href="board_read.php?articleId='.$art['articleid'].'">'.$art['name'].'</a></td>
                        <td>'.$art['author'].'</td>
                        <td>'.$art['regdate'].'</td>
                        </tr>';
                    }
                    $stmt->close();
                    $con->close();
                ?>
                </tbody>

            </table>
        </div>
        <div style="padding-left: 20%;">
            <button type="button" class="btn btn-primary" id="lgn-btn" onclick="location.href='/board_write.php'">글쓰기</button>
        </div>

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</body>
</html>