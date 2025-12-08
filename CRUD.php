<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once "header.php";
require_once "db.php"; // 資料庫連線，變數 $conn 已經可用

// === 狀態對應表 ===
$status_map = [
    1 => '未審核',
    2 => '已審核',
    3 => '未通過'
];

// 擅長科目查詢
$subjects_table = 'proficient_subjects'; 
$sql1 = "SELECT id, name, description, status FROM `{$subjects_table}`";
$result1 = mysqli_query($conn, $sql1);
$proficient_subjects = $result1 ? mysqli_fetch_all($result1, MYSQLI_ASSOC) : [];
if ($result1) mysqli_free_result($result1);

// 程式語言查詢  
$programming_table = 'programming_languages';
$sql2 = "SELECT id, name, description, status FROM `{$programming_table}`";
$result2 = mysqli_query($conn, $sql2);
$programming_languages = $result2 ? mysqli_fetch_all($result2, MYSQLI_ASSOC) : [];
if ($result2) mysqli_free_result($result2);

// 參與競賽查詢  
$competitions_table = 'competitions';
$sql3 = "SELECT id, name, description, status FROM `{$competitions_table}`";
$result3 = mysqli_query($conn, $sql3);
$competitions = $result3 ? mysqli_fetch_all($result3, MYSQLI_ASSOC) : [];
if ($result3) mysqli_free_result($result3);

// 取得證照查詢  
$licenses_table = 'licenses';
$sql4 = "SELECT id, name, description, status FROM `{$licenses_table}`";
$result4 = mysqli_query($conn, $sql4);
$licenses = $result4 ? mysqli_fetch_all($result4, MYSQLI_ASSOC) : [];
if ($result4) mysqli_free_result($result4);
?>

<div class="container" style="margin-top: 70px;">
    <div class="row gy-4">

        <!-- Card 1: 擅長科目 -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>擅長科目</span>
                    <a href="CRUD_insert.php" class="btn btn-primary">+</a>
                </div>
                <div class="card-body border border-2">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>科目名稱</th>
                                <th>簡述</th>
                                <th>操作</th>
                                <th>狀態</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($proficient_subjects as $proficient_subject): ?>
                            <tr>
                                <td><?= $proficient_subject['id'] ?></td>
                                <td><?= htmlspecialchars($proficient_subject['name']) ?></td>
                                <td><?= htmlspecialchars($proficient_subject['description'] ?? '') ?></td>
                                <td>
                                    <a href="CRUD_update.php?table=proficient_subjects&id=<?= $proficient_subject['id'] ?>" class="btn btn-sm btn-warning">編輯</a>
                                    <a href="CRUD_delete.php?table=proficient_subjects&id=<?= $proficient_subject['id'] ?>" class="btn btn-sm btn-danger">刪除</a>
                                </td>
                                <td><?= $status_map[$proficient_subject['status']] ?? '未知狀態' ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Card 2: 程式語言 -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>程式語言</span>
                    <a href="CRUD_insert.php" class="btn btn-primary">+</a>
                </div>
                <div class="card-body border border-2">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>語言名稱</th>
                                <th>簡述</th>
                                <th>操作</th>
                                <th>狀態</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($programming_languages as $language): ?>
                            <tr>
                                <td><?= $language['id'] ?></td>
                                <td><?= htmlspecialchars($language['name']) ?></td>
                                <td><?= htmlspecialchars($language['description'] ?? '') ?></td>
                                <td>
                                    <a href="CRUD_update.php?table=programming_languages&id=<?= $language['id'] ?>" class="btn btn-sm btn-warning">編輯</a>
                                    <a href="CRUD_delete.php?table=programming_languages&id=<?= $language['id'] ?>" class="btn btn-sm btn-danger">刪除</a>
                                </td>
                                <td><?= $status_map[$language['status']] ?? '未知狀態' ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Card 3: 參與競賽 -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>參與競賽</span>
                    <a href="CRUD_insert.php" class="btn btn-primary">+</a>
                </div>
                <div class="card-body border border-2">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>競賽名稱</th>
                                <th>簡述</th>
                                <th>操作</th>
                                <th>狀態</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($competitions as $competition): ?>
                            <tr>
                                <td><?= $competition['id'] ?></td>
                                <td><?= htmlspecialchars($competition['name']) ?></td>
                                <td><?= htmlspecialchars($competition['description'] ?? '') ?></td>
                                <td>
                                    <a href="CRUD_update.php?table=competitions&id=<?= $competition['id'] ?>" class="btn btn-sm btn-warning">編輯</a>
                                    <a href="CRUD_delete.php?table=competitions&id=<?= $competition['id'] ?>" class="btn btn-sm btn-danger">刪除</a>
                                </td>
                                <td><?= $status_map[$competition['status']] ?? '未知狀態' ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Card 4: 取得證照 -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>取得證照</span>
                    <a href="CRUD_insert.php" class="btn btn-primary">+</a>
                </div>
                <div class="card-body border border-2">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>證照名稱</th>
                                <th>簡述</th>
                                <th>操作</th>
                                <th>狀態</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($licenses as $license): ?>
                            <tr>
                                <td><?= $license['id'] ?></td>
                                <td><?= htmlspecialchars($license['name']) ?></td>
                                <td><?= htmlspecialchars($license['description'] ?? '') ?></td>
                                <td>
                                    <a href="CRUD_update.php?table=licenses&id=<?= $license['id'] ?>" class="btn btn-sm btn-warning">編輯</a>
                                    <a href="CRUD_delete.php?table=licenses&id=<?= $license['id'] ?>" class="btn btn-sm btn-danger">刪除</a>
                                </td>
                                <td><?= $status_map[$license['status']] ?? '未知狀態' ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<?php
include("footer.php");
?>
