<?php
    session_start();
    include('./dbconn.php');
    
    $dbconn = dbconn();
    $userId = mysqli_real_escape_string($dbconn,$_POST['userId']);
    $page=$_SESSION['admin'];
    
    $Sql ="SELECT idx from userTbl where id = ? "; //Prepared Statement 위조된 injection 차단
    $stmt = mysqli_prepare($dbconn, $Sql);
    mysqli_stmt_bind_param($stmt, "s", $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $search_row=mysqli_fetch_assoc($result);
    if($search_row!=null)
    {
        $user_idx=$search_row['idx'];    
    }

    if ($user_idx) {
        //검색을 성공한 경우
        $delete_userSql="DELETE FROM userTbl where idx= $user_idx";
        $delete_userSql_result=mysqli_query($dbconn,$delete_userSql);
        if($delete_userSql_result)
        {
            echo "<script>alert('사용자 계정을 삭제하였습니다.');location.href='/$page.php';</script>";
        }else {
            echo "<script>alert('실패했어요');</script>";
        }
        // 필요한 추가 작업 수행
        // 예: 다시 사용자 목록을 출력하는 등의 작업
    } else {
        // 삭제 실패한 경우
        echo "<script>alert('사용자 계정 삭제에 실패하였습니다.'); location.href='/$page.php';</script>";
        // 실패 시 처리할 내용 작성
    }
    // 이어질 코드 작성
?>
