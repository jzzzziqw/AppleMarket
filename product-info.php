<?php
session_start();
include('./dbconn.php');
$dbconn = dbconn();

// SQL 쿼리 작성
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

$querySearchProduct = "SELECT C.name, R.title, R.price
                       FROM RegProductTbl R JOIN CategoryTbl C
                       ON R.idx = C.RegProductTbl_idx1
                       WHERE R.title LIKE '%$search_keyword%'";

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

$resultSearchProduct = mysqli_query($dbconn, $querySearchProduct);
?>