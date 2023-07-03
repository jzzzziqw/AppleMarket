<?php
$queryTables = "SHOW TABLES";

$queryAddrTbl = "SELECT * FROM AddrTbl";
$queryCategoryTbl = "SELECT * FROM CategoryTbl";
$queryRegProductTbl = "SELECT * FROM RegProductTbl";
$querySCategoryTbl = "SELECT * FROM ScategoryTbl";
$queryBasketTbl = "SELECT * FROM basketTbl";
$queryBuyTbl = "SELECT * FROM buyTbl";
$queryChatTbl = "SELECT * FROM chatTbl";
$queryCommentTbl = "SELECT * FROM commentTbl";
$queryFilePathTbl = "SELECT * FROM filepathTbl";
$queryUserTbl = "SELECT * FROM userTbl";

$queryShowProduct = "SELECT * FROM RegProductTbl";

$querySearch = "SELECT R.*, C.name, C.RegProductTbl_idx1, A.Idx, A.Addr
                FROM RegProductTbl R
                JOIN CategoryTbl C ON R.idx = C.RegProductTbl_idx1
                JOIN AddrTbl A ON R.AddrTbl_Idx = A.Idx";

$querySearchProduct = "SELECT R.*, C.name, C.RegProductTbl_idx1, A.Idx, A.Addr
                       FROM RegProductTbl R
                       JOIN CategoryTbl C ON R.idx = C.RegProductTbl_idx1
                       JOIN AddrTbl A ON R.AddrTbl_Idx = A.Idx";

$querySearchCategory = "SELECT R.*, C.name, C.RegProductTbl_idx1, A.Idx, A.Addr
                        FROM RegProductTbl R
                        JOIN CategoryTbl C ON R.idx = C.RegProductTbl_idx1
                        JOIN AddrTbl A ON R.AddrTbl_Idx = A.Idx";

// 쿼리 실행
$resultTables = mysqli_query($dbconn, $queryTables);

$resultAddrTbl = mysqli_query($dbconn, $queryAddrTbl);
$resultCategoryTbl = mysqli_query($dbconn, $queryCategoryTbl);
$resultRegProductTbl = mysqli_query($dbconn, $queryRegProductTbl);
$resultSCategoryTbl = mysqli_query($dbconn, $querySCategoryTbl);
$resultBasketTbl = mysqli_query($dbconn, $queryBasketTbl);
$resultBuyTbl = mysqli_query($dbconn, $queryBuyTbl);
$resultChatTbl = mysqli_query($dbconn, $queryChatTbl);
$resultCommentTbl = mysqli_query($dbconn, $queryCommentTbl);
$resultFilePathTbl = mysqli_query($dbconn, $queryFilePathTbl);
$resultUserTbl = mysqli_query($dbconn, $queryUserTbl);

$resultShowProduct = mysqli_query($dbconn, $queryShowProduct);

$resultSearch = mysqli_query($dbconn, $querySearch);
$resultSearchProduct = mysqli_query($dbconn, $querySearchProduct);
$resultSearchCategory = mysqli_query($dbconn, $querySearchCategory);
?>