<?php
session_start(); 
include("header.php");


require_once "db.php"; // 請確認這個檔案裡有 mysqli_connect()

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user = $_POST['user'] ?? '';
    $pass = $_POST['pass'] ?? '';

    // 避免sql injection
    $user = mysqli_real_escape_string($conn, $user);
    $pass = mysqli_real_escape_string($conn, $pass);

    // 查詢資料庫帳號密碼
    $sql = "SELECT * FROM user WHERE account='$user' AND password='$pass' ";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        // 存
        $_SESSION['user'] = $row['account']; 
        $_SESSION['name'] = $row['name'];
        $_SESSION['role'] = $row['role'];

        // 記錄導回頁面
        if (isset($_SESSION['redirect_to'])) {
            $redirect = $_SESSION['redirect_to'];
            unset($_SESSION['redirect_to']); 
            header("Location: $redirect");
            exit;
        }

        header("Location: index.php");
        exit;
    } else {
        $error = "帳號或密碼錯誤！";
    }
}
?>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container my-5">
  <div class="card p-4 mx-auto shadow" style="max-width: 400px;">
    <h3 class="mb-3 text-center">登入系統</h3>

    <?php if (!empty($error)): ?>
      <div class="alert alert-danger text-center"><?= $error ?></div>
    <?php endif; ?>

    <form method="post">
      <div class="mb-3">
        <label class="form-label">帳號</label>
        <input type="text" name="user" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">密碼</label>
        <input type="password" name="pass" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-success w-100">登入</button>
    </form>
  </div>
</div>

</body>
</html>
