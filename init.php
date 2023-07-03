<?php 
    include('./dbconn.php');
    $dbconn = dbconn();
    $sql ="INSERT INTO userTbl (id, passwd, email, name, sex, birth) VALUES ('admin', 'admin', 'admin@admin', 'admin', 1, '1900-01-01')";;
    $result=mysqli_query($dbconn,$sql);
    if($result)
    {
        echo "admin created";
    }
?>