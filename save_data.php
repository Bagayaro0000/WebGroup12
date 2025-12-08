<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'db.php'; 

$table_name = $_POST['table'] ?? '';
$description = $_POST['description'] ?? '';

if ($table_name === 'competitions') {
    $data_name = $_POST['competitions_name'] ?? '';
    $sql = "INSERT INTO competitions (name, description, status) VALUES (?, ?, 1)";
    $types = "ss";

} elseif ($table_name === 'licenses') {
    $data_name = $_POST['license_name'] ?? '';
    $sql = "INSERT INTO licenses (name, description, status) VALUES (?, ?, 1)";
    $types = "ss";

} elseif ($table_name === 'proficient_subjects') {
    $data_name = $_POST['proficient_subjects_name'] ?? '';
    $sql = "INSERT INTO proficient_subjects (name, description, status) VALUES (?, ?, 1)";
    $types = "ss";
    
} elseif ($table_name === 'programming_languages') {
    $data_name = $_POST['programming_languages_name'] ?? '';
    $sql = "INSERT INTO programming_languages (name, description, status) VALUES (?, ?, 1)";
    $types = "ss";

} else {
    $_SESSION['error'] = "錯誤: 未知的資料類型。";
    header("Location: CRUD.php");
    exit();
}

if (!empty($data_name)) {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, $data_name, $description);

    if ($stmt->execute()) {
        $_SESSION['message'] = "資料新增成功！";
    } else {
        $_SESSION['error'] = "資料新增失敗：" . $stmt->error;
    }
    $stmt->close();

} else {
    $_SESSION['error'] = "主要名稱欄位不能為空。";
}

header("Location: CRUD.php");
exit();
