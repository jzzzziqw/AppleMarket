<?php session_start(); ?>
<?php
    include('./dbconn.php');
    $dbconn = dbconn();

    // 사용자가 로그인했는지 확인합니다.
    if (!isset($_SESSION['id'])) {
        echo "<script>alert( '로그인되지 않았습니다.'); history.back();</script>";
        header("Location: login.html");
        exit;
    }

    // 로그인한 사용자의 ID를 가져옵니다.
    $user_id = $_SESSION['id'];
    $product_id = $_GET['product_id'];
    $rep_id= $_GET['rep_id'];

    // POST 요청에서 제품 데이터를 가져옵니다.
    $title = $_POST["title"]; //title
    $favorite = $_POST["favorite"]; //favoriteTbl_idx
    $comment = $_POST["comment"]; //commentTbl_idx

    if ($title === "" || $favorite === "" || $comment === "") {
        echo "<script>alert('빈칸이 있습니다.'); history.back();</script>";
    } else {
        mysqli_autocommit($dbconn, false);
    }

    $user_idx_query = "SELECT idx FROM userTbl WHERE id = ?";
    $stmt_user_idx = mysqli_prepare($dbconn, $user_idx_query);
    if ($stmt_user_idx === false) {
        echo "에러: 사용자 인덱스 쿼리 준비에 실패했습니다.";
        exit;
    }
    mysqli_stmt_bind_param($stmt_user_idx, "s", $user_id);
    $result_user_idx = mysqli_stmt_execute($stmt_user_idx);
    if ($result_user_idx === false) {
        echo "에러: 사용자 인덱스 쿼리 실행에 실패했습니다.";
        exit;
    }
    $user_idx_result = mysqli_stmt_get_result($stmt_user_idx);

    if ($user_idx_result) {
        $user_idx_row = mysqli_fetch_assoc($user_idx_result);
        $user_idx = $user_idx_row['idx'];

        $updateRegProductSql = "UPDATE RegProductTbl SET favorite = ? WHERE idx = $product_id";
        $stmt_updateRegProduct = mysqli_prepare($dbconn, $updateRegProductSql);
        if ($stmt_updateRegProduct === false) {
            echo "에러: 제품 업데이트 쿼리 준비에 실패했습니다.";
            exit;
        }
        mysqli_stmt_bind_param($stmt_updateRegProduct, "i", $favorite);
        $result_updateRegProduct = mysqli_stmt_execute($stmt_updateRegProduct);
        if ($result_updateRegProduct === false) {
            echo "에러: 제품 업데이트 쿼리 실행에 실패했습니다.";
            exit;
        }
        $updateCommentSql = "UPDATE comment SET title = ?, comment = ? WHERE idx = ?";
        $stmt_updateComment = mysqli_prepare($dbconn, $updateCommentSql);
        if ($stmt_updateComment === false) {
            echo "에러: 후기 업데이트 쿼리 준비에 실패했습니다.";
            exit;
        }
        mysqli_stmt_bind_param($stmt_updateComment, "ssi", $title, $comment, $rep_id);
        $result_updateComment = mysqli_stmt_execute($stmt_updateComment);
        if ($result_updateComment === false) {
            echo "에러: 후기 업데이트 쿼리 실행에 실패했습니다.";
            exit;
        }
        

        mysqli_commit($dbconn);
        echo "<script>alert('후기 등록이 완료되었습니다.'); history.back();</script>";
    } else {
        mysqli_rollback($dbconn);
        echo "에러: 후기 등록에 실패하였습니다.";
    }

    mysqli_autocommit($dbconn, true);
?>