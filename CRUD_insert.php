<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include("header.php");
require_once "db.php"; 

$selected_table = $_GET['table'] ?? '';

// --- 表單送出處理 ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $table = $_POST['table'] ?? '';
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    
    $allowed_tables = ['proficient_subjects','programming_languages','competitions','licenses'];
    if (!in_array($table, $allowed_tables)) {
        $_SESSION['error'] = "無效的資料表";
        header("Location: CRUD.php");
        exit();
    }

    // 預設 status=1（未審核）
    $status = 1;

    $stmt = $conn->prepare("INSERT INTO `$table` (name, description, status) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $name, $description, $status);

    if ($stmt->execute()) {
        $_SESSION['message'] = "新增成功！";
    } else {
        $_SESSION['error'] = "新增失敗：" . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    header("Location: CRUD.php");
    exit();
}
?>

<!-- --- 選擇資料類型表單 --- -->
<?php if (!$selected_table): ?>
<form method="get" action="CRUD_insert.php">
    <label for="table_select">請選擇要新增的資料類型:</label>
    <select name="table" id="table_select">
        <option value="">-- 請選擇 --</option>
        <option value="proficient_subjects">擅長科目</option>
        <option value="programming_languages">程式語言</option>
        <option value="competitions">參與競賽</option>
        <option value="licenses">取得證照</option>
    </select>
    <button type="submit">新增</button>
</form>
<?php endif; ?>

<!-- --- 依資料類型生成新增表單 --- -->
<?php if ($selected_table): 
    $field_name = '';
    switch($selected_table) {
        case 'competitions': $field_name = '競賽名稱'; break;
        case 'licenses': $field_name = '證照名稱'; break;
        case 'proficient_subjects': $field_name = '科目名稱'; break;
        case 'programming_languages': $field_name = '程式語言名稱'; break;
        default: $field_name = '名稱'; break;
    }
?>
<form method="post">
    <input type="hidden" name="table" value="<?= htmlspecialchars($selected_table) ?>">
    <?= $field_name ?>: <input type="text" name="name" required><br>
    簡述: <textarea name="description" rows="3" cols="30"></textarea><br>
    <button type="submit">儲存</button>
</form>
<?php endif; ?>

<?php include("footer.php"); ?>
