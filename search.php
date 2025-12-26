<?php
require_once 'db.php'; //連結資料庫

//根據接收到的關鍵字存取在allResults中
try {
    $keyword = $_GET['keyword'] ?? '';
    $allResults = [];
    //篩選出如果沒有在index搜尋任何關鍵字就會從資料庫中抓取全部status=2的資料一併顯示出來
    // $searchCond = "";//設定空白標籤
    $params = [];//空籃子
    $cond = ""; 
    if ($keyword !== '') {//篩選如果keyword為空白會維持searchTerm空白，反之則繼續根據搜尋條件去找資料
        $searchTerm = "%$keyword%";// $searchCond = " AND (account LIKE :kw OR name LIKE :kw OR description LIKE :kw)";
        $params = [':kw' => $searchTerm];  //把關鍵字裝進空籃子
        // 這裡的 'LABEL' 之後會在 SQL 中被替換成各表的類別名稱
        $cond = " AND (account LIKE :kw OR name LIKE :kw OR description LIKE :kw OR 'LABEL' LIKE :kw)";
    }   //先設定說要去資料庫找關鍵字(kw暫時是空位的代號之後可以讓資訊填入)

//將四個資料表union起來這樣可以在搜尋關鍵字時一次去裡面找，
//searchCond是有點像是判斷有沒有輸入值，有輸入則會執行AND..LIKE的部分，沒有輸入則會只要篩選STATUS=2的就都會出來
$sql = "
        SELECT account AS 姓名, name AS 資料名稱, description AS 簡述, status AS 狀態, '擅長科目' AS 來源類別 FROM proficient_subjects 
        WHERE status = 2 " . str_replace("'LABEL'", "'擅長科目'", $cond) . "
        
        UNION ALL
        SELECT account AS 姓名, name AS 資料名稱, description AS 簡述, status AS 狀態, '程式語言' AS 來源類別 FROM programming_languages
        WHERE status = 2 " . str_replace("'LABEL'", "'程式語言'", $cond) . "
       
        UNION ALL
        SELECT account AS 姓名, name AS 資料名稱, description AS 簡述, status AS 狀態, '參與競賽' AS 來源類別 FROM competitions
        WHERE status = 2 " . str_replace("'LABEL'", "'參與競賽'", $cond) . "
        
        UNION ALL
        SELECT account AS 姓名, name AS 資料名稱, description AS 簡述, status AS 狀態, '取得證照' AS 來源類別 FROM licenses
        WHERE status = 2 " . str_replace("'LABEL'", "'取得證照'", $cond) . "
    ";
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, true); // 允許重複使用 :kw 參數
    $stmt = $pdo->prepare($sql); //預備去抓資料庫內容
    $stmt->execute($params); //關鍵字去對應KW的空格
    $allResults = $stmt->fetchAll(PDO::FETCH_ASSOC); //去資料庫抓完的資料全部轉成陣列印到HTML裡

} catch (PDOException $e) {
    die("搜尋出錯了: " . $e->getMessage());
}


include("header.php"); 
?>

<style>
    #search-wrap { max-width: 1100px; margin: 30px auto; font-family: "Microsoft JhengHei", sans-serif; }
    
    .btn-back {
        display: inline-block;
        padding: 8px 18px;
        background-color: #62836f;
        color: white !important;
        text-decoration: none;
        border-radius: 20px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .table-round-container {
        border: 1px solid #ddd;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    #search-wrap table { width: 100%; border-collapse: collapse; background: white; margin: 0; }
    
    #search-wrap th { 
        background-color: #62836f; 
        color: white; 
        padding: 15px; 
        text-align: left; 
    }

    #search-wrap td { padding: 15px; border-bottom: 1px solid #eee; color: #444; }
    #search-wrap tr:last-child td { border-bottom: none; }
    #search-wrap tr:hover { background-color: #f9f9f9; }
    
    .status-ok { color: #62836f; font-weight: bold; }
    .no-result { text-align: center; padding: 40px; color: #999; }
</style>

<div id="search-wrap">
    <a href="index.php" class="btn-back">返回搜尋首頁</a>
    
    <h2 style="color: #333; border-left: 5px solid #62836f; padding-left: 10px;">
        <?php echo ($keyword !== '') ? "搜尋結果" : "人才資料總覽"; ?><!--如果有關鍵字顯示搜尋結果，無則人才搜尋總覽 -->
    </h2>
    
    <p style="color: #666; margin-bottom: 20px;">
        <?php if ($keyword !== ''): ?>
            關鍵字：<strong><?php echo htmlspecialchars($keyword); ?></strong>，共找到 <?php echo count($allResults); ?> 筆資料
        <?php else: ?>
             目前顯示所有已審核的人才資料，共 <?php echo count($allResults); ?> 筆<!--無關鍵字者會去計算總共有多少個資料  -->
        <?php endif; ?>
    </p>

    <div class="table-round-container">
        <table>
            <thead>
                <tr>
                    <th>姓名</th>
                    <th>類別</th>
                    <th>資料名稱</th>
                    <th>簡述</th>
                    <th>審核狀態</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($allResults) > 0): ?>
                    <?php foreach ($allResults as $row): ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($row['姓名']); ?></strong></td>
                        <td><?php echo htmlspecialchars($row['來源類別']); ?></td>
                        <td><?php echo htmlspecialchars($row['資料名稱']); ?></td>
                        <td><?php echo htmlspecialchars($row['簡述']); ?></td>
                        <td><span class="status-ok">已審核</span></td>
                        <!-- 因為以篩選只有狀態為已審核者才能顯示所以直接固定是已審核字樣  -->
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="no-result">目前暫無人才資料。</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php 
include("footer.php"); 
?>