<?php
include("header.php");
?>

<div class="container my-5">
    
     <div class="row gy-4">    <!--建立一個橫列，gy-4 表示 row 內的欄位之間有垂直間距 -->

        <!-- 圖片區 -->
        <div class="col-md-4">
            <div class="card h-50">
                <div class="row g-0"><!--欄間距=0-->
                    <div>
                        <img src="https://lh3.googleusercontent.com/sitesv/AAzXCkdVxyqK2gHw4Om1wpXUk7Rspsgrvrp7AJKRBG59ubvzGFnp3t9RV_t3wfwrWUpbrTEVa8bj942AzUgXeu3s5UdbMOg7quFmF57nvfOIJ95_y7Ujz1XCoeFG8-fteBN9w3LUhbURjgsL3WPxiS2bmAWhko9mW4DGJws66eGvHN7C7DUs6c6a9jjn7EPwq8_Q1HFQq_KPjq4EJY0jUaKpnMh7YgdqoA=w1280" class="img-fluid rounded-start" alt="Image">
                    </div>

                </div>
            </div>
        </div>

        <!-- 自我介紹區 -->
        <div class="col-md-8">
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
