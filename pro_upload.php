<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "db.php"; // 資料庫連線PDO
include("header.php");


$user_account = $_SESSION['account'];
//讀取資料，在我的表格的placeholder會顯示
$sql2 = "SELECT email, description FROM user WHERE account=:account";
$stmt2= $pdo->prepare($sql2);
$stmt2->execute([':account'=>$user_account]);
$row = $stmt2->fetch();

//form <value>
$email = $row['email']??'';
$description = $row['description']??'';


if(isset($_POST['register']))
{
    $email = $_POST['email'];
    $description = $_POST['description'];

    // 如果有上傳圖片
    $image_name = $_FILES['my_image']['name'];
    $newfilename = "";

    if (!empty($image_name)) {
        $tmp = explode(".", $image_name);
        $newfilename = round(microtime(true)).'.'.end($tmp);
        $uploadspath = "uploads/".$newfilename;
        move_uploaded_file($_FILES['my_image']["tmp_name"], $uploadspath);
    }

    // 有上傳圖片>>更新 email, description, image
    try{
      if ($newfilename != "") {
        $sql = "UPDATE user 
                SET email = :email, description = :desc, image = :img
                WHERE account=:acc";
        $params=[
          ':email' => $email,
          ':desc'  => $description,
          ':img'   => $newfilename,
          ':acc'   => $user_account
        ];
      } else{
         $sql = "UPDATE user 
                SET email = :email, description = :desc
                WHERE account=:acc";
        $params=[
          ':email' => $email,
          ':desc'  => $description,
          ':acc'   => $user_account
        ];
      }
      $stmt = $pdo->prepare($sql);
      $success = $stmt->execute($params);

      if($success){
        echo"<script>alert('更新成功');
        window.location.href='profile.php';</script>";
        exit();
      }
    }catch(PDOException $e){
      echo "更新失敗：".$e->getMessage();
    }

  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>
    <form action="pro_upload.php" method="POST" enctype="multipart/form-data">
  <div class="container">
        <h2>upload your profile imformation on datedase.</h2>


    <!-- Email -->
    <div class="mb-3 row">
      <label for="_email" class="col-sm-2 col-form-label">Email</label>
      <div class="col-sm-10">
        <input type="email" name="email" class="form-control" id="_email"
               placeholder="電子信箱" value="<?=$email?>" required>
      </div>
    </div>

    <!-- Description -->
    <div class="mb-3 row">
      <label for="_description" class="col-sm-2 col-form-label">Description</label>
      <div class="col-sm-10">
        <textarea class="form-control" id="_description" name="description"
                  rows="5" required><?=$description?></textarea>
      </div>
    </div>

    <!-- File Upload -->
    <div class="mb-3 row">
      <label for="_image" class="col-sm-2 col-form-label">上傳圖片</label>
      <div class="col-sm-10">
        <input type="file" name="my_image" id="_image" class="form-control">
      </div>
    </div>

    <!-- Submit -->
    <input class="btn btn-success bold-text" type="submit" 
    name="register" value="更新" style="font-weight:bold;">

  </div>
</form>

    
</body>
</html>
<?php include("footer.php"); ?>
