<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once "header.php";
require_once "db.php"; // 資料庫連線

//權限
if(!isset($_SESSION['account'])|| ($_SESSION['role']??'')!=='T'){
    echo "非管理員、老師身分，不得進入";
    exit();
}

//tables
$tables=[
    'proficient_subjects'=>'擅長科目',
    'programming_languages'=>'程式語言',
    'competitions'=>'競賽',
    'licenses'=>'證照'
];

//處理審查按鈕作業
if(isset($_GET['action'],$_GET['table'],$_GET['id'])){
    $action=$_GET['action'];//approve //reject
    $table=$_GET['table'];
    $id=(int)$_GET['id'];
    if(!array_key_exists($table,$tables)){
        die("error table");
    }
    if($action==='approve'){
        $status=2;
    }elseif($action==='reject'){
        $status=3;
    }else{
        die("error");
    }

    $sql="UPDATE `$table` SET status = ? WHERE id = ?";
    $stmt=$conn->prepare($sql);
    $stmt->bind_param("ii",$status,$id); //整數整數
    $stmt->execute();

    header("Location:teacher_backend.php");
    exit();
}

//未審核的成果
$data=[];

foreach($tables as $table=>$label){
    $sql = "SELECT id, account, name, description, status FROM `$table`
            WHERE status = 1";
    $result=$conn->query($sql);

    while ($row=$result->fetch_assoc()){
        $row['table']=$table;
        $row['type']=$label;
        $data[]=$row;
    }

}


?>


<div class="container my-5">
    <h2 class="mb-4">後台|成果審核</h2>

    <!-- 沒有審核資料 -->
     <?php if(empty($data)):?>
        <div class="alert alert-success">目前沒有待審核的成果</div>
     <?php else:?>

    <table class="table table-bordered align-middle">
         <thead class="table-light"> <!-- 灰色表頭 -->
        <tr>
            <th>學生帳號</th>
            <th>成果類型</th>
            <th>名稱</th>
            <th>說明</th>
            <th>審核</th>
        </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['account']) ?></td>
                <td><?= $row['type'] ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['description']) ?></td>
                <td>
                    <a class="btn btn-success btn-sm"
                       href="?action=approve&table=<?= $row['table'] ?>&id=<?= $row['id'] ?>">
                       通過
                    </a>

                    <a class="btn btn-danger btn-sm"
                       href="?action=reject&table=<?= $row['table'] ?>&id=<?= $row['id'] ?>">
                       不通過
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>