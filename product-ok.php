<?php
    include('./top.php');
    ?>
    </header>

<?php
// 사용자가 로그인했는지 확인합니다.
if (!isset($_SESSION['id'])) {
  echo "<script>alert('로그인되지 않았습니다.'); location.href='login.html';</script>";
  exit;
}

include('./dbconn.php');
$dbconn = dbconn();

// 판매글 등록이 성공했을 경우에만 접근 가능한 페이지입니다.
if (!isset($_SESSION['product_id'])) {
  echo "<script>alert('잘못된 접근입니다.'); location.href='index.html';</script>";
  exit;
}

// 등록된 판매글의 ID를 가져옵니다.
$product_id = $_SESSION['product_id'];

// 판매글 정보를 조회합니다.
$reg_product_query = "SELECT * FROM RegProductTbl WHERE idx = ?";
$stmt_reg_product = mysqli_prepare($dbconn, $reg_product_query);
mysqli_stmt_bind_param($stmt_reg_product, "i", $product_id);
mysqli_stmt_execute($stmt_reg_product);
$reg_product_result = mysqli_stmt_get_result($stmt_reg_product);

$query2 = "SELECT * FROM CategoryTbl WHERE RegProductTbl_idx1 = $product_id";
$result2 = $dbconn->query($query2) or die("query error => " . $dbconn->error);
$CT = $result2->fetch_object();



if ($reg_product_result) {
  $reg_product_row = mysqli_fetch_assoc($reg_product_result);
  // 여기에서 필요한 작업을 수행할 수 있습니다.
} else {
  echo "<script>alert('판매글 정보를 불러오는 중에 오류가 발생하였습니다.'); location.href='index.html';</script>";
  exit;
}
mysqli_stmt_close($stmt_reg_product);
?>

<div class="container">
    <div class="input-form-backgroud row">
        <div class="input-form col-md-9 mx-auto">
            <center>
                <h4 class="mb-3"><br><br>게시글 등록 완료</h4>
                <p>게시글 등록이 완료되었습니다. 아래의 버튼을 눌러 홈페이지 화면으로 돌아가거나 등록된 게시글을 확인해보세요.</p>
            </center>
            <br>
            <hr>
            <center>
                <br><br>
                <p>게시글 등록 정보</p>
                <div class="info-text">
                    <p>
                        제목: <?php echo $reg_product_row['title']; ?> <br>
                        태그: <?php echo $reg_product_row['tags']; ?> <br>
                        카테고리: <?php echo $CT->name; ?> <br>
                        작성일시: <?php echo $reg_product_row['regDate']; ?> <br>
                    </p>
                    <br><br><br>
                </div>
                <button class="btn btn-primary btn-block" type="button"><a href="index.php" style="color: white;">홈으로 돌아가기</a></button>&nbsp;&nbsp;
                <button class="btn btn-primary btn-block" type="button"><a href="/product-board.php?product_id=<?php echo $product_id; ?>" style="color: white;">본문 보기</a></button>
            </center>
            <br><br><br>
        </div>
    </div>
</div>


    <?php
    include('./btm.php');
    ?>
    
    </body>
</html>