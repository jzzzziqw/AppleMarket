<?php session_start(); ?>
<?php
include('./dbconn.php');
$dbconn = dbconn();

// 사용자가 로그인했는지 확인합니다.
if (!isset($_SESSION['id'])) {
  echo "<script>alert( '로그인되지 않았습니다.'); history.back();</script>";
  header("Location: login.html");
  exit;
}

// 로그인한 사용자의 ID를 가져옵니다.
$user_id = $_SESSION['id'];


// POST 요청에서 제품 데이터를 가져옵니다.
$type = $_POST["type"]; //type
$title = $_POST["title"]; //title
$category = $_POST["category"]; //CategoryTbl_idx
$Addr = $_POST["Addr"]; //AddrTbl_idx
$condition = $_POST["condition"];
$ageRange = $_POST["ageRange"];
$exchange = $_POST["exchange"];
$price = $_POST["price"];
$scategory = $_POST["scategory"]; //Scategory_idx
$content = $_POST["content"];
$tags = $_POST["tags"];
$quantity = $_POST["quantity"];

$price = str_replace(',', '', $price);

if ($type === "" || $title === "" || $category === "" || $Addr === "" || $condition === "" || $ageRange === "" || $exchange === "" || $price === "" ) {
  echo "<script>alert('빈칸이 있습니다.'); history.back();</script>";
} else {
  mysqli_autocommit($dbconn, false);

  $user_idx_query = "SELECT idx FROM userTbl WHERE id = ?";
  $stmt_user_idx = mysqli_prepare($dbconn, $user_idx_query);
  mysqli_stmt_bind_param($stmt_user_idx, "s", $user_id);
  mysqli_stmt_execute($stmt_user_idx);
  $user_idx_result = mysqli_stmt_get_result($stmt_user_idx);
  
  if ($user_idx_result) {
    $user_idx_row = mysqli_fetch_assoc($user_idx_result);
    $user_idx = $user_idx_row['idx'];

    

     $updateRegProductSql = "INSERT INTO RegProductTbl (type, title, AddrTbl_Idx, `condition`, userTbl_idx, ageRange, price, exchange, content, tags, quantity, favorite, view, regDate)
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0, 0, NOW())";
     $stmt_updateRegProduct = mysqli_prepare($dbconn, $updateRegProductSql);
     mysqli_stmt_bind_param($stmt_updateRegProduct, "ssisiiisssi", $type, $title, $Addr, $condition, $user_idx, $ageRange, $price, $exchange, $content, $tags, $quantity);
     $result_updateRegProduct = mysqli_stmt_execute($stmt_updateRegProduct);
      
     if ($result_updateRegProduct) {
       $idx = mysqli_insert_id($dbconn);
       if ($idx) {

          $_SESSION['product_id'] = $idx;
      
        if (!empty($_FILES['file']['name'][0])) {
          $file_names = $_FILES['file']['name'];
          $file_tmps = $_FILES['file']['tmp_name'];
          $file_sizes = $_FILES['file']['size'];
          $file_errors = $_FILES['file']['error'];
          
          $upload_directory = "uploads/";
          
            // 파일을 저장하고자 하는 디렉토리가 존재하지 않으면 생성
          if (!file_exists($upload_directory)) {
            mkdir($upload_directory, 0755, true);
          }
          
            // 각 업로드된 파일 처리
          for ($i = 0; $i < count($file_names); $i++) {
            $file_name = $file_names[$i];
            $file_tmp = $file_tmps[$i];
            $file_size = $file_sizes[$i];
            $file_error = $file_errors[$i];
          
              // 파일 업로드 중 발생한 오류 확인
            if ($file_error === UPLOAD_ERR_OK) {
              // 허용된 파일 유형 확인
              $allowed_types = array('image/jpeg', 'image/png', 'image/gif');
              $file_type = mime_content_type($file_tmp);
              if (in_array($file_type, $allowed_types)) {
                // 충돌을 방지하기 위해 고유한 파일명 생성
                $unique_filename = uniqid() . '_' . $file_name;
                // 파일이 저장될 경로 설정
                $file_destination = $upload_directory . $unique_filename;
        
                  // 업로드된 파일을 목적지로 이동
                if (move_uploaded_file($file_tmp, $file_destination)) {
                    // 파일 경로를 데이터베이스에 저장
                  $updatefilepathsql = "INSERT INTO filepathTbl (path, RegProductTbl_idx) VALUES (?, ?)";
                  $stmt_updatefilepath = mysqli_prepare($dbconn, $updatefilepathsql);
                  mysqli_stmt_bind_param($stmt_updatefilepath, "si", $file_destination, $idx);
                  if (mysqli_stmt_execute($stmt_updatefilepath)) {
                    // 파일 정보 저장 성공
                    // 이곳에서 필요한 추가 작업을 수행할 수 있습니다.
                  } else {
                    // 파일 정보 저장 실패
                    $error_message = mysqli_error($dbconn);
                    echo "<script>alert('파일 정보를 저장하는 중에 오류가 발생하였습니다. 에러 메시지: " . $error_message . "'); history.back();</script>";
                    exit;
                  }
                  mysqli_stmt_close($stmt_updatefilepath);
                } else {
                  // 파일 이동 실패
                  echo "<script>alert('파일을 업로드하는 중에 오류가 발생하였습니다.'); history.back();</script>";
                  exit;
                }
              } else {
                // 허용되지 않은 파일 유형
                echo "<script>alert('올바른 파일 유형이 아닙니다.'); history.back();</script>";
                exit;
              }
            } else {
              // 파일 업로드 실패
              echo "<script>alert('파일을 업로드하는 중에 오류가 발생하였습니다.'); history.back();</script>";
              exit;
            }
          }
        }
        


        $updateCategorySql = "INSERT INTO CategoryTbl (name, RegProductTbl_idx1) VALUES (?, ?)";
        $stmt_updateCategory = mysqli_prepare($dbconn, $updateCategorySql);
        mysqli_stmt_bind_param($stmt_updateCategory, "si", $category, $idx);
        $result_updateCategory = mysqli_stmt_execute($stmt_updateCategory);
         if ($result_updateCategory) {
          $Category_idx = mysqli_insert_id($dbconn);
          if ($Category_idx) {
            $updateScategorySql = "INSERT INTO Scategorytbl (name, CategoryTbl_idx, RegProductTbl_idx) VALUES (?, ?, ?)";
            $stmt_updateScategory = mysqli_prepare($dbconn, $updateScategorySql);
            mysqli_stmt_bind_param($stmt_updateScategory, "sii", $scategory, $Category_idx, $idx);
            $result_updateScategory = mysqli_stmt_execute($stmt_updateScategory);
             if ($result_updateScategory) {
              mysqli_commit($dbconn);
              echo "<script>alert('판매글 등록이 완료되었습니다.'); location.href='product-ok.php';</script>";
            }
          }
        }  
      }        
    } else {
      mysqli_rollback($dbconn);
        echo "에러: 판매글 등록에 실패하였습니다.";
      }
    }
  }
  mysqli_autocommit($dbconn, true);

?>