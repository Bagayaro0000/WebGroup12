<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once "header.php";
require_once "db.php"; // 資料庫連線

//獲取當前登入的帳號
$current_account = $_SESSION['account'] ?? null;

// 檢查是否登入
if (!$current_account) {
    // 如果未登入，強制跳轉到登入頁面
    $_SESSION['error'] = "請先登入才能查看資料。";
    header("Location: login.php");
    exit();
}

//status對應表
$status_map = [
    1 => '未審核',
    2 => '已審核', // 建議未來可以改成 '已通過'
    3 => '未通過'
];

function execute_account_query($conn, $table_name, $account) {
    // 資料隔離
    $sql = "SELECT id, name, description, status FROM `{$table_name}` WHERE account = ?";
    // 使用預備語句 (Prepared Statement) 增加安全性
    $stmt = $conn->prepare($sql);
    // 綁定當前登入的帳號參數
    $stmt->bind_param("s", $account);
    $stmt->execute();
    
    $result = $stmt->get_result();
    $data = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    
    $stmt->close();
    return $data;
}

// 擅長科目查詢
$proficient_subjects = execute_account_query($conn, 'proficient_subjects', $current_account);

// 程式語言查詢
$programming_languages = execute_account_query($conn, 'programming_languages', $current_account);

// 參與競賽查詢
$competitions = execute_account_query($conn, 'competitions', $current_account);

// 取得證照查詢
$licenses = execute_account_query($conn, 'licenses', $current_account);
?>

<div class="container" style="margin-top: 70px;">
    <div class="row gy-4">

        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success mt-3"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
        <?php endif; ?>

        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>擅長科目</span>
                    <a href="CRUD_insert.php?table=proficient_subjects" class="btn btn-primary">+</a> 
                    </div>
                <div class="card-body border border-2">
                    <?php if (empty($proficient_subjects)): ?>
                        <p class="text-center text-muted m-3">您尚未新增任何擅長科目資料。</p>
                    <?php else: ?>
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
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>程式語言</span>
                    <a href="CRUD_insert.php?table=programming_languages" class="btn btn-primary">+</a>
                </div>
                <div class="card-body border border-2">
                     <?php if (empty($programming_languages)): ?>
                        <p class="text-center text-muted m-3">您尚未新增任何程式語言資料。</p>
                    <?php else: ?>
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
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>參與競賽</span>
                    <a href="CRUD_insert.php?table=competitions" class="btn btn-primary">+</a>
                </div>
                <div class="card-body border border-2">
                    <?php if (empty($competitions)): ?>
                        <p class="text-center text-muted m-3">您尚未新增任何參與競賽資料。</p>
                    <?php else: ?>
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
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>取得證照</span>
                    <a href="CRUD_insert.php?table=licenses" class="btn btn-primary">+</a>
                </div>
                <div class="card-body border border-2">
                    <?php if (empty($licenses)): ?>
                        <p class="text-center text-muted m-3">您尚未新增任何取得證照資料。</p>
                    <?php else: ?>
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
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
</div>

<?php
include("footer.php");
?>