<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


include("header.php");
require_once "db.php";

// 檢查 GET 參數 id 和 table
if (isset($_GET['id']) && isset($_GET['table'])) {
    $id = $_GET['id'];
    $table = $_GET['table'];
    $allowed_tables = ['proficient_subjects', 'programming_languages', 'competitions', 'licenses'];

    if (!is_numeric($id) || !in_array($table, $allowed_tables)) {
        $_SESSION['error'] = "無效的修改請求";
        header("Location: CRUD.php");
        exit();
    }

    // 取出該筆資料
    $stmt = $conn->prepare("SELECT * FROM `$table` WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $record = $result->fetch_assoc();
    $stmt->close();

    if (!$record) {
        $_SESSION['error'] = "找不到該筆資料";
        header("Location: CRUD.php");
        exit();
    }

} else {
    $_SESSION['error'] = "缺少 ID 或資料表";
    header("Location: CRUD.php");
    exit();
}

// 表單送出時更新資料
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 依表格不同取得對應欄位
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';

    $stmt = $conn->prepare("UPDATE `$table` SET name=?, description=? WHERE id=?");
    //向資料庫發送 SQL 語句， SET name=?, description=? 指定要更新的欄位
    $stmt->bind_param("ssi", $name, $description, $id);
    //ssi 對應的是$name,$description,$id，資料表中內容替換掉?的部分
    if ($stmt->execute()) {
        $_SESSION['message'] = "資料修改成功！";
        $stmt->close();
        $conn->close();
        header("Location: CRUD.php");
        exit();
    } else {
        $_SESSION['error'] = "修改失敗：" . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>修改資料</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3>修改資料</h3>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">名稱</label>
            <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($record['name']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">簡述</label>
            <textarea class="form-control" name="description" rows="6"><?= htmlspecialchars($record['description'] ?? '') ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">確認修改</button>
        <a href="CRUD.php" class="btn btn-secondary">返回</a>
    </form>
</div>
</body>
</html>
