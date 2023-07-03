<?php
    include('./top.php');
    ?>
    </header>
    
    
    <?php
    include('./dbconn.php');
    $dbconn = dbconn();

    $product_id = $_GET['product_id'];
    $user_id=$_SESSION['id'];

    $view_sql = "UPDATE RegProductTbl SET view = view + 1 WHERE idx = $product_id";
    $result = $dbconn->query($view_sql) or die("query error => " . $dbconn->error);
    $query = "SELECT * FROM RegProductTbl WHERE idx = $product_id";
    $result = $dbconn->query($query) or die("query error => " . $dbconn->error);
    $PD = $result->fetch_object();

    $query2 = "SELECT * FROM CategoryTbl WHERE RegProductTbl_idx1 = $product_id";
    $result2 = $dbconn->query($query2) or die("query error => " . $dbconn->error);
    $CT = $result2->fetch_object();

    $query3 = "SELECT * FROM Scategorytbl WHERE RegProductTbl_idx = $product_id";
    $result3 = $dbconn->query($query3) or die("query error => " . $dbconn->error);
    $SCT = $result3->fetch_object();

    $query4 = "SELECT path FROM filepathTbl WHERE RegProductTbl_idx = $product_id";
    $result4 = $dbconn->query($query4) or die("query error => " . $dbconn->error);

    // Fetch all paths into an array
    $paths = array();
    while ($row = $result4->fetch_object()) {
        $paths[] = $row->path;
    }

    $user_idx_query = "SELECT idx FROM userTbl WHERE id = ?";
    $stmt_user_idx = mysqli_prepare($dbconn, $user_idx_query);
    mysqli_stmt_bind_param($stmt_user_idx, "s", $user_id);
    mysqli_stmt_execute($stmt_user_idx);
    $user_idx_result = mysqli_stmt_get_result($stmt_user_idx);
    if ($user_idx_result) {
        $user_idx_row = mysqli_fetch_assoc($user_idx_result);
        $user_idx = $user_idx_row['idx'];
        
    }
