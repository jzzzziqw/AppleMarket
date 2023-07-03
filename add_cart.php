<?php session_start(); 
    include('./dbconn.php');
    $dbconn = dbconn();
    $product_id=$_GET['product_id'];
    
    if(!empty($product_id))
    {
        $id = $_SESSION['id'];
        
        $search_sql="SELECT idx from userTbl where id='$id'";
        $search_result=mysqli_query($dbconn,$search_sql);
        if($search_result)
        {
            $search_row=mysqli_fetch_assoc($search_result);
            if($search_row!=null)
            {
                $user_idx=$search_row['idx'];    
                

                $search_duplication = "SELECT * FROM basketTbl where userTbl_idx=$user_idx AND product_num = $product_id";
                $search_duplication_result=mysqli_query($dbconn,$search_duplication);
                if($search_duplication_result)
                {
                   if( mysqli_num_rows($search_duplication_result) === 1)
                   {
                        echo "<script>alert('이미 찜한 목록에 존재합니다.');location.href='/';</script>";
                        exit;
                   }
                }
                
                $insert_basketSql="INSERT INTO basketTbl(userTbl_idx,product_num) values ($user_idx,$product_id)";
                $insert_basketSql_result=mysqli_query($dbconn,$insert_basketSql);
                if($insert_basketSql_result)
                {
                    echo "<script>alert('찜 항목에 추가되었습니다.');location.href='/';</script>";
                    
                }else {
                    echo "<script>location.href='/';</script>";
                    exit;
                }

            }else {
                echo "<script>location.href='/';</script>";
                exit;
            }


            
            
        }

    }else 
    {
        echo "<script>history.back();</script>";
        exit;
    }

?>