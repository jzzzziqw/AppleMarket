<?php
include('./top.php');
session_start();
$id = $_SESSION['id'];

if (isset($id)) {

} else {
    echo "<script>alert('올바르지 않은 접근입니다.');  history.back();</script>";

}

$length = mb_strlen($id, 'utf-8');

if (strncmp($id, 'admin', $length) === 0) {
    //관리 페이지 인증 확인
    include('./dbconn.php');

    $dbconn = dbconn();
    $password = mysqli_real_escape_string($dbconn, $_POST['password']);

    $searchSql = "SELECT * FROM userTbl WHERE id=? AND passwd=?";
    $stmt = mysqli_prepare($dbconn, $searchSql);
    mysqli_stmt_bind_param($stmt, "ss", $id, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result|| isset($_SESSION['admin'])) {
        $row = mysqli_fetch_assoc($result);
        if ($row === null && !isset($_SESSION['admin'])) {
            echo "<script>alert('올바르지 않은 접근입니다.');  history.back();</script>";
        } else { 
            $_SESSION['admin'] = $id;
            //비밀번호 인증 완료시
?>
            <div class="container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>이름</th>
                            <th>이메일</th>
                            <th>관리</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // 사용자 정보를 가져오는 로직을 구현해야 함
                        $userSql = "SELECT id, name, email FROM userTbl";
                        $userSql_result = mysqli_query($dbconn, $userSql);


                        while ($user = mysqli_fetch_assoc($userSql_result)) {
                            $userId = $user['id'];
                            $userName = $user['name'];
                            $userEmail = $user['email'];
                        ?>
                            <tr>
                                <td class="pl-4 pr-4"><?php echo $userId; ?></td>
                                <td class="pl-4 pr-4"><?php echo $userName; ?></td>
                                <td class="pl-4 pr-4"><?php echo $userEmail; ?></td>
                                <td>
                                    <form action="delete_user.php" method="post">
                                        <!-- 삭제할 사용자 계정의 ID나 식별자를 hidden input으로 전달 -->
                                        <input type="hidden" name="userId" value="<?php echo $userId; ?>">
                                        <button type="submit" class="btn btn-danger">삭제</button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

<?php
        }
    }
} else {
    echo "<script>alert('올바르지 않은 접근입니다.');  history.back();</script>";
}

include('./btm.php');
?>

</body>
</html>
