<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>쪽지 쓰기 - 에브리타임</title>
    <link rel="stylesheet" href="/table.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
</head>
<style>
    #log-button button{
        display: block;
        margin: 0px auto;
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
<div style="width: 60%; margin-left: 20%; padding-top: 10px;">
    <div class="mb-3">
        <label for="titlebox" class="form-label">대상</label>
        <input type="text" class="form-control" name="title" id="brd-name" placeholder="대상 닉네임을 입력하세요. (,를 사용하여 여러명에게 보냄)">
    </div>
    <div class="mb-3">
        <label for="titlebox" class="form-label">내용</label>
        <textarea class="form-control" id="brd-content" name="content" rows="8"></textarea>
    </div>
    <button type="button" class="btn btn-primary" id="brd-write">쪽지 보내기</button>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $('#brd-write').click(function(){
        var name = $('#brd-name').val();
        var content = $('#brd-content').val();
        if(name == ''){
            alert("대상은 공백일 수 없습니다");
            return;
        }
        if(content == ''){
            alert("내용은 공백일 수 없습니다");
            return;
        }
        $.ajax({
            type: "POST",
            url: "/send_note.php",
            dataType: "text",
            data:{
                content: content,
                target: name
            },
            success: function(r){
                if(r == 'success'){
                    alert('쪽지를 성공적으로 보냈습니다!');
                    location.href = '/';
                }else{
                    alert('쪽지 전송에 실패했습니다. ' + r);
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