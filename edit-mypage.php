<?php
    session_start();
    include('./dbconn.php');
    
    $dbconn = dbconn();

    $id = mysqli_real_escape_string($dbconn,$_SESSION['id']);
    $password = mysqli_real_escape_string($dbconn, $_POST['password']);
    $Newpassword = mysqli_real_escape_string($dbconn, $_POST['Newpassword']);
    $Newpassword_check = mysqli_real_escape_string($dbconn, $_POST['Newpassword_check']);
    $email = mysqli_real_escape_string($dbconn, $_POST['email']);
    
    // 현재비밀번호 일치한지 확인
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
            
            
            if(empty($email))
            {
                echo "<script>alert('이메일이 공백입니다.'); history.back();</script>";     
                exit;
            }
            
            if($Newpassword!=$Newpassword_check)
            {
                echo "<script>alert('새로운 비밀번호가 일치하지 않습니다.');history.back();</script>";
                exit;
            }
            
            if(empty($Newpassword))
            {
                $updateSql="UPDATE userTbl SET email='$email' where id='$id'";
                $updateSql_result=mysqli_query($dbconn,$updateSql);
                if($updateSql_result)
                {
                    echo "<script>alert('정상적으로 변경되었습니다. 다시 로그인을 해주시기 바랍니다.');location.href='/';</script>";  
                                
                }
            }
            else
            {
                
                $updateSql="UPDATE userTbl SET email='$email', passwd='$Newpassword' where id='$id'";
                $updateSql_result=mysqli_query($dbconn,$updateSql);
                if($updateSql_result)
                {
                    echo "<script>alert('정상적으로 변경되었습니다. 다시 로그인을 해주시기 바랍니다.');location.href='/';</script>";
                }
            }
            
            session_destroy();
           
        }
        else
        {      
            echo "<script>alert('현재 비밀번호가 올바르지 않습니다.');  history.back();</script>";
        }
    }
?>