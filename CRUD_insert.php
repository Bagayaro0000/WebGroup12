<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include("header.php");
require_once "db.php"; 

$selected_table = $_GET['table'] ?? '';//將 $_GET['table'] 變數的值賦給 $selected_table

//表單送出處理
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

    // 獲取當前登入的帳號
    $current_account = $_SESSION['account'] ?? null; 
    
    // 檢查使用者是否登入
    if (!$current_account) {
        $_SESSION['error'] = "請先登入才能新增或編輯資料！";
        header("Location: login.php");
        exit();
    }

    // 預設 status=1（未審核）
    $status = 1;
    $stmt = $conn->prepare("INSERT INTO `$table` (name, description, status, account) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $name, $description, $status, $current_account);

    if ($stmt->execute()) {
        $_SESSION['message'] = "新增成功！資料已綁定至帳號 {$current_account}。";
    } else {
        $_SESSION['error'] = "新增失敗：" . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    header("Location: CRUD.php");
    exit();
}
?>

<?php 
$selected_table = $_GET['table'] ?? ''; // 讀取 URL 參數
if ($selected_table): 
?>
<form method="post">
<input type="hidden" name="table" value="<?= htmlspecialchars($selected_table) ?>">
    </form>
<?php endif; ?>

<!--依資料類型生成新增表單-->
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
