<?php
include("header.php");
include("db.php");
?>
<form method="get" action="CRUD_update.php">
    <label for="table_select">請選擇要編輯的資料類型:</label>
    <select name="table" id="table_select">
        <option value="">-- 請選擇 --</option>
        <option value="proficient_subjects">擅長科目</option>
        <option value="programming languages">程式語言</option>
        <option value="competitions">參與競賽</option>
        <option value="licenses">取得證照</option>
        </select>
    <button type="submit">更改</button>
</form>
<?php
$selected_table = $_GET['table'] ?? '';

if ($selected_table) {
    if ($selected_table === 'competitions') {
        // 顯示競賽專用的表單
        // 表單的 action 應該指向處理資料的檔案，例如 action="save_data.php"
        echo '<form action="save_data.php" method="post">';
        echo '<input type="hidden" name="table" value="competitions">';
        echo '競賽名稱: <input type="text" name="name"><br>';
        echo '<button type="submit">儲存</button>';
        echo '</form>';
        
    } elseif ($selected_table === 'licenses') {
        // 顯示證照專用的表單
        echo '<form action="save_data.php" method="post">';
        echo '<input type="hidden" name="table" value="licenses">';
        echo '證照名稱: <input type="text" name="license_name"><br>';
        echo '<button type="submit">儲存</button>';
        echo '</form>';
    }elseif ($selected_table === 'proficient_subjects') {
        // 顯示擅長科目的表單 
        echo '<form action="save_data.php" method="post">';
        echo '<input type="hidden" name="table" value="proficient_subjects">';
        echo '科目名稱: <input type="text" name="proficient_subjects_name"><br>';
        echo '<button type="submit">儲存</button>';
        echo '</form>';
    }elseif ($selected_table === 'programming languages') {
        // 顯示程式語言的表單 
        echo '<form action="save_data.php" method="post">';
        echo '<input type="hidden" name="table" value="programming languages">';
        echo '程式語言名稱: <input type="text" name="programming languages_name"><br>';
        echo '<button type="submit">儲存</button>';
        echo '</form>';
    }
}
?>
<?php
include("footer.php");
?>