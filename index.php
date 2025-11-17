<?php
include("header.php");
//require_once 'db.php'; // 連接資料庫
?>

<body>

 <div class="container py-5"><!--內容置中並有左右邊距 py表示上下padding有足夠垂直空間 -->
   <div class="row justify-content-center">  <!--建立一個橫列（row），並讓裡面的欄位置中對齊 -->

    <div class="col-md-6">

      <div class="card p-4 shadow-sm"> <!-- 加上微陰影 -->
        <h2 class="text-center mb-4">人才搜尋</h2>
    <!-- 人才搜尋頁面叫做search.php -->
        <form action="search.php" method="GET" class="input-group">
          <input type="search" name="q" class="form-control"
                 placeholder="搜尋具備技能、證照、作品..." />
          <button type="submit" class="btn btn-success">Search</button>
        </form>

      </div>

    </div>
  </div>
</div>

</body>
</html>



<?php
//mysqli_close($conn); // 關閉資料庫
include("footer.php");
?>