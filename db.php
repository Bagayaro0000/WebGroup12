<?php
$servername = "localhost:3308";
$dbname = "WebGroup12";
$dbUsername = "root";
$dbPassword = "";

try {
    // 1. 建立 DSN (Data Source Name) 字串
    $dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8mb4";
    
    // 2. 建立 PDO 實例
    $pdo = new PDO($dsn, $dbUsername, $dbPassword);
    
    // 3. 設定錯誤模式為 Exception (例外)
    // 這行很重要，能讓你在出錯時看到具體的錯誤原因
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // 4. 設定預設的存取模式為關聯陣列
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // echo "資料庫連線成功！"; // 測試用，成功後可註解掉
} catch (PDOException $e) {
    // 如果連線失敗，捕捉錯誤訊息
    die("資料庫連線失敗: " . $e->getMessage());
}
?>
<!-- 以上genmini寫的 -->
<!-- ______________ -->

<!-- 所有連接資料庫的檔案都要改成PDO -->
<!-- 已改： -->
<!-- login.php -->
<!-- profile.php -->
<!-- pro_upload.php -->
<!-- CRUD.php -->
<!-- CRUD_update.php -->
<!-- CRUD_insert.php -->
<!-- CRUD_delete.php -->
<!-- save_data.php -->