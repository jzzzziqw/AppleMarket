
<?php
    include('./top.php');
    include('./dbconn.php');
    $dbconn = dbconn();
    
    $id=$_SESSION['id'];
    
    if(isset($id))
    {
       
    }else 
    {
        echo "<script>alert('올바르지 않은 접근입니다.');  history.back();</script>";
    }
 
  
    $Sql ="SELECT idx from userTbl where id = ? "; //Prepared Statement 위조된 injection 차단
    $stmt = mysqli_prepare($dbconn, $Sql);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if($result)
    {
        $row = mysqli_fetch_assoc($result);
        if($row!=null)
        {
            $idx=$row['idx'];
            
        }
    }
    
    // basketTbl 튜플 삭제
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $basket_idx = mysqli_real_escape_string($dbconn, $_POST['idx']);
        $delete_cartSql = "DELETE FROM basketTbl where idx = ? AND userTbl_idx = ?";
        $stmt_delete_cartSql = mysqli_prepare($dbconn, $delete_cartSql);
        mysqli_stmt_bind_param($stmt_delete_cartSql, "ii", $basket_idx,$idx);
        $result_delete_cartSql = mysqli_stmt_execute($stmt_delete_cartSql);
    }


    $basketSql="SELECT * , basketTbl.idx AS basket_idx FROM basketTbl JOIN RegProductTbl ON basketTbl.product_num = RegProductTbl.idx JOIN CategoryTbl ON CategoryTbl.RegProductTbl_idx1 = RegProductTbl.idx where basketTbl.userTbl_idx= $idx";
    $basket_result=mysqli_query($dbconn,$basketSql);
    


?>
   
    <!-- End Header Area -->

    
    <!-- Start Trending Product Area -->
 
    <div class="container">
    <div class="row">
        <div>
            <div style="text-align: left;">
                <br>
                <br>
                <h3>내 위시리스트</h3>
            </div>
        </div>
    </div>

    <div class="row">
        <?php while ($basket_row = mysqli_fetch_assoc($basket_result)) { 
            $idx = $basket_row['RegProductTbl_idx1'];
            ?>
        <div class="col-lg-3 col-md-6 col-12">
            <!-- Start Single Product -->
            <div class="single-product">
                <div class="product-image">
                    <?php 
                        $RegProductTbl_idx = $basket_row['RegProductTbl_idx1'];
                        $search_filepathSql = "SELECT path FROM filepathTbl WHERE RegProductTbl_idx = $RegProductTbl_idx";
                        $search_filepathSql_result = mysqli_query($dbconn, $search_filepathSql);
                        if ($search_filepathSql_result) {
                            $search_filepathSql_row = mysqli_fetch_assoc($search_filepathSql_result);
                            $filepath = $search_filepathSql_row['path'];
                        }
                    ?>
                    <img src="<?php echo $filepath; ?>" alt="product-board.php">
                </div>
                <div class="product-info">
                    <span class="category"><?php echo $basket_row['name']; ?></span>
                    <h4 class="title">
                        <a href="product-board.php?product_id=<?php echo $basket_row['RegProductTbl_idx1']; ?>"><?php echo $basket_row['title']; ?></a>
                    </h4>
                    <ul class="review">
                    <?php
                    
                    $rating = $basket_row['favorite'];

                    $getCommentCountSql = "SELECT COUNT(*) AS commentCount FROM comment WHERE RegProductTbl_idx = ?";
                    $stmt_getCommentCount = mysqli_prepare($dbconn, $getCommentCountSql);
                    mysqli_stmt_bind_param($stmt_getCommentCount, "i", $idx);
                    mysqli_stmt_execute($stmt_getCommentCount);
                    $getCommentCountResult = mysqli_stmt_get_result($stmt_getCommentCount);

                    if ($getCommentCountRow = mysqli_fetch_assoc($getCommentCountResult)) {
                        $commentcount = $getCommentCountRow['commentCount'];
                    } else {
                        $commentcount = 0; // 댓글이 없는 경우 0으로 초기화
                    }

                    // 평점 별점 아이콘 개수 설정
                    $filledStars = floor($rating); // 평점에 해당하는 가득 찬 별 아이콘 개수
                    $halfStar = ($rating - $filledStars) >= 0.5; // 0.5 이상인 경우 반 별 아이콘 표시
                    $emptyStars = 5 - $filledStars - $halfStar; // 나머지 빈 별 아이콘 개수

                    // 가득 찬 별 아이콘 출력
                    for ($i = 0; $i < $filledStars; $i++) {
                        echo '<li><i class="lni lni-star-filled"></i></li>';
                    }

                    // 반 별 아이콘 출력
                    if ($halfStar) {
                        echo '<li><i class="lni lni-star-filled"></i></li>';
                    }

                    // 빈 별 아이콘 출력
                    for ($i = 0; $i < $emptyStars; $i++) {
                        echo '<li><i class="lni lni-star"></i></li>';
                    }

                    // 평점 리뷰 개수 출력
                    echo '<li><span>' . $commentcount . ' Review(s)</span></li>';
                    ?>
                </ul>
                    <div class="price">
                        <span><?php echo $basket_row['price']; ?></span>
                    </div>
                

                <div class="trash" style="text-align: right;">
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input type="hidden" name="idx" value="<?php echo $basket_row['basket_idx']; ?>">
                        
                        <button type="submit" class="btn btn-danger float-right">x</button>
                    </form>
                </div>
                </div>
            </div>
            <!-- End Single Product -->
        </div>
        <?php } ?>
    </div>
</div>
<br>



    
    <!-- End Trending Product Area -->

    <!-- Start Call Action Area -->
   

    <!-- Start Shipping Info -->
    <section class="shipping-info">
        <div class="container">
            <ul>
                <!-- Free Shipping -->
                <li>
                    <div class="media-icon">
                        <i class="lni lni-delivery"></i>
                    </div>
                    <div class="media-body">
                        <h5>Free Shipping</h5>
                        <span>On order over $99</span>
                    </div>
                </li>
                <!-- Money Return -->
                <li>
                    <div class="media-icon">
                        <i class="lni lni-support"></i>
                    </div>
                    <div class="media-body">
                        <h5>24/7 Support.</h5>
                        <span>Live Chat Or Call.</span>
                    </div>
                </li>
                <!-- Support 24/7 -->
                <li>
                    <div class="media-icon">
                        <i class="lni lni-credit-cards"></i>
                    </div>
                    <div class="media-body">
                        <h5>Online Payment.</h5>
                        <span>Secure Payment Services.</span>
                    </div>
                </li>
                <!-- Safe Payment -->
                <li>
                    <div class="media-icon">
                        <i class="lni lni-reload"></i>
                    </div>
                    <div class="media-body">
                        <h5>Easy Return.</h5>
                        <span>Hassle Free Shopping.</span>
                    </div>
                </li>
            </ul>
        </div>
    </section>
    <!-- End Shipping Info -->

    <?php
    include('./btm.php');
    ?>
    
    </body>
</html>