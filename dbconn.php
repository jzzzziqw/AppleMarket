<?php   
function dbconn(){
    $db_host="localhost";
    $db_user="root";
    $db_password="applemarket44";
    $db_name="AppleMarket"; //apple market database
    $conn=mysqli_connect($db_host,$db_user,$db_password,$db_name) or die("Connect Error");
    return $conn;
}
?>