<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once "header.php";
require_once "db.php"; // 資料庫連線，變數 $conn 已經可用

$subjects_table = 'proficient_subjects'; 
$sql = "SELECT id, name, description, status FROM `{$subjects_table}`";
$result = mysqli_query($conn, $sql);
if ($result) {
    // 獲取所有行，並設定為關聯陣列 (MYSQLI_ASSOC)
    $proficient_subjects = mysqli_fetch_all($result, MYSQLI_ASSOC);
    
    // 釋放結果集佔用的記憶體
    mysqli_free_result($result);
} else {
    // 查詢失敗時，設定為空陣列以避免 foreach 警告
    $proficient_subjects = [];
}
?>

<div class="container" style="margin-top: 70px;">

    <div class="row gy-4">

        <!-- Card 1 -->
        <div class="col-md-6"><!--  區塊佔據頁面橫向尺寸，總共12格  -->
            <div class="card h-100 "><!--card元件建立，高度會塞滿 -->
                <div class="card-header d-flex justify-content-between align-items-center">
                    <!-- flex使span標題靠左  justify-content-between 中間會自動分開-->
                    <span>擅長科目</span>
                    <a id="擅長科目新增" href="CRUD_insert.php" class="btn btn-primary">+</a>
                </div>
            
                 <div class="card-body border border-2"><!--新增表格邊界 -->
                     <table class="table mb-0"><!-- margin-bottom表示表格底部不留空隙-->
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
                                <td><?=$proficient_subject['id'] ?></td>
                                <td><?= htmlspecialchars($proficient_subject['name']) ?></td>
                                <td><?= htmlspecialchars($proficient_subject['description'] ?? '') ?></td>
                                <td>
                                    <a href="CRUD_update.php?id=<?= $proficient_subject['id'] ?>" class="btn btn-sm btn-warning">編輯</a>
                                    <a href="CRUD_delete.php?id=<?= $proficient_subject['id'] ?>"class="btn btn-sm btn-danger">刪除 </a>
                                </td>
                               <td><?= htmlspecialchars($proficient_subject['status'] ?? '') ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>程式語言</span>
                    <a id="程式語言新增" href="CRUD_insert.php" class="btn btn-primary">+</a>
                </div>
                <div class="card-body border border-2">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>語言名稱</th>
                                <th>簡述</th>
                                <th>操作</th>
                                <th>狀態</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>睡覺</td>
                                <td>睡飽吃、吃飽睡</td>
                                <td>
                                    <a  id="程式語言編輯" href="CRUD_update.php" class="btn btn-sm btn-warning">修改</a>
                                    <a  id="程式語言刪除" href="CRUD_delete.php" class="btn btn-sm btn-danger">刪除</a>
                                </td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>參與競賽</span>
                    <a id="參與競賽新增" href="CRUD_insert.php" class="btn btn-primary">+</a>
                </div>
                <div class="card-body border border-2">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>競賽名稱</th>
                                <th>簡述</th>
                                <th>操作</th>
                                <th>狀態</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>睡覺</td>
                                <td>睡飽吃、吃飽睡</td>
                                <td>
                                    <a  id="參與競賽編輯" href="CRUD_update.php" class="btn btn-sm btn-warning">修改</a>
                                    <a  id="參與競賽刪除" href="CRUD_delete.php" class="btn btn-sm btn-danger">刪除</a>
                                </td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>取得證照</span>
                    <a id="取得證照新增" href="CRUD_insert.php" class="btn btn-primary">+</a>
                </div>
                <div class="card-body border border-2">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>證照名稱</th>
                                <th>簡述</th>
                                <th>操作</th>
                                <th>狀態</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>睡覺</td>
                                <td>睡飽吃、吃飽睡</td>
                                <td>
                                    <a  id="取得證照編輯" href="CRUD_update.php" class="btn btn-sm btn-warning">修改</a>
                                    <a  id="取得證照刪除" href="CRUD_delete.php" class="btn btn-sm btn-danger">刪除</a>
                                </td>
                                <td></td>
                            </tr>
                            
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
