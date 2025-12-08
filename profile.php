
<!-- 照片上傳功能！！整個設計我還在想啊！！ -->
<!-- 1201做好表格了，還有使用者創建資料、上傳照片的 -->

<div class="container my-5">
    
     <div class="row gy-4">    <!--建立一個橫列，gy-4 表示 row 內的欄位之間有垂直間距 -->

        <!-- 圖片區 -->
        <div class="col-md-4">
            <div class="card h-50">
                <div class="row g-0"><!--欄間距=0-->
                    <div>
                        <img src="https://lh3.googleusercontent.com/sitesv/AAzXCkfDJ34ZICVy0QXwOaahBYSVj8B5GQxwsI5kBuog0BRrBWRB2mTn1RJtdeT1XkCKnh-xQHs1SjpIkAi-c1MGQP6K7b8-xCqF2l41wyWwcEEynJcas5e63tsk2bt8mKyYzQ8wI5pWXJc3hpJWYGIk8gWLBnCirqfCmZ5gy1ATzO7k8_99LXn2zQSzIsQL8UPXzCyGeS7RZydhI07bDTZlWSOtXPYenw=w1280" class="img-fluid rounded-start" alt="Image">
                    </div>

                </div>
            </div>
        </div>

        <!-- 自我介紹區 -->
        <div class="col-md-8">
            <div class="card h-100">
                <div class="row g-0">
                    
                    <div>
                        <div class="card-body">
                            <h5 class="card-title">自我介紹</h5>

                            <form method="POST" action="#">
                                <div class="mb-3">
                                    <label class="form-label">姓名</label>
                                    <input type="text" class="form-control" name="name"><!--form-control 輸入框樣式  -->
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">學校</label>
                                    <input type="text" class="form-control" name="school">
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">系級</label>
                                    <input type="text" class="form-control" name="grade">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">手機號碼</label>
                                    <input type="text" class="form-control" name="phone">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">信箱</label>
                                    <input type="text" class="form-control" name="mail">
                                </div>

                                <button type="submit" class="btn btn-primary w-100">送出</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<?php
include("header.php");
session_start();

$conn = mysqli_connect("localhost", "root", "", "WebGroup12");

// 檢查是否已登入
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user_account = $_SESSION['user'];  // login.php 內存的是 account

// 使用 account 來查資料
$sql = "SELECT * FROM `user` WHERE account='$user_account'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    echo "找不到使用者資料！";
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>

    <link rel="stylesheet" href="custom.css">
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
            <!-- <div class="card h-50"> -->
                <div class="row g-0">
                    <div>
                        <img src="uploads/<?php echo $user['image'] ?? 'default.png'; ?>" 
                        alt="Profile Photo"
                        class="profile-photo">
                    </div>
                       <!-- 創建個人簡介按鈕，點了跳到pro_upload.php-->
                <a class="btn btn-success"
            href="pro_upload.php?id=<?php echo $row['id'] ?>">創建個人簡介</a> 
         </div>
                <!-- </div> -->
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
                                    <strong>Name</strong>
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


