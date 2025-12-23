<?php
// CRUD_deleted.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


include("header.php");
require_once "db.php"; //pdo

// 確認 GET 參數 id 和 table 是否存在
if (isset($_GET['id']) && isset($_GET['table'])) { //確認GEt請求中是否同時包含id和table
    $table = $_GET['table'];
    $allowed_tables = ['proficient_subjects', 'programming_languages', 'competitions', 'licenses'];

    if (!in_array($table, $allowed_tables)) {
        $_SESSION['error'] = "無效的資料表";
        header("Location: CRUD.php"); 
        exit();
    }

    $id = $_GET['id'];
    if (!is_numeric($id)) {
        $_SESSION['error'] = "無效的刪除 ID";
        header("Location: CRUD.php"); 
        exit();
    }
    //affected_rows 的 PDO 對等寫法是 rowCount()
    // 使用預處理語句刪除
    $stmt = $pdo->prepare("DELETE FROM `$table` WHERE id = ?");
    $stmt->execute([$id]);

    //rowCount()檢查受影響的列述
    if ($stmt->execute()) {
        if ($stmt->rowCount() > 0) { //檢查刪除操作影響的行數是否大於 0
            $_SESSION['message'] = "ID {$id} 刪除成功！";
        } else {
            $_SESSION['error'] = "找不到 ID {$id}，刪除失敗。";
        }
    } 


    // 刪除後回到CRUD.php頁
    header("Location: CRUD.php"); 
    exit();

} else {
    $_SESSION['error'] = "無效的刪除請求：缺少 ID 或資料表。";
    header("Location: CRUD.php"); // 改成你想回去的頁面
    exit();
}
?>