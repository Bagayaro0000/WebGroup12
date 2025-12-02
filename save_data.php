<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'db.php'; 

$table_name = $_POST['table'] ?? '';
$description = $_POST['description'] ?? ''; // 新增：讀取 description 欄位
$data_name = ''; // 用來儲存主要名稱的變數

// 1. 根據表格名稱取得數據和 SQL 模板
if ($table_name === 'competitions') {
    $data_name = $_POST['name'] ?? '';
    // competitions 表格欄位: name, description, status (假設 status 預設為 1)
    $sql = "INSERT INTO competitions (name, description, status) VALUES (?, ?, 1)";
    $types = "ss"; // 兩個字串 (string) 參數

} elseif ($table_name === 'licenses') {
    $data_name = $_POST['license_name'] ?? '';
    // licenses 表格欄位: license_name, description, status (假設 status 預設為 1)
    $sql = "INSERT INTO licenses (license_name, description, status) VALUES (?, ?, 1)";
    $types = "ss";

} elseif ($table_name === 'proficient_subjects') {
    $data_name = $_POST['proficient_subjects_name'] ?? '';
    // proficient_subjects 表格欄位: name, description, status (假設 status 預設為 1)
    $sql = "INSERT INTO proficient_subjects (name, description, status) VALUES (?, ?, 1)";
    $types = "ss";
    
} elseif ($table_name === 'programming_languages') {
    $data_name = $_POST['programming_languages_name'] ?? '';
    // programming_languages 表格欄位: name, description, status (假設 status 預設為 1)
    $sql = "INSERT INTO programming_languages (name, description, status) VALUES (?, ?, 1)";
    $types = "ss";
    
} else {
    // 處理未知表格或空值
    $_SESSION['error'] = "錯誤: 未知的資料類型。";
    $sql = null; // 確保 $sql 保持 null 或空，避免執行

}

// 2. 執行預處理語句
if ($sql && !empty($data_name)) {
    
    $stmt = $conn->prepare($sql);
    
    // 綁定參數：主要名稱欄位和描述欄位
    // 由於所有表格的 INSERT 語句都是兩個字串 (?)，所以可以通用綁定
    $stmt->bind_param($types, $data_name, $description);

    if ($stmt->execute()) {
        $_SESSION['message'] = "資料新增成功！表格: " . htmlspecialchars($table_name);
    } else {
        $_SESSION['error'] = "資料新增失敗：" . $stmt->error;
    }
    $stmt->close();

} elseif (empty($data_name) && $sql) {
    $_SESSION['error'] = "主要名稱欄位不能為空。";
}
// 處理完畢後，重定向回 CRUD 頁面 (假設是 CRUD.php)
header("Location: CRUD.php");
exit();
?>