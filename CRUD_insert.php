<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include("header.php");
require_once "db.php"; 
?>
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
<?php
$selected_table = $_GET['table'] ?? '';

if ($selected_table) {
$form_start = '<form action="save_data.php" method="post">';
$form_hidden = '<input type="hidden" name="table" value="' . htmlspecialchars($selected_table) . '">';
$form_end = '<br>簡述: <textarea name="description" rows="3" cols="30"></textarea><br><button type="submit">儲存</button></form>';

    if ($selected_table === 'competitions') {
        echo $form_start . $form_hidden;
        echo '競賽名稱: <input type="text" name="name" required>'; // 使用 name
        echo $form_end;
        
    } elseif ($selected_table === 'licenses') {
        echo $form_start . $form_hidden;
        echo '證照名稱: <input type="text" name="license_name" required>'; // 使用 license_name
        echo $form_end;
        
    } elseif ($selected_table === 'proficient_subjects') {
        echo $form_start . $form_hidden;
        echo '科目名稱: <input type="text" name="proficient_subjects_name" required>'; // 使用 proficient_subjects_name
        echo $form_end;
        
    } elseif ($selected_table === 'programming_languages') { 
        echo $form_start . $form_hidden;
        echo '程式語言名稱: <input type="text" name="programming_languages_name" required>'; // 使用 programming_languages_name
        echo $form_end;
    } else {
        echo '<p>請選擇有效的資料類型。</p>';
    }
}
?>
<?php
include("footer.php");
?>