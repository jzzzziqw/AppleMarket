<?php
    session_start();
    include('./dbconn.php');
    
    $dbconn = dbconn();
    $id = mysqli_real_escape_string($dbconn,$_POST['id']);
    $password = mysqli_real_escape_string($dbconn,$_POST['password']);

    $searchSql = "SELECT * FROM userTbl WHERE id=? AND passwd=?";
    $stmt = mysqli_prepare($dbconn, $searchSql);
    mysqli_stmt_bind_param($stmt, "ss", $id, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if($result)
    {
        $row = mysqli_fetch_assoc($result);
        if($row != null)
        {
            $_SESSION['name'] = $row['name'];
            $_SESSION['id'] = $row['id'];
            
            echo "<script>location.href='/';</script>";
        }
        else
        {
            echo "<script>alert('유효하지 않은 아이디 혹은 비밀번호입니다.');  history.back();</script>";
        }
    }
?>