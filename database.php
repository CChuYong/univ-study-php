<?php
    $del_article_query="DELETE FROM xboard WHERE `articleid`=?";
    function get_connection(){
        return mysqli_connect("localhost", "root", "thddudals7565#", "aegis");
    }
    function get_del_article_query(){
        global $del_article_query;
        return $del_article_query;
    }
    function init_table(){
        $con = get_connection();
        mysqli_query($con, "CREATE TABLE IF NOT EXISTS xmember(username VARCHAR(36) PRIMARY KEY, password VARCHAR(36), nickname VARCHAR(36))");
        mysqli_query($con, "CREATE TABLE IF NOT EXISTS xnote(user_from VARCHAR(36) NOT NULL, user_to VARCHAR(36) NOT NULL, content TEXT NOT NULL, sentdate DATETIME NOT NULL)");
        mysqli_query($con, "CREATE TABLE IF NOT EXISTS xboard(`articleid` INT PRIMARY KEY AUTO_INCREMENT, `name` VARCHAR(128) NOT NULL, `content` TEXT NOT NULL, `author` VARCHAR(36) NOT NULL, `regdate` DATETIME NOT NULL, `private` BOOLEAN DEFAULT FALSE NOT NULL)");
        $con->close();
    }
?>
