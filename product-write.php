    <?php
    include('./top.php');
    $id=$_SESSION['id'];
    
    if(isset($id))
    {
       
    }else 
    {
        echo "<script>alert('회원만 게시글을 작성할 수 있습니다.');  location.href='login.html';</script>";
    }
    ?>
    </header>
                <script>
                    const addrs = [
                    null,
                    '교현/안림동',
                    '교현2동',
                    '달천동',
                    '목행/용탄동',
                    '문화동',
                    '봉방동',
                    '성내/충인동',
                    '연수동',
                    '용산동',
                    '지현동',
                    '칠금/금릉동',
                    '호암/직동',
                    '주덕읍',
                    '금가면',
                    '노은면',
                    '대소원면',
                    '동량면',
                    '산척면',
                    '살미면',
                    '소태면',
                    '수안보면',
                    '신니면',
                    '앙성면',
                    '엄정면',
                    '중앙탑면'
                    ];

                    
                </script>

    <div class="container">
        <div class="input-form-backgroud row">
            <div class="input-form col-md-12 mx-auto">
                <h4 class="mb-3"><br><br>상품 등록<span><h6>&nbsp;* 필수항목</h6></span></h4>
                <form class="validation-form" enctype="multipart/form-data" action="product-reg.php" method="POST">
    		        <section class="ProductNewstyle__Basic-sc-7fge4a-2 lmrVST">
                        <div class="mb-3">
                            <label for="type">게시글 유형<span style="color: #ff0000;">*</span></label>
                            <select class="form-control" id="type" name="type" required>
                                <option value="">유형을 선택하세요</option>
                                <option value="나눔">나눔</option>
                                <option value="판매">판매</option>
                                <option value="구매">구매</option>
                            </select>
                            <div class="invalid-feedback">
                                게시글 유형을 선택해주세요.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="title">제목<span style="color: #ff0000;">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="제목을 입력해주세요." value="" required>
                            <div class="invalid-feedback">
                                제목을 입력해주세요.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="category">제품 유형<span style="color: #ff0000;">*</span></label>
                            <select class="form-control" id="category" name="category" required>
                                <option value="">카테고리를 선택하세요</option>
                                <option value="디지털/가전">디지털/가전</option>
                                <option value="음반/악기">음반/악기</option>
                                <option value="뷰티/미용">뷰티/미용</option>
                                <option value="스포츠/레저">스포츠/레저</option>
                                <option value="차량/오토바이">차량/오토바이</option>
                                <option value="예술/희귀">예술/희귀</option>
                                <option value="가구/인테리어">가구/인테리어</option>
                                <option value="생활/주방용품">생활/주방용품</option>
                                <option value="도서/티켓">도서/티켓</option>
                                <option value="스타굿즈">스타굿즈</option>
                                <option value="키덜트">키덜트</option>
                                <option value="유아동/출산">유아동/출산</option>
                                <option value="시계/쥬얼리">시계/쥬얼리</option>
                                <option value="남성의류">남성의류</option>
                                <option value="여성의류">여성의류</option>
                                <option value="가방">가방</option>
                                <option value="신발">신발</option>
                                <option value="반려동물용품">반려동물용품</option>
                                <option value="공구/산업용품">공구/산업용품</option>
                                <option value="기타">기타</option>
                            </select>

                            <div class="invalid-feedback">
                                제품 카테고리를 선택해주세요.
                            </div>
                        </div>

                        <ul>
                        <li>
                            <div>제품 이미지<span style="color: #ff0000;">*</span><small id="image-count">(0/12)</small></div>
                            <div>
                                <div class="upload-box">
                                <div id="drop-file" class="drag-file">
                                    <img src="https://img.icons8.com/pastel-glyph/2x/image-file.png" alt="파일 아이콘" class="image">
                                    <p class="message">Drag & Drop</p>
                                    <img src="" alt="미리보기 이미지" class="preview">
                                </div>
                                </div>
                                <form id="uploadForm" action="product-reg.php" method="POST" enctype="multipart/form-data">
                                <label class="file-label" for="chooseFile">이미지 선택</label>
                                <input class="file-label1" type="file" name="file[]" id="chooseFile" multiple>
                                </form>
                            </div>
                            </li>

                            <li>
                                <br>
                                <div class="mb-3">
                                    <label for="Addr">거래 지역<span style="color: #ff0000;">*</span></label>
                                    <select class="form-control" id="Addr" name="Addr" required>
                                        <option value="">지역 미지정</option>
                                        
                                        <?php  
                                            include('./dbconn.php');
    
                                            $dbconn = dbconn();
                                            $user_id=$_SESSION['id'];
                                            $user_idx_query = "SELECT idx FROM userTbl WHERE id = ?";
                                            $stmt_user_idx = mysqli_prepare($dbconn, $user_idx_query);
                                            mysqli_stmt_bind_param($stmt_user_idx, "s", $user_id);
                                            mysqli_stmt_execute($stmt_user_idx);
                                            $user_idx_result = mysqli_stmt_get_result($stmt_user_idx);
                                            if ($user_idx_result) {
                                                $user_idx_row = mysqli_fetch_assoc($user_idx_result);
                                                $user_idx = $user_idx_row['idx'];
                                                
                                            }
                                            $addr_search_sql="SELECT * FROM AddrTbl where userTbl_idx = $user_idx";
                                            $addr_result=mysqli_query($dbconn,$addr_search_sql);
                                            while($addr_value=mysqli_fetch_assoc($addr_result))
                                            {
                                                $Addr=$addr_value['Addr'];
                                                $detail=$addr_value['detail'];
                                                $addrTbl_idx=$addr_value['Idx'];
                                                
                                        ?>
                                                <option value="<?php echo $addrTbl_idx;?>"><script>document.write(addrs[<?php echo $Addr; ?>]);</script> <?php echo $detail; ?></option>
                                            <?php 
                                            }
                                            ?>
                                        <!-- 새로 설정 누르면 읍면동 다시 선택할 수 있게 지정... -->
                                    </select>
                                    <div class="invalid-feedback">
                                        거래 지역을 선택해주세요.
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="mb-3">
                                    <label for="condition">제품 상태<span style="color: #ff0000;">*</span></label>
                                    <select class="form-control" id="condition" name="condition" required>
                                        <option value="">상태 미지정</option>
                                        <option value="중고">중고</option>
                                        <option value="새상품">새상품</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        제품 상태를 선택해주세요.
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="mb-3">
                                    <label for="ageRang">구매 연령대 추천<span style="color: #ff0000;">*</span></label>
                                    <select class="form-control" id="ageRange" name="ageRange" required>
                                        <option value="">구매 연령대를 선택하세요</option>
                                        <option value="10">10대</option>
                                        <option value="20">20대</option>
                                        <option value="30">30대</option>
                                        <option value="40">40대 이상</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        구매 추천 연령대를 선택해주세요.
                                    </div>
                                </div>
                            </li>

                            <li>
                                <div class="mb-3">
                                    <label for="exchange">교한 여부<span style="color: #ff0000;">*</span></label>
                                    <select class="form-control" id="exchange" name="exchange" required>
                                        <option value="">여부 미지정</option>
                                        <option value="가능">교환가능</option>
                                        <option value="불가">교환불가</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        제품 상태를 선택해주세요.
                                    </div>
                                </div>
                            </li>

                            <li>
                                <div class="mb-3">
                                    <label for="price">가격<span style="color: #ff0000;">*</span></label>
                                    <input type="text"  onkeyup="inputNumberFormat(this)" class="form-control" id="price" name="price" placeholder="가격을 입력하세요" value="" required>
                                    <div class="invalid-feedback">
                                        가격을 입력하세요
                                    </div>
                                </div>
                            </li>

                            <li>
                                <div class="mb-3">
                                    <label for="scategory">브랜드</label>
                                    <input type="text" class="form-control" id="scategory" name="scategory" placeholder="기기 브랜드를 입력하세요(ex. 삼성)">
                                    <div class="invalid-feedback">
                                        제품 브랜드명을 입력해주세요.
                                    </div>
                                </div>
                            </li>

                            <li>
                                <div class="mb-3">
                                    <label for="content">설명</label>
                                    <textarea class="form-control" id="content" name="content" placeholder="상품 설명을 입력하세요" value="" required></textarea>
                                </div>
                            </li>

                            <li>
                                <div class="mb-3">
                                    <label for="tags">연관 태그</label>
                                    <div>
                                        <input type="text" class="form-control" id="tags" name="tags" placeholder="제품 연관 태그를 입력하세요(ex. 아이폰 7/7+. 갤럭시 북3pro, etc,.)">
                                    </div>
                                </div>
                            </li>

                            <li>
                                <div class="mb-3">
                                    <label for="quantity">수량</label>
                                    <div>
                                        <input type="number" class="form-control" id="quantity" name="quantity" placeholder="수량을 입력하세요">
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <button class="btn btn-primary btn-lg btn-block" type="reset">취소하기</button>
                        &nbsp; &nbsp; 
                        <button class="btn btn-primary btn-lg btn-block" type="submit">등록하기</button>
                    </section>
                </form>

            </div>
        </div>
    </div>
    <br>
    
        
<?php
include('./btm.php');
?>

</body>

</html>
