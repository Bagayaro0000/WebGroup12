<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include("header.php");
require_once "db.php"; //PDO

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

    // 預設 status=1（未審核） //insert sql 修改成pdo
    $status = 1;
    $sql = "INSERT INTO `$table` (name, description, status, account) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    //按順序將參數放到execute陣列中
    if ($stmt->execute([$name, $description, $status, $current_account])) {
        $_SESSION['message'] = "新增成功！資料已綁定至帳號 {$current_account}。";

        // 引入剛才寫好的小工具
        require_once 'mail_helper.php';
    
        // 發信給管理員
        $adminEmail = "zhangzhixuan336@gmail.com";
        $studentName = $_SESSION['account'];
        $title = "新成果上傳通知：$studentName";
        $message = "管理員您好，學生 <b>$studentName</b> 剛剛上傳了新的成果作品，請前往後台審核。";
    
    sendSystemMail($adminEmail, $title, $message);

    } else {
        $_SESSION['error'] = "新增失敗：" . $stmt->error;
    }

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
<div class="simple-container">
    <form method="post" class="minimal-form">
        <h3 class="title">新增<?= $field_name ?></h3>
        
        <input type="hidden" name="table" value="<?= htmlspecialchars($selected_table) ?>">
        
        <label><?= $field_name ?></label>
        <input type="text" name="name" required>

        <label>簡述</label>
        <textarea name="description" rows="3"></textarea>
        
        <button type="submit">儲存</button>
    </form>
</div>

<style>
.simple-container {
    max-width: 400px;
    margin: 20px auto;
    font-family: sans-serif;
}

.minimal-form {
    padding: 20px;
    border: 1px solid #ddd; /* 淺灰色邊框 */
    border-radius: 8px;      /* 小圓角 */
    background: #f9f9f9;     /* 極淺灰底色 */
}

.title {
    margin: 0 0 15px 0;
    font-size: 1.2rem;
    color: #333;
}

label {
    display: block;
    margin-bottom: 5px;
    font-size: 0.9rem;
    color: #666;
}

input[type="text"], textarea {
    width: 100%;
    padding: 8px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;      /* 輸入框微圓角 */
    box-sizing: border-box;  /* 防止寬度溢出 */
}

button {
    width: 100%;
    padding: 10px;
    background: #333;        /* 深灰色按鈕 */
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

button:hover {
    background: #000;        /* 懸停時變黑 */
}
</style>
<?php endif; ?>

<?php include("footer.php"); ?>