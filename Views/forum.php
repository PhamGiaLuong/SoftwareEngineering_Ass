<?php include('header.php'); ?>
<div class="container mt-3 d-flex justify-content-center">
    <div class="col-6 d-flex flex-wrap justify-content-center rounded-5 p-3 border">
        <form action="#" method="POST">
            
            <div class="user-box">
                <input type="text" name="title" id="title" required>
                <label for="password">Tiêu đề</label>
            </div>
            <div class="user-box">
                <textarea id="form_content" name="content" placeholder="Nhập nội dung"></textarea>
                <label for="password">Tiêu đề</label>
            </div>
            <div class="col-12 d-flex flex-wrap justify-content-between mt-2">
                <div class="col-5 d-grid">
                    <button type="reset" class="btn btn-secondary">Nhập lại</button>
                </div>
                <div class="col-5 d-grid">
                    <button type="submit" class="btn btn-dark">Gửi</button>
                </div>

            </div>
        </form>
    </div>
</div>



<?php include('footer.php'); ?>