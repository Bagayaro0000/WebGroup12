<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$title = $title ?? "成果認證展示系統";
function nav_active($file) {
  $current = basename($_SERVER['PHP_SELF']);
  return $current === $file ? ' active' : '';
}
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!--讓網頁在行動裝置上能正確縮放與顯示-->
  <title><?=$title?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="custom.css?v=1" />
</head>
<body class="bg-light">
   <nav class="navbar navbar-expand-lg custom-bg"><!--建立一個大型裝置可展開的導覽列 -->
    <div class="container">
      <a class="navbar-brand" href="index.php">成果認證展示系統</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
     </button> <!--漢堡選單 -->

      <div class="collapse navbar-collapse" id="navbarNav">
         <ul class="navbar-nav me-auto mb-2 mb-lg-0"><!--me-auto：左側導覽連結:個人資料、學習成果、人才搜尋-->
          <li class="nav-item">
            <a class="nav-link<?=nav_active('profile.php')?>" href="profile.php">個人資料</a>
          </li>
          <!-- 改檔名 -->
          <li class="nav-item"> 
            <a class="nav-link<?=nav_active('CRUD.php')?>" href="CRUD.php">學習成果</a>
          </li>
          <!-- 改檔名 -->
          <li class="nav-item">
            <a class="nav-link<?=nav_active('search.php')?>" href="search.php">人才搜尋</a>
          </li>
          
        </ul>

         <ul class="navbar-nav ms-auto mb-2 mb-lg-0"> <!--ms-auto：右側導覽連結:個人資料、登入/登出-->
            <li class="nav-item">
              <a class="nav-link" href="user_update.php">個人資料</a>
            </li>
          <?php if (isset($_SESSION['account'])): ?>  <!--確保跟login的account一樣 -->
            <li class="nav-item">
            <!-- 做成假的nav-link不能點，為了'姓名+您好'對齊登出字樣-->
            <a class="nav-link disabled text-white"> 
            <?= htmlspecialchars($_SESSION['name']) ?> 您好
            </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="logout.php">登出</a> 
            </li>
          <?php else: ?>
            <li class="nav-item">
              <a class="nav-link<?=nav_active('login.php')?>" href="login.php">登入</a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>