?>


    <!-- Start Hero Area -->
    <section class="hero-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-12 custom-padding-right">
                        <!-- Start Small Banner -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Hero Area -->

    <!-- Start Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">
                            <a href="index.php"><i class="lni lni-home"></i> Home</a>
                        </h1>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <ul class="breadcrumb-nav">
                        <li><a href="contact.html"><i class="lni lni-warning"></i>신고하기</a></li>
                        <?php if ($user_idx == $PD->userTbl_idx|| isset($_SESSION['admin'])) { ?>
                        <li><a href="product-modify.php?product_id=<?php echo $product_id; ?>"><i class="lni lni-pencil"></i>수정하기</a></li>
                        <?php } ?>
                        <?php if ($user_idx == $PD->userTbl_idx|| isset($_SESSION['admin'])) { ?>
                        <li><a href="product-delete.php?product_id=<?php echo $product_id; ?>"><i class="lni lni-trash-can"></i>삭제하기</a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Start Item Details -->
    <section class="item-details section">
        <div class="container">
            <div class="top-area">
                <div class="row align-items-center">
                    <div class="col-lg-5 col-md-6 col-6">
                        <div class="product-images">
                            <main id="gallery">
                                <div class="main-img">
                                    <?php if (!empty($paths)) { ?>
                                        <img src="<?php echo $paths[0]; ?>" id="current" alt="Product Image">
                                    <?php } ?>
                                </div>
                                <div class="images">
                                    <?php foreach ($paths as $path) { ?>
                                        <img src="<?php echo $path; ?>" class="img" alt="Product Image">
                                    <?php } ?>
                                </div>
                            </main>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="product-info">
                            <h2 class="title"><?php echo $PD->title; ?></h2><br>
                            <p class="category"><i class="lni lni-tag"></i> 카테고리: <a href="/search-result.php?search_keyword=<?php echo $CT->name; ?>"><?php echo $CT->name; ?></a></p>
                            <p class="category"><i class="lni lni-tag"></i> 브랜드: <a href="/search-result.php?search_keyword=<?php echo $SCT->name; ?>"><?php echo $SCT->name; ?></a></p>
                            <p class="category"><i class="lni lni-tag"></i> 태그: <a href="/search-result.php?search_keyword=<?php echo $PD->tags; ?>"><?php echo $PD->tags; ?></a></p>
                            <h3 class="price"><?php echo $PD->price; ?>원</h3>
                            <p class="info-text"><i class="lni lni-dot"></i>&nbsp;제품 상태:&nbsp;<b><?php echo $PD->condition; ?></b>,&nbsp;&nbsp;<i class="lni lni-check"></i>교환 여부:&nbsp;<b><?php echo $PD->exchange; ?></b>,&nbsp;&nbsp;<i class="lni lni-check"></i>구매 추천 연령대:&nbsp;<b><?php echo $PD->ageRange; ?> 대</b></p>
                            <div class="bottom-content">
                                <div class="row align-items-end">
                                <div class="col-lg-4 col-md-4 col-2">
                                    <div class="button cart-button">
                                    <button class="btn" onclick="openChatPopup()"><a href="#" style="color: white;">채팅하기</a></button>
                                        <script>
                                        function openChatPopup() {
                                        const url = 'chat.html';
                                        const target = '_blank';
                                        const windowFeatures = 'width=420,height=640';

                                        window.open(url, target, windowFeatures);
                                        }
                                        </script>
                                    </div>
                                </div>
                                <div class="col-lg- col-md-4 col-2">
                                    <div class="button cart-button">
                                        <?php if ($user_id) { ?>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">후기 쓰기</button>
                                        <?php } else { ?>
                                            <button class="btn" onclick="alert('잘못된 접근입니다.');">후기 쓰기</button>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-2">
                                    <div class="wish-button">
                                        <?php if ($user_id) { ?>
                                            <a href="add_cart.php?product_id=<?php echo $product_id;?>" target="_self" style="color: white;">
                                                <button class="btn"><i class="lni lni-heart"></i> 찜</button>
                                            </a>
                                        <?php } else { ?>
                                            <button class="btn" onclick="alert('잘못된 접근입니다.');"><i class="lni lni-heart"></i> 찜</button>
                                        <?php } ?>
                                    </div>
                                    
                                </div>
                                <div class="col-lg-2 col-md-2 col-1">
                                <div class="wish-button">
                                        <button class="btn"><i class="lni lni-eye"></i><?php echo $PD->view; ?></button>
                                    </div>
                                </div>

                                </div>
                            </div>  
                        </div>
                    </div>
                </div>
            </div>
            <div class="product-details-info">
                <div class="single-block">
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <div class="info-body custom-responsive-margin">
                                <h4>상세 설명</h4>
                                <p><?php echo $PD->content; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="product-details-info">
            <div class="single-block">
    <div class="row">
        <div class="col-lg-6 col-12">
            <div class="info-body custom-responsive-margin">
                <h4>리뷰 목록</h4>
                <?php
                $reple = "SELECT * FROM comment WHERE RegProductTbl_idx = '$product_id' ORDER BY idx DESC LIMIT 0, 8";
                $result = $dbconn->query($reple);
                $query3 = "SELECT favorite FROM RegProductTbl WHERE idx = $product_id";
                $favorite = $dbconn->query($query3) or die("query error => " . $dbconn->error);

                while ($reply = $result->fetch_array()) {
                    $CM = (object) $reply;

                    $query4 = "SELECT id FROM userTbl WHERE idx = $CM->userTbl_idx";
                    $result4 = $dbconn->query($query4) or die("query error => " . $dbconn->error);
                    $USER = $result4->fetch_object();
                    ?>

                    <div style="border: 1px solid #eee; border-radius: 4px; padding:10px; width : 200%;">
                        <div class="col-lg-6 col-12">
                            <div><b><?php echo $CM->title ?></b></div>
                            <div><?php echo $USER->id; ?> &nbsp;|&nbsp; <i><?php echo $CM->commentDate; ?></i></div>
                            <br>
                            <div><?php echo $CM->comment; ?></div>
                        </div>
                        <div class="rep_me rep_menu">
                            <br>
                            <?php if ( $user_id == $USER->id || isset($_SESSION['admin'])) { ?>
                                <a data-bs-toggle="modal" data-bs-target="#review-edit-<?php echo $CM->idx; ?>" style="color: #FF6C64;">수정</a>
                            <?php } ?>
                            <?php if ( $user_id ==$USER->id || isset($_SESSION['admin'])) { ?>
                                <a class="dat_delete_bt" href="/rep-del.php??product_id=<?php echo $product_id; ?>&rep_id=<?php echo $CM->idx; ?>">삭제</a>
                            <?php } ?>
                        </div>
                    </div>


                    <!-- 댓글 수정 폼 dialog -->
                    <div class="dat_edit">
                        <div class="modal fade review-modal" id="review-edit-<?php echo $CM->idx; ?>" tabindex="-1" aria-labelledby="review-editLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="review-editLabel">후기 쓰기</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post" action="/rep_modify_ok.php?product_id=<?php echo $product_id; ?>&rep_id=<?php echo $CM->idx; ?>">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="title">제목</label>
                                                        <input class="form-control" type="text" id="title" name="title" value="<?php echo $CM->title; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="favorite">평점</label>
                                                        <select class="form-control" id="favorite" name="favorite">
                                                            <option value="5" <?php if ($PD->favorite === '5') echo 'selected'; ?>>5 Stars</option>
                                                            <option value="4" <?php if ($PD->favorite === '4') echo 'selected'; ?>>4 Stars</option>
                                                            <option value="3" <?php if ($PD->favorite === '3') echo 'selected'; ?>>3 Stars</option>
                                                            <option value="2" <?php if ($PD->favorite === '2') echo 'selected'; ?>>2 Stars</option>
                                                            <option value="1" <?php if ($PD->favorite === '1') echo 'selected'; ?>>1 Star</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="comment">본문</label>
                                                <textarea class="form-control" id="comment" rows="8" name="comment" required><?php echo $CM->comment; ?></textarea>
                                            </div>
                                            <div class="modal-footer button">
                                                <button type="submit" class="btn">등록하기</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Review Modal -->
</div>


    </section>
    <!-- End Item Details -->



  <!-- Review Modal -->
<div class="modal fade review-modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">후기 쓰기</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="product-recom.php?product_id=<?php echo $product_id; ?>" method="POST">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="title">제목</label>
                                <input class="form-control" type="text" id="title" name="title" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="favorite">평점</label>
                                <select class="form-control" id="favorite" name="favorite">
                                    <option value="5">5 Stars</option>
                                    <option value="4">4 Stars</option>
                                    <option value="3">3 Stars</option>
                                    <option value="2">2 Stars</option>
                                    <option value="1">1 Star</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="comment">본문</label>
                        <textarea class="form-control" id="comment" rows="8" name="comment" required></textarea>
                    </div>
                    <div class="modal-footer button">
                        <button type="submit" class="btn">등록하기</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- End Review Modal -->

<?php
include('./btm.php');
?>

</body>

</html>
