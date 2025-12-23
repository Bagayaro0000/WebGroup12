
<!-- 照片上傳功能！！整個設計我還在想啊！！ -->
<!-- 1201做好表格了，還有使用者創建資料、上傳照片的 -->


<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once "db.php"; // 資料庫連線PDO

// 檢查是否已登入
if (!isset($_SESSION['account'])) {
    header("Location: login.php");
    exit();
}

$user_account = $_SESSION['account'];  // login.php 內存的是 account

// 使用 account 來查資料，改成PDO
$sql = "SELECT * FROM `user` WHERE account=:account";
$stmt = $pdo->prepare($sql);
$stmt->execute([':account' => $user_account]);
$user = $stmt->fetch();

if (!$user) {
    echo "找不到使用者資料！";
    exit();
}
include("header.php");

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link rel="stylesheet" href="custom.css">

    <!-- 照片樣式 -->
    <style> 
    .profile-photo {
    width: 170px;
    height: 170px;
    object-fit: cover;
    border-radius: 50%;
    border: 3px solid #fff;
    display: block;
    margin: 10px auto;
    box-shadow: 0 3px 15px rgba(0,0,0,0.2);
    }
    </style>

</head>

<body>
<div class="container my-5">

    <div class="row gy-4">

        <!-- left side -->
         <div class="col-md-3">
          
                <div class="row g-0">
                    <div>
                        <img src="uploads/<?php echo $user['image'] ?? 'default.png'; ?>" 
                        alt="Profile Photo"
                        class="profile-photo">
                    </div>
                    <!-- 創建個人簡介按鈕，點了跳到pro_upload.php-->
                <a class="btn btn-success"
                href="pro_upload.php?id=<?php echo $user['account'] ?>">創建與更新</a> 
                </div>
               
            </div>
         

         <!-- right side -->
        <div class="col-md-9">
            <div class="card h-100">
                <div class="row g-0">
                    <div>
                        <div class="card-body">
                            <h2 class="card-title mb-4">個人簡介</h2>

                            <ul class="list-group list-group-flush fs-5">

                                <li class="list-group-item d-flex justify-content-between">
                                    <strong>姓名</strong>
                                    <span><?php echo $user['name']; ?></span>
                                </li>

                                <li class="list-group-item d-flex justify-content-between">
                                    <strong>Email</strong>
                                    <span><?php echo $user['email']?? '未填寫'; ?></span>
                                </li>

                                <li class="list-group-item d-flex justify-content-between">
                                    <strong>Description</strong>
                                    <span><?php echo $user['description'] ?? '未填寫'; ?></span>
                                </li>

                            </ul>
                            

                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>



</div>

    




</body>
</html>

<?php include("footer.php"); ?>