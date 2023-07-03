<?php
    include('./dbconn.php');
    $dbconn = dbconn();

    $product_id = $_GET['product_id'];

	$deleteScategorySql = "DELETE FROM Scategorytbl WHERE RegProductTbl_idx = ?";
	$stmt_deleteScategory = mysqli_prepare($dbconn, $deleteScategorySql);
	mysqli_stmt_bind_param($stmt_deleteScategory, "i", $product_id);
	$result_deleteScategory = mysqli_stmt_execute($stmt_deleteScategory);
	
	if ($result_deleteScategory) {
		$deleteCategorySql = "DELETE FROM CategoryTbl WHERE RegProductTbl_idx1 = ?";
		$stmt_deleteCategory = mysqli_prepare($dbconn, $deleteCategorySql);
		mysqli_stmt_bind_param($stmt_deleteCategory, "i", $product_id);
		$result_deleteCategory = mysqli_stmt_execute($stmt_deleteCategory);
		if ($result_deleteCategory) {
			$deleteFilepathSql = "DELETE FROM filepathTbl WHERE RegProductTbl_idx = ?";
			$stmt_deleteFilepath = mysqli_prepare($dbconn, $deleteFilepathSql);
			mysqli_stmt_bind_param($stmt_deleteFilepath, "i", $product_id);
			$result_deleteFilepath = mysqli_stmt_execute($stmt_deleteFilepath);
			
			if ($result_deleteFilepath) {
				$deleteRegProductSql = "DELETE FROM RegProductTbl WHERE idx = ?";
				$stmt_deleteRegProduct = mysqli_prepare($dbconn, $deleteRegProductSql);
				mysqli_stmt_bind_param($stmt_deleteRegProduct, "i", $product_id);
				$result_deleteRegProduct = mysqli_stmt_execute($stmt_deleteRegProduct);
				if ($result_deleteRegProduct) {
					echo "<script type='text/javascript'>alert('삭제되었습니다.'); window.location.href = '/index.php'; </script>";
				} else {
					mysqli_rollback($dbconn);
					echo "에러: 판매글 등록에 실패하였습니다.";
				}

			} else {
				mysqli_rollback($dbconn);
				echo "에러: 판매글 등록에 실패하였습니다.";
			}

		} else {
			mysqli_rollback($dbconn);
			echo "에러: 판매글 등록에 실패하였습니다.";
		}
	} else {
		mysqli_rollback($dbconn);
        echo "에러: 판매글 등록에 실패하였습니다.";
	}

?>
