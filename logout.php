<?php
// 현재 세션을 시작하거나 기존 세션에 연결합니다.
session_start();

// 세션을 파괴합니다.
session_destroy();

// 로그아웃 후 리다이렉트할 페이지로 이동합니다.
header("Location: index.php");
exit;
?>