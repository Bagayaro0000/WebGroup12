<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'db.php'; // 確保這裡是 PDO 連線

$table_name = $_POST['table'] ?? '';
$description = $_POST['description'] ?? '';
$current_account = $_SESSION['account'] ?? null; // 建議也把帳號存進去，確保資料歸屬

// 檢查是否登入
if (!$current_account) {
    $_SESSION['error'] = "請先登入。";
    header("Location: login.php");
    exit();
}

// 根據 table 決定對應的 POST 欄位名稱
$post_keys = [
    'competitions' => 'competitions_name',
    'licenses' => 'license_name',
    'proficient_subjects' => 'proficient_subjects_name',
    'programming_languages' => 'programming_languages_name'
];

if (array_key_exists($table_name, $post_keys)) {
    $data_name = $_POST[$post_keys[$table_name]] ?? '';
    // SQL 改寫：記得把 account 也存進去，這樣 CRUD.php 才看得到
    $sql = "INSERT INTO `$table_name` (name, description, status, account) VALUES (?, ?, 1, ?)";
} else {
    $_SESSION['error'] = "錯誤: 未知的資料類型。";
    header("Location: CRUD.php");
    exit();
}

if (!empty($data_name)) {
    try {
        // --- PDO 改寫開始 ---
        $stmt = $pdo->prepare($sql);
        // 執行時直接帶入陣列，順序要跟 SQL 的 ? 一致
        $success = $stmt->execute([$data_name, $description, $current_account]);

        if ($success) {
            $_SESSION['message'] = "資料新增成功！";
        } else {
            $_SESSION['error'] = "資料新增失敗。";
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "資料庫錯誤：" . $e->getMessage();
    }
} else {
    $_SESSION['error'] = "主要名稱欄位不能為空。";
}

header("Location: CRUD.php");
exit();