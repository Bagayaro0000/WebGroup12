<?php
// CRUD_deleted.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


include("header.php");
require_once "db.php";

// 確認 GET 參數 id 和 table 是否存在
if (isset($_GET['id']) && isset($_GET['table'])) {

    $table = $_GET['table'];
    $allowed_tables = ['proficient_subjects', 'programming_languages', 'competitions', 'licenses'];

    if (!in_array($table, $allowed_tables)) {
        $_SESSION['error'] = "無效的資料表";
        header("Location: CRUD.php"); // 或原頁
        exit();
    }

    $id = $_GET['id'];
    if (!is_numeric($id)) {
        $_SESSION['error'] = "無效的刪除 ID";
        header("Location: CRUD.php"); // 或原頁
        exit();
    }

    // 使用預處理語句刪除
    $stmt = $conn->prepare("DELETE FROM `$table` WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $_SESSION['message'] = "ID {$id} 刪除成功！";
        } else {
            $_SESSION['error'] = "找不到 ID {$id}，刪除失敗。";
        }
    } else {
        $_SESSION['error'] = "刪除失敗：" . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    // 刪除後回到原頁或指定頁
    header("Location: CRUD.php"); // 改成你想回去的頁面
    exit();

} else {
    $_SESSION['error'] = "無效的刪除請求：缺少 ID 或資料表。";
    header("Location: CRUD.php"); // 改成你想回去的頁面
    exit();
}
?>
