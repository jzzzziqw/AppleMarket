<?php
include('./dbconn.php');
$dbconn = dbconn();

if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['address']) && isset($_POST['address2']) && isset($_POST['password']) && isset($_POST['password_check']) && isset($_POST['sex']) && isset($_POST['birthdate'])) {
    // Secure coding
    $id = mysqli_real_escape_string($dbconn, $_POST['id']);
    $name = mysqli_real_escape_string($dbconn, $_POST['name']);
    $email = mysqli_real_escape_string($dbconn, $_POST['email']);
    $address = mysqli_real_escape_string($dbconn, $_POST['address']);
    $address2 = mysqli_real_escape_string($dbconn, $_POST['address2']);
    $sex = mysqli_real_escape_string($dbconn, $_POST['sex']);
    $password = mysqli_real_escape_string($dbconn, $_POST['password']);
    $password_check = mysqli_real_escape_string($dbconn, $_POST['password_check']);
    $birthdate = mysqli_real_escape_string($dbconn, $_POST['birthdate']);

    if (empty($id) || empty($address2) || empty($password) || empty($password_check) || empty($address) || empty($sex) || empty($name) || empty($email) || empty($birthdate)) {
        echo "<script>alert('빈칸이 있습니다.'); history.back();</script>";
    } else if ($password != $password_check) {
        echo "<script>alert('비밀번호가 일치하지 않습니다.'); history.back();</script>";
    } else if(mb_strlen($password,'utf-8') <8 || mb_strlen($id,'utf-8')<8) {
        echo "<script>alert('아이디 혹은 비밀번호가 8자리 이상이여야 합니다.'); history.back();</script>";
    } else {
        $sql = "SELECT * FROM userTbl WHERE id=?";
        $stmt = mysqli_prepare($dbconn, $sql); // prepared statement (웹 해킹 취약점 진단 가이드 sql injection 보안정책)
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($result) == 1) {
            echo "<script>alert('이미 같은 아이디를 가진 사용자가 있습니다.'); history.back();</script>";
        } else {
            mysqli_autocommit($dbconn, false);

            $updateUserTblSql = "INSERT INTO userTbl (id, passwd, email, name, sex, birth) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt_updateUserTbl = mysqli_prepare($dbconn, $updateUserTblSql);
            mysqli_stmt_bind_param($stmt_updateUserTbl, "ssssis", $id, $password, $email, $name, $sex, $birthdate);
            $result_updateUserTbl = mysqli_stmt_execute($stmt_updateUserTbl);

            if ($result_updateUserTbl) {
                $idx = mysqli_insert_id($dbconn);
                if ($idx) {
                    $updateAddrSql = "INSERT INTO AddrTbl (Addr, detail, userTbl_idx) VALUES (?, ?, ?)";
                    $stmt_updateAddr = mysqli_prepare($dbconn, $updateAddrSql);
                    mysqli_stmt_bind_param($stmt_updateAddr, "ssi", $address, $address2, $idx);
                    $result_updateAddr = mysqli_stmt_execute($stmt_updateAddr);

                    if ($result_updateAddr) {
                        mysqli_commit($dbconn);
                        echo "<script>alert('회원가입이 완료되었습니다.'); location.href='/';</script>";
                    } else {
                        mysqli_rollback($dbconn);
                        echo "에러: 주소 추가에 실패했습니다.";

                        mysqli_query($dbconn, "ROLLBACK");
                    }
                } else {
                    mysqli_rollback($dbconn);
                    echo "에러: 새로운 사용자 ID를 가져오는 데 실패했습니다.";

                    mysqli_query($dbconn, "ROLLBACK");
                }
            } else {
                mysqli_rollback($dbconn);
                echo "에러: 사용자 추가에 실패했습니다.";
                echo mysqli_error($dbconn);

                mysqli_query($dbconn, "ROLLBACK");
            }

            mysqli_autocommit($dbconn, true);
        }
    }
} else {
    echo "요청이 올바르지 않습니다!";
}
?>
