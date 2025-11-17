<?php
include("header.php");
//require_once 'db.php'; // 連接資料庫
?>

<body>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6">

      <div class="card p-4 shadow-sm">
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