<?php
include("header.php");
?>

<div class="container my-5">
    
     <div class="row gy-4">    <!--建立一個橫列，gy-4 表示 row 內的欄位之間有垂直間距 -->

        <!-- 圖片區 -->
        <div class="col-md-6">
            <div class="card ">
                <div class="row g-0">
                    <div>
                        <img src="https://lh3.googleusercontent.com/sitesv/AAzXCkfF3zCHLxRGE1I_09erwoBv1S5gWEKpXYQH7mGboX4xChguWuJ02RF4sf3wgvgwxphSl7zGpVkoJwbfKvyr5fWhxLC_3Qabh2PWMlCbvWXzEQFP1vGM36K1jUe8AODVBy5J5yxFz7vMEvVowUgROAf-jXaWbxOhLUBXfhwLbVDPnUjGMj3W0nzXtfxa3W66milgSKqbaOn3tqpaRHpFtqa6q8NV2Q=w1280" class="img-fluid rounded-start" alt="Image">
                    </div>

                </div>
            </div>
        </div>

        <!-- 自我介紹區 -->
        <div class="col-md-6">
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
include("footer.php");
?>
