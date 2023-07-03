<?php
    include('./dbconn.php');
    $dbconn = dbconn();

    include('./search-query.php');

    $search_keyword = $_GET['search_keyword']; // 검색어 값을 받아옴
    
    if (empty($search_keyword) || trim($search_keyword) === '') {
        // 검색어가 없거나 공백인 경우
        $search_empty = true;
        $search_comment = false;
    } elseif (strpos($search_keyword, '<!--') !== false) {
        $search_empty = true;
        $search_comment = true;
    } else {
        $search_empty = false;
        $search_comment = false;

        // 검색어 분할
        $keywords_array = explode(" ", $search_keyword);

        // 전체 검색 조건 생성
        // R.title, R.tags와 C.name을 하나의 문장으로 결합
        $combined_sentence = "CONCAT(R.title, ' ', R.tags, ' ', C.name)"; // 수정 시 소카테고리 추가

        // 제목+태그 검색어 조건 설정
        $search_conditions = array();
        foreach ($keywords_array as $search_keyword) {
            $search_conditions[] = "$combined_sentence LIKE '%$search_keyword%'";
        }

        $querySearch .= " WHERE " . implode(" AND ", $search_conditions);
        $querySearchProduct .= " WHERE " . implode(" AND ", $search_conditions);
        $querySearchCategory .= " WHERE " . implode(" AND ", $search_conditions);
        //echo $querySearchProduct . " <br><br>";
    }
    



    if (isset($_POST['age'])) {
        $selectedAges = $_POST['age'];
    
        // 나이대를 필터링하는 조건 추가
        $ageConditions = [];
        foreach ($selectedAges as $age) {
            $ageConditions[] = "R.ageRange = '$age'";
            //echo "->" . $age . "<-<br>";
        }
        $ageCondition = implode(" OR ", $ageConditions);
    
        // 쿼리문에 나이대 조건 추가
        if (!empty($ageCondition)) {
            $querySearch .= " AND ($ageCondition)";
            $querySearchProduct .= " AND ($ageCondition)";
            $querySearchCategory .= " AND ($ageCondition)";
        }
    }


    if (isset($_POST['deal'])) {
        $selectedDeal = $_POST['deal'];

        //echo "->>" . $selectedDeal . "<<-<br>";

        $querySearch .= " AND R.type = '$selectedDeal'";
        $querySearchProduct .= " AND R.type = '$selectedDeal'";
        $querySearchCategory .= " AND R.type = '$selectedDeal'";
    }


    if (isset($_POST['cond'])) {
        $selectedCondition = $_POST['cond'];

        //echo "=>" . $selectedCondition . "<=<br>";

        $querySearch .= " AND R.condition = '$selectedCondition'";
        $querySearchProduct .= " AND R.condition = '$selectedCondition'";
        $querySearchCategory .= " AND R.condition = '$selectedCondition'";
    }


    if (isset($_POST['exch'])) {
        $selectedExchange = $_POST['exch'];

        //echo "=>>" . $selectedExchange . "<<=<br>";

        $querySearch .= " AND R.exchange = '$selectedExchange'";
        $querySearchProduct .= " AND R.exchange = '$selectedExchange'";
        $querySearchCategory .= " AND R.exchange = '$selectedExchange'";
    }


    if (isset($_POST['region'])) {
        $selectedRegion = $_POST['region'];
    
        //echo "<=" . $selectedRegion . "=><br>";

        $querySearch .= " AND A.Addr = '$selectedRegion'";
        $querySearchProduct .= " AND A.Addr = '$selectedRegion'";
        $querySearchCategory .= " AND A.Addr = '$selectedRegion'";
    }    


    // 최소 최대 가격 검사
    $minPrice = isset($_POST['min-price']) ? $_POST['min-price'] : '';
    $maxPrice = isset($_POST['max-price']) ? $_POST['max-price'] : '';
    $minPrice = intval(str_replace(',', '', $minPrice));
    $maxPrice = intval(str_replace(',', '', $maxPrice));

    // min-price와 max-price가 모두 입력된 경우
    if (!empty($minPrice) && !empty($maxPrice)) {
        $querySearch .= " AND R.price >= $minPrice AND R.price <= $maxPrice";
        $querySearchProduct .= " AND R.price >= $minPrice AND R.price <= $maxPrice";
        $querySearchCategory .= " AND R.price >= $minPrice AND R.price <= $maxPrice";
    } elseif (!empty($minPrice)) {
        // min-price만 입력된 경우
        $querySearch .= " AND R.price >= $minPrice";
        $querySearchProduct .= " AND R.price >= $minPrice";
        $querySearchCategory .= " AND R.price >= $minPrice";
    } elseif (!empty($maxPrice)) {
        // max-price만 입력된 경우
        $querySearch .= " AND R.price >= $minPrice";
        $querySearchProduct .= " AND R.price >= $minPrice";
        $querySearchCategory .= " AND R.price >= $minPrice";
    }


    if (isset($_POST['sort'])) {
        $selectedSort = $_POST['sort'];
    
        //echo "<-" . $selectedExchange . "-><br>";
    
        // 정렬 조건 추가
        switch ($selectedSort) {
            case 'oldest':
                $querySearch .= " ORDER BY R.regDate ASC"; /*STR_TO_DATE(R.regDate, '%Y-%m-%d')*/
                $querySearchProduct .= " ORDER BY R.regDate ASC";
                $querySearchCategory .= " ORDER BY R.regDate ASC";
                break;
            case 'latest':
                $querySearch .= " ORDER BY R.regDate DESC";
                $querySearchProduct .= " ORDER BY R.regDate DESC";
                $querySearchCategory .= " ORDER BY R.regDate DESC";
                break;
            case 'lowest':
                $querySearch .= " ORDER BY R.price ASC";
                $querySearchProduct .= " ORDER BY R.price ASC";
                $querySearchCategory .= " ORDER BY R.price ASC";
                break;
            case 'highest':
                $querySearch .= " ORDER BY R.price DESC";
                $querySearchProduct .= " ORDER BY R.price DESC";
                $querySearchCategory .= " ORDER BY R.price DESC";
                break;
        }
    }
    
    
    $queryBase = $querySearchProduct;
    //echo $queryBase . "<br> = <br>" . $querySearchProduct . " [Base]<br><br>";
    
    $querySearchCategory1 = $queryBase . " AND C.name = '디지털/가전'";
    $querySearchCategory2 = $queryBase . " AND C.name = '음반/악기'";
    $querySearchCategory3 = $queryBase . " AND C.name = '뷰티/미용'";
    $querySearchCategory4 = $queryBase . " AND C.name = '스포트/레저'";
    $querySearchCategory5 = $queryBase . " AND C.name = '차량/오토바이'";
    $querySearchCategory6 = $queryBase . " AND C.name = '예술/희귀'";
    $querySearchCategory7 = $queryBase . " AND C.name = '가구/인테리어'";
    $querySearchCategory8 = $queryBase . " AND C.name = '생활/주방용품'";
    $querySearchCategory9 = $queryBase . " AND C.name = '도서/티켓'";
    $querySearchCategory10 = $queryBase . " AND C.name = '스타굿즈'";
    $querySearchCategory11 = $queryBase . " AND C.name = '키덜트'";
    $querySearchCategory12 = $queryBase . " AND C.name = '유아동/출산'";
    $querySearchCategory13 = $queryBase . " AND C.name = '시계/쥬얼리'";
    $querySearchCategory14 = $queryBase . " AND C.name = '남성의류'";
    $querySearchCategory15 = $queryBase . " AND C.name = '여성의류'";
    $querySearchCategory16 = $queryBase . " AND C.name = '가방'";
    $querySearchCategory17 = $queryBase . " AND C.name = '신발'";
    $querySearchCategory18 = $queryBase . " AND C.name = '반려동물용품'";
    $querySearchCategory19 = $queryBase . " AND C.name = '공구/산업용품'";
    $querySearchCategory20 = $queryBase . " AND C.name = '기타'";
    $resultSearchCategory1 = mysqli_query($dbconn, $querySearchCategory1);
    $resultSearchCategory2 = mysqli_query($dbconn, $querySearchCategory2);
    $resultSearchCategory3 = mysqli_query($dbconn, $querySearchCategory3);
    $resultSearchCategory4 = mysqli_query($dbconn, $querySearchCategory4);
    $resultSearchCategory5 = mysqli_query($dbconn, $querySearchCategory5);
    $resultSearchCategory6 = mysqli_query($dbconn, $querySearchCategory6);
    $resultSearchCategory7 = mysqli_query($dbconn, $querySearchCategory7);
    $resultSearchCategory8 = mysqli_query($dbconn, $querySearchCategory8);
    $resultSearchCategory9 = mysqli_query($dbconn, $querySearchCategory9);
    $resultSearchCategory10 = mysqli_query($dbconn, $querySearchCategory10);
    $resultSearchCategory11 = mysqli_query($dbconn, $querySearchCategory11);
    $resultSearchCategory12 = mysqli_query($dbconn, $querySearchCategory12);
    $resultSearchCategory13 = mysqli_query($dbconn, $querySearchCategory13);
    $resultSearchCategory14 = mysqli_query($dbconn, $querySearchCategory14);
    $resultSearchCategory15 = mysqli_query($dbconn, $querySearchCategory15);
    $resultSearchCategory16 = mysqli_query($dbconn, $querySearchCategory16);
    $resultSearchCategory17 = mysqli_query($dbconn, $querySearchCategory17);
    $resultSearchCategory18 = mysqli_query($dbconn, $querySearchCategory18);
    $resultSearchCategory19 = mysqli_query($dbconn, $querySearchCategory19);
    $resultSearchCategory20 = mysqli_query($dbconn, $querySearchCategory20);
    
    
    //echo $querySearch . " [Search]<br><br>";
    //echo $querySearchProduct . " [Product]<br><br>";
    //echo $querySearchCategory . " [Category]<br><br>";

    $resultSearch = mysqli_query($dbconn, $querySearch);
    $resultSearchProduct = mysqli_query($dbconn, $querySearchProduct);
    $resultSearchCategory = mysqli_query($dbconn, $querySearchCategory);
    ?>
    


    <?php
    include('./top.php');
?>
    
    </header>
    <div class="search-container">
        <div class="search-head">
            <div class="category-result">
            <div class="category-head">
                    <div class="category-head-content">
                        <div class="category-head-content-title"><h4>카테고리</h4></div>
                    </div>
                </div>
                <div class="category-table">
                    <div>
                        <a href="<?php echo $_SERVER['PHP_SELF']; ?>?search_keyword=디지털/가전" class="category-product">
                            <div class="category-product-name">디지털/가전</div>
                            <div class="category-product-number"><?php echo mysqli_num_rows($resultSearchCategory1); ?></div>
                        </a>
                    </div>
                    <div>
                        <a href="<?php echo $_SERVER['PHP_SELF']; ?>?search_keyword=음반/악기" class="category-product">
                            <div class="category-product-name">음반/악기</div>
                            <div class="category-product-number"><?php echo mysqli_num_rows($resultSearchCategory2); ?></div>
                        </a>
                    </div>
                    <div>
                        <a href="<?php echo $_SERVER['PHP_SELF']; ?>?search_keyword=뷰티/미용" class="category-product">
                            <div class="category-product-name">뷰티/미용</div>
                            <div class="category-product-number"><?php echo mysqli_num_rows($resultSearchCategory3); ?></div>
                        </a>
                    </div>
                    <div>
                        <a href="<?php echo $_SERVER['PHP_SELF']; ?>?search_keyword=스포츠/레저" class="category-product">
                            <div class="category-product-name">스포츠/레저</div>
                            <div class="category-product-number"><?php echo mysqli_num_rows($resultSearchCategory4); ?></div>
                        </a>
                    </div>
                    <div>
                        <a href="<?php echo $_SERVER['PHP_SELF']; ?>?search_keyword=차량/오토바이" class="category-product">
                            <div class="category-product-name">차량/오토바이</div>
                            <div class="category-product-number"><?php echo mysqli_num_rows($resultSearchCategory5); ?></div>
                        </a>
                    </div>
                    <div>
                        <a href="<?php echo $_SERVER['PHP_SELF']; ?>?search_keyword=예술/희귀" class="category-product">
                            <div class="category-product-name">예술/희귀</div>
                            <div class="category-product-number"><?php echo mysqli_num_rows($resultSearchCategory6); ?></div>
                        </a>
                    </div>
                    <div>
                        <a href="<?php echo $_SERVER['PHP_SELF']; ?>?search_keyword=가구/인테리어" class="category-product">
                            <div class="category-product-name">가구/인테리어</div>
                            <div class="category-product-number"><?php echo mysqli_num_rows($resultSearchCategory7); ?></div>
                        </a>
                    </div>
                    <div>
                        <a href="<?php echo $_SERVER['PHP_SELF']; ?>?search_keyword=생활/주방용품" class="category-product">
                            <div class="category-product-name">생활/주방용품</div>
                            <div class="category-product-number"><?php echo mysqli_num_rows($resultSearchCategory8); ?></div>
                        </a>
                    </div>
                    <div>
                        <a href="<?php echo $_SERVER['PHP_SELF']; ?>?search_keyword=도서/티켓" class="category-product">
                            <div class="category-product-name">도서/티켓</div>
                            <div class="category-product-number"><?php echo mysqli_num_rows($resultSearchCategory9); ?></div>
                        </a>
                    </div>
                    <div>
                        <a href="<?php echo $_SERVER['PHP_SELF']; ?>?search_keyword=스타굿즈" class="category-product">
                            <div class="category-product-name">스타굿즈</div>
                            <div class="category-product-number"><?php echo mysqli_num_rows($resultSearchCategory10); ?></div>
                        </a>
                    </div>
                    <div>
                        <a href="<?php echo $_SERVER['PHP_SELF']; ?>?search_keyword=키덜트" class="category-product">
                            <div class="category-product-name">키덜트</div>
                            <div class="category-product-number"><?php echo mysqli_num_rows($resultSearchCategory11); ?></div>
                        </a>
                    </div>
                    <div>
                        <a href="<?php echo $_SERVER['PHP_SELF']; ?>?search_keyword=유아동/출산" class="category-product">
                            <div class="category-product-name">유아동/출산</div>
                            <div class="category-product-number"><?php echo mysqli_num_rows($resultSearchCategory12); ?></div>
                        </a>
                    </div>
                    <div>
                        <a href="<?php echo $_SERVER['PHP_SELF']; ?>?search_keyword=시계/쥬얼리" class="category-product">
                            <div class="category-product-name">시계/쥬얼리</div>
                            <div class="category-product-number"><?php echo mysqli_num_rows($resultSearchCategory13); ?></div>
                        </a>
                    </div>
                    <div>
                        <a href="<?php echo $_SERVER['PHP_SELF']; ?>?search_keyword=남성의류" class="category-product">
                            <div class="category-product-name">남성의류</div>
                            <div class="category-product-number"><?php echo mysqli_num_rows($resultSearchCategory14); ?></div>
                        </a>
                    </div>
                    <div>
                        <a href="<?php echo $_SERVER['PHP_SELF']; ?>?search_keyword=여성의류" class="category-product">
                            <div class="category-product-name">여성의류</div>
                            <div class="category-product-number"><?php echo mysqli_num_rows($resultSearchCategory15); ?></div>
                        </a>
                    </div>
                    <div>
                        <a href="<?php echo $_SERVER['PHP_SELF']; ?>?search_keyword=가방" class="category-product">
                            <div class="category-product-name">가방</div>
                            <div class="category-product-number"><?php echo mysqli_num_rows($resultSearchCategory16); ?></div>
                        </a>
                    </div>
                    <div>
                        <a href="<?php echo $_SERVER['PHP_SELF']; ?>?search_keyword=신발" class="category-product">
                            <div class="category-product-name">신발</div>
                            <div class="category-product-number"><?php echo mysqli_num_rows($resultSearchCategory17); ?></div>
                        </a>
                    </div>
                    <div>
                        <a href="<?php echo $_SERVER['PHP_SELF']; ?>?search_keyword=반려동물용품" class="category-product">
                            <div class="category-product-name">반려동물용품</div>
                            <div class="category-product-number"><?php echo mysqli_num_rows($resultSearchCategory18); ?></div>
                        </a>
                    </div>
                    <div>
                        <a href="<?php echo $_SERVER['PHP_SELF']; ?>?search_keyword=공구/산업용품" class="category-product">
                            <div class="category-product-name">공구/산업용품</div>
                            <div class="category-product-number"><?php echo mysqli_num_rows($resultSearchCategory19); ?></div>
                        </a>
                    </div>
                    <div>
                        <a href="<?php echo $_SERVER['PHP_SELF']; ?>?search_keyword=기타" class="category-product">
                            <div class="category-product-name">기타</div>
                            <div class="category-product-number"><?php echo mysqli_num_rows($resultSearchCategory20); ?></div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="sr-filter">
                <div class="sr-filter-head">
                    <div class="sr-filter-head-text">
                        <h4>상세검색</h4>
                    </div>
                </div>

                <div class="sr-filter-body">
                    <form id="filter" action="<?php echo $_SERVER['PHP_SELF']; ?>?search_keyword=<?php echo $search_keyword; ?>" method="POST">
                        <div class="filter-group">
                            <div class="filter-label">
                                <a class="sr-head-content">
                                    <div class="sr-head-content-name">연령대</div>
                                </a>
                            </div>
                            <div class="filter-options">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="age-10s" name="age[]" value="10">
                                    <label class="form-check-label" for="age-10s">
                                        <div class="form-text">10대</div>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="age-20s" name="age[]" value="20">
                                    <label class="form-check-label" for="age-20s">
                                        <div class="form-text">20대</div>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="age-30s" name="age[]" value="30">
                                    <label class="form-check-label" for="age-30s">
                                        <div class="form-text">30대</div>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="age-40s" name="age[]" value="40">
                                    <label class="form-check-label" for="age-40s">
                                        <div class="form-text">40대+</div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="filter-group">
                            <div class="filter-label">
                                <a class="sr-head-content">
                                    <div class="sr-head-content-name">유형</div>
                                </a>
                            </div>
                            <div class="filter-options">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="deal-sell" name="deal" value="판매">
                                    <label class="form-check-label" for="deal-sell">
                                        <div class="form-text">판매</div>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="deal-buy" name="deal" value="구매">
                                    <label class="form-check-label" for="deal-buy">
                                        <div class="form-text">구매</div>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="deal-free" name="deal" value="나눔">
                                    <label class="form-check-label" for="deal-free">
                                        <div class="form-text">나눔</div>
                                    </label>
                                </div>
                                <button class="f-clear" id="f-clearDeal">선택 해제</button>
                            </div>
                        </div>
                        <div class="filter-group">
                            <div class="filter-label">
                                <a class="sr-head-content">
                                    <div class="sr-head-content-name">상태</div>
                                </a>
                            </div>
                            <div class="filter-options">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="cond-new" name="cond" value="새상품">
                                    <label class="form-check-label" for="cond-new">
                                        <div class="form-text">새 상품</div>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="cond-used" name="cond" value="중고">
                                    <label class="form-check-label" for="cond-used">
                                        <div class="form-text">중고 상품</div>
                                    </label>
                                </div>
                                <button class="f-clear" id="f-clearCond">선택 해제</button>
                            </div>
                        </div>
                        <div class="filter-group">
                            <div class="filter-label">
                                <a class="sr-head-content">
                                    <div class="sr-head-content-name">교환</div>
                                </a>
                            </div>
                            <div class="filter-options">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="exch-pos" name="exch" value="가능">
                                    <label class="form-check-label" for="exch-pos">
                                        <div class="form-text">가능</div>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="exch-imp" name="exch" value="불가">
                                    <label class="form-check-label" for="exch-imp">
                                        <div class="form-text">불가</div>
                                    </label>
                                </div>
                                <button class="f-clear" id="f-clearExch">선택 해제</button>
                            </div>
                        </div>
                        <div class="filter-group">
                            <div class="filter-label">
                                <a class="sr-head-content">
                                    <div class="sr-head-content-name">거래지</div>
                                </a>
                            </div>
                            <div class="filter-options">
                                <div class="form-dropdown">
                                    <select class="form-text" id="region-select" name="region">
                                        <option id="region-option" disabled selected>지역 선택</option>
                                        <optgroup class="form-text" label="동">
                                            <option class="form-text" value="1">교현/안림동</option>
                                            <option class="form-text" value="2">교현2동</option>
                                            <option class="form-text" value="3">달천동</option>
                                            <option class="form-text" value="4">목행/용탄동</option>
                                            <option class="form-text" value="5">문화동</option>
                                            <option class="form-text" value="6">봉방동</option>
                                            <option class="form-text" value="7">성내/충인동</option>
                                            <option class="form-text" value="8">연수동</option>
                                            <option class="form-text" value="9">용산동</option>
                                            <option class="form-text" value="10">지현동</option>
                                            <option class="form-text" value="11">칠금/금릉동</option>
                                            <option class="form-text" value="12">호암/직동</option>
                                        </optgroup>
                                        <optgroup class="form-text" label="읍">
                                            <option class="form-text" value="13">주덕읍</option>
                                        </optgroup>
                                        <optgroup class="form-text" label="면">
                                            <option class="form-text" value="14">금가면</option>
                                            <option class="form-text" value="15">노은면</option>
                                            <option class="form-text" value="16">대소원면</option>
                                            <option class="form-text" value="17">동량면</option>
                                            <option class="form-text" value="18">산척면</option>
                                            <option class="form-text" value="19">살미면</option>
                                            <option class="form-text" value="20">소태면</optioan>
                                            <option class="form-text" value="21">수안보면</option>
                                            <option class="form-text" value="22">신니면</option>
                                            <option class="form-text" value="23">앙성면</option>
                                            <option class="form-text" value="24">엄정면</option>
                                            <option class="form-text" value="25">중앙탑면</option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="filter-group">
                            <div class="filter-label">
                                <a class="sr-head-content">
                                    <div class="sr-head-content-name">가격</div>
                                </a>
                            </div>
                            <div class="filter-options">
                                <div class="min-price-input">
                                    <input type="text" class="price-text" name="min-price" placeholder="0" oninput="formatNumber(this)" onfocus="this.placeholder = ''" onblur="this.placeholder = '0'">
                                </div>
                                <div class ="won-after-input"><div class="form-text">원</div></div>
                                <div class ="tilde-among-input"><div class="form-text">~</div></div>
                                <div class="max-price-input">
                                    <input type="text" class="price-text" name="max-price" placeholder="1,000,000" oninput="formatNumber(this)" onfocus="this.placeholder = ''" onblur="this.placeholder = '1,000,000'">
                                </div>
                                <div class ="won-after-input"><div class="form-text">원</div></div>
                            </div>
                        </div>
                        <div class="filter-group">
                            <div class="filter-label">
                                <a class="sr-head-content">
                                    <div class="sr-head-content-name">정렬</div>
                                </a>
                            </div>
                            <div class="filter-options">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="sort-oldest" name="sort" value="oldest">
                                    <label class="form-check-label" for="sort-oldest">
                                        <div class="form-text">등록순</div>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="sort-latest" name="sort" value="latest">
                                    <label class="form-check-label" for="sort-latest">
                                        <div class="form-text">최신순</div>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="sort-lowest" name="sort" value="lowest">
                                    <label class="form-check-label" for="sort-lowest">
                                        <div class="form-text">낮은 가격순</div>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="sort-highest" name="sort" value="highest">
                                    <label class="form-check-label" for="sort-highest">
                                        <div class="form-text">높은 가격순</div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="filter-group">
                            <button class="btn btn-primary btn-block" type="submit" id="filter-submit">필터 적용</button>
                        </div>
                    </form>
                </div>

                <div class="sr-fltr">
                    <form id="fltr" action="<?php echo $_SERVER['PHP_SELF']; ?>?search_keyword=<?php echo $search_keyword; ?>" method="POST">
                        <div class="fltr-group">
                            <div class="fltr-label">연령대</div>
                            <div class="fltr-options">
                            <input class="form-check-input" type="checkbox" id="age-10s" name="age[]" value="10">
                            <label for="age-10s">10대</label>
                            <input class="form-check-input" type="checkbox" id="age-20s" name="age[]" value="20">
                            <label for="age-20s">20대</label>
                            <input class="form-check-input" type="checkbox" id="age-30s" name="age[]" value="30">
                            <label for="age-30s">30대</label>
                            <input class="form-check-input" type="checkbox" id="age-40s" name="age[]" value="40">
                            <label for="age-40s">40대+</label>
                            </div>
                        </div>
                        <div class="fltr-group">
                            <div class="fltr-label">유형</div>
                            <div class="fltr-options">
                            <input class="form-check-input" type="radio" id="deal-sell" name="deal" value="판매">
                            <label for="deal-sell">판매</label>
                            <input class="form-check-input" type="radio" id="deal-buy" name="deal" value="구매">
                            <label for="deal-buy">구매</label>
                            <input class="form-check-input" type="radio" id="deal-free" name="deal" value="나눔">
                            <label for="deal-free">나눔</label>
                            <button id="clearDeal">선택 해제</button>
                            </div>
                        </div>
                        <div class="fltr-group">
                            <div class="fltr-label">상태</div>
                            <div class="fltr-options">
                            <input class="form-check-input" type="radio" id="condition-new" name="cond" value="새상품">
                            <label for="condition-new">새 상품</label>
                            <input class="form-check-input" type="radio" id="condition-used" name="cond" value="중고">
                            <label for="condition-used">중고 상품</label>
                            <button id="clearCondition">선택 해제</button>
                            </div> 
                        </div>
                        <div class="fltr-group">
                            <div class="fltr-label">교환</div>
                            <div class="fltr-options">
                            <input class="form-check-input" type="radio" id="exchange-possible" name="exch" value="가능">
                            <label for="exchange-possible">가능</label>
                            <input class="form-check-input" type="radio" id="exchange-impossible" name="exch" value="불가">
                            <label for="exchange-impossible">불가</label>
                            <button id="clearExchange">선택 해제</button>
                            </div>
                        </div>
                        <div class="fltr-group">
                            <div class="fltr-label">거래지</div>
                            <div class="fltr-options">
                            <div class="form-dropdown">
                            <select class="form-text" id="region-select">
                                <option id="region-option" disabled selected>충주시</option>
                                <optgroup class="form-text" label="전체">
                                    <option class="form-text">충주시</option>
                                <optgroup class="form-text" label="읍">
                                    <option class="form-text">주덕읍</option>
                                </optgroup>
                                <optgroup class="form-text" label="면">
                                    <option class="form-text">금가면</option>
                                    <option class="form-text">노은면</option>
                                    <option class="form-text">대소원면</option>
                                    <option class="form-text">동량면</option>
                                    <option class="form-text">산척면</option>
                                    <option class="form-text">살미면</option>
                                    <option class="form-text">소태면</option>
                                    <option class="form-text">수안보면</option>
                                    <option class="form-text">신니면</option>
                                    <option class="form-text">앙성면</option>
                                    <option class="form-text">엄정면</option>
                                    <option class="form-text">중앙탑면</option>
                                </optgroup>
                                <optgroup class="form-text" label="동">
                                    <option class="form-text">교현/안림동</option>
                                    <option class="form-text">교현2동</option>
                                    <option class="form-text">달천동</option>
                                    <option class="form-text">목행/용탄동</option>
                                    <option class="form-text">문화동</option>
                                    <option class="form-text">봉방동</option>
                                    <option class="form-text">성내/충인동</option>
                                    <option class="form-text">연수동</option>
                                    <option class="form-text">용산동</option>
                                    <option class="form-text">지현동</option>
                                    <option class="form-text">칠금/금릉동</option>
                                    <option class="form-text">호암/직동</option>
                                </optgroup>
                            </select>
                            </div>
                            </div>
                        </div>
                        <div class="fltr-group">
                            <div class="fltr-label">가격</div>
                            <div class="fltr-options">
                            <input type="text" class="price-text" placeholder="0" oninput="formatNumber(this)" onfocus="this.placeholder = ''" onblur="this.placeholder = '0'">
                            <span class="range-separator">원</span>
                            <span class="range-separator">~</span>
                            <input type="text" class="price-text" placeholder="1,000,000" oninput="formatNumber(this)" onfocus="this.placeholder = ''" onblur="this.placeholder = '1,000,000'">
                            <span class="range-separator">원</span>
                            </div>
                        </div>
                        <div class="fltr-group">
                            <div class="fltr-label">정렬</div>
                            <div class="fltr-options">
                            <input class="form-check-input" type="radio" id="sort-oldest" name="sort" value="oldest">
                            <label for="sort-latest">등록순</label>
                            <input class="form-check-input" type="radio" id="sort-latest" name="sort" value="latest">
                            <label for="sort-latest">최신순</label>
                            <input class="form-check-input" type="radio" id="sort-lowest" name="sort" value="lowest">
                            <label for="sort-latest">저가순</label>
                            <input class="form-check-input" type="radio" id="sort-highest" name="sort" value="highest">
                            <label for="sort-latest">고가순</label>
                            </div>
                        </div>
                        <div class="fltr-button">
                            <button class="btn btn-primary btn-block" type="submit" id="fltr-submit">필터 적용</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <?php if ($search_empty): ?>
            <?php if ($search_comment): ?>
            <div class="search-result">
                <div class="search-result-head">
                    <div class="search-result-text">
                        <!-- 검색어가 없거나 공백인 경우에 대한 화면을 보여줌 -->
                        <span class="search-result-text-bold"><strong>올바른 검색어</strong></span>를 입력해주세요.
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="search-result">
                <div class="search-result-head">
                    <div class="search-result-text">
                        <!-- 검색어가 없거나 공백인 경우에 대한 화면을 보여줌 -->
                        <span class="search-result-text-bold"><strong>검색어</strong></span>를 입력해주세요.
                    </div>
                </div>
            </div>
            <?php endif; ?>
        
        <?php else: ?>
        <div class="search-result">
            <div class="search-result-head">
                <div class="search-result-text">
                    <!-- 검색어가 있는 경우에 대한 화면을 보여줌 -->
                    <span class="search-result-text-bold"><strong><?php echo $search_keyword; ?></strong></span>의 검색결과
                    <?php
                    $ProductCount = 0;
                    if (mysqli_num_rows($resultSearch) > 0) {
                        while ($rowS = mysqli_fetch_assoc($resultSearch)) {
                            $idxS = $rowS['idx'];
                            
                            $queryPathS = "SELECT path FROM filepathTbl WHERE RegProductTbl_idx = $idxS LIMIT 1";
                            $resultPathS = mysqli_query($dbconn, $queryPathS);
                            while ($rowPS = mysqli_fetch_assoc($resultPathS)) {
                                $ProductCount++;
                            }
                        }
                    }
                    ?>
                    <span class="search-result-text-number"><?php echo $ProductCount; ?></span>
                </div>
            </div>

            <div class="search-result-product">
            <?php
            // 페이징 변수 설정
            $productsPerPage = 8; // 한 페이지당 보여줄 상품 수
            $totalResults = mysqli_num_rows($resultSearchProduct); // 총 결과 수
            $totalPages = ceil($totalResults / $productsPerPage); // 총 페이지 수
            $currentPage = isset($_GET['page']) ? $_GET['page'] : 1; // 현재 페이지

            // 오프셋(offset)과 페이지당 상품 수를 계산합니다.
            $offset = ($currentPage - 1) * $productsPerPage;
            $productsToDisplay = $productsPerPage;

            // 마지막 페이지일 경우 상품 수를 조정합니다.
            if ($currentPage == $totalPages) {
                $productsToDisplay = $totalResults - $offset;
            }

            // SQL 쿼리를 수정하여 오프셋과 페이지당 상품 수를 적용합니다.
            $querySearchProduct .= " LIMIT $offset, $productsToDisplay";
            $resultSearchProduct = mysqli_query($dbconn, $querySearchProduct);
            
            if (mysqli_num_rows($resultSearchProduct) > 0) {
                while ($rowSP = mysqli_fetch_assoc($resultSearchProduct)) {
                    $idxSP = $rowSP['idx'];
                    
                    $queryPathSP = "SELECT path, RegProductTbl_idx FROM filepathTbl WHERE RegProductTbl_idx = $idxSP LIMIT 1";
                    $resultPathSP = mysqli_query($dbconn, $queryPathSP);
                    while ($rowPSP = mysqli_fetch_assoc($resultPathSP)) {
                        ?>
                        <div class="col-lg-3 col-md-6 single-product-element">
                            <!-- Start Single Product -->
                                <div class="single-product" onclick="window.location.href='product-board.php?product_id=<?php echo $rowPSP['RegProductTbl_idx'] ?>'">
                                    <div class="product-image">
                                        <img src="<?php echo $rowPSP['path']; ?>" alt="Image Load Failed">
                                    </div>
                                    <div class="product-info">
                                        <span class="category"><?php echo "[" . $rowSP['type'] . "] " . $rowSP['name']; ?></span>
                                        <div class="title">
                                            <a href="product-board.php?product_id=<?php echo $rowPSP['RegProductTbl_idx'] ?>"><?php echo $rowSP['title']; ?></a>
                                        </div>
                                        <ul class="review">
                                        <?php
                                        
                                        $rating = $rowSP['favorite'];

                                        $getCommentCountSql = "SELECT COUNT(*) AS commentCount FROM comment WHERE RegProductTbl_idx = ?";
                                        $stmt_getCommentCount = mysqli_prepare($dbconn, $getCommentCountSql);
                                        mysqli_stmt_bind_param($stmt_getCommentCount, "i", $idxSP);
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
                                            <span><?php echo $rowSP['price']; ?></span>
                                        </div>
                                    </div>
                                </div>
                            <!-- End Single Product -->
                        </div>
                        <?php
                    }
                }
            } else {
                //echo "No records found. - Main";
                echo "아쉽지만, 텅 비어있네요.";
                if ($search_keyword === '애벌레') {
                    echo "";
                    ?>
                    <img src="https://i.ibb.co/fvMnK2K/A-2.png" style="height: 50px;">
                    <?php
                }
                echo "<br>";
                echo "<br>";
                echo "<br>";
            }
            ?>
            </div>
            <div class="search-result-page">
                <div class="pagination">
                <?php
                if ($totalPages > 1) {
                    // 이전 페이지 버튼을 표시합니다.
                    if ($currentPage > 1) {
                        echo '<a class="search-result-page-button page-prev" href="?page=' . ($currentPage - 1) . '&search_keyword=' . urlencode($search_keyword) . '"><</a>';
                    }                    

                    // 페이지 번호를 표시합니다.
                    for ($i = 1; $i <= $totalPages; $i++) {
                        if ($i == $currentPage) {
                            echo '<a class="search-result-page-button page-number current" href="?page='.$i.'&search_keyword=' . urlencode($search_keyword).'">'.$i.'</a>';
                        } else {
                            echo '<a class="search-result-page-button page-number" href="?page='.$i.'&search_keyword=' . urlencode($search_keyword).'">'.$i.'</a>';
                        }
                    }

                    // 다음 페이지 버튼을 표시합니다.
                    if ($currentPage < $totalPages) {
                        echo '<a class="search-result-page-button page-next" href="?page='.($currentPage + 1).'&search_keyword=' . urlencode($search_keyword).'">></a>';
                    }
                }
                ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <?php
    include('./btm.php');
    ?>

</body>
</html>
