<?php
include("header.php");
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = mysqli_connect("localhost","root","","WebGroup12");

$user_account = $_SESSION['user'];

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

    // 有上傳圖片 → 更新 email, description, image
    if ($newfilename != "") {
        $sql = "UPDATE user 
                SET email = '$email',description = '$description',image = '$newfilename'
                WHERE account='$user_account'";
    } 
    // 沒上傳圖片 → 不更新 image
    else {
        $sql = "UPDATE user SET email = '$email',description = '$description'
                WHERE account='$user_account'";
    }

    $data = mysqli_query($conn, $sql);

    if($data){
        echo "<script>alert('更新成功');</script>";
    } else {
        echo mysqli_error($conn);
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
    <h2>upload your profile imformation on datedase.</h2>
    <div>
        <form action="pro_upload.php" method="POST" enctype="multipart/form-data">
            <!-- <div>
            <label>Name</label>
            <input type="text" name="name">
            </div>
            <br><br> -->

            <div>
            <label>Email</label>
            <input type="email" name="email">
            </div>
            <br><br>

            <div>
            <label>Description</label>
            <input type="description" name="description">
            </div>
            <br><br>

            <div>
            <input type="file" name="my_image">
            </div>

            <br><br>
        
            <div>
            <input type="submit" name="register" value="register">
            </div>

        </form>
    </div>
    
</body>
</html>
<?php include("footer.php"); ?>
