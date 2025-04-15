<?php include('header.php'); ?>

<style>
  .booking-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 20px;
  }

  .booking-title {
    text-align: center;
    font-size: 30px;
    font-weight: bold;
    color: #000080;
    margin-bottom: 40px;
  }

  .room-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 40px 60px;
    justify-content: center;
  }

  .room-card {
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .room-item {
    display: flex;
    background: #f9f9f9;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  }

  .room-image-wrapper {
    width: 220px;
    height: 160px;
    flex-shrink: 0;
  }

  .room-image-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .room-details {
    padding: 10px 14px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    flex: 1;
  }

  .room-desc {
    font-size: 15px;
    color: #000;
    line-height: 1.4;
  }

  .room-btn {
    background-color: #000080;
    color: white;
    padding: 8px 18px;
    border-radius: 12px;
    font-size: 16px;
    text-decoration: none;
    margin-top: 12px;
    font-weight: 600;
    width: fit-content;
  }

  .room-name {
    text-align: center;
    margin-top: 10px;
    font-size: 18px;
    font-weight: bold;
    color: #000080;
  }

  .report-wrapper {
    display: flex;
    justify-content: flex-end;
    margin-top: 40px;
  }

  .report-btn {
    background-color: #000080;
    color: white;
    padding: 6px 16px;
    border-radius: 8px;
    font-size: 14px;
    text-decoration: none;
    font-weight: 500;
    cursor: pointer;
  }

  .popup-overlay {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0, 0, 0, 0.4);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 1000;
  }

  .popup-content {
    background: white;
    padding: 30px;
    border-radius: 16px;
    width: 500px;
    box-shadow: 0 0 10px rgba(0,0,0,0.3);
  }

  .popup-content h3 {
    text-align: center;
    color: #000080;
    margin-bottom: 20px;
  }

  .popup-content .row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 15px;
    gap: 10px;
  }

  .popup-content label {
    width: 30%;
    font-weight: bold;
  }

  .popup-content input, .popup-content select {
    flex: 1;
    padding: 6px;
    border-radius: 10px;
    border: 1px solid #ccc;
  }

  .popup-content textarea {
    width: 100%;
    padding: 6px;
    border-radius: 10px;
    border: 1px solid #ccc;
    min-height: 80px;
  }

  .btn-group {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 20px;
  }

  .btn-group button {
    padding: 6px 12px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
  }

  .btn-group .confirm {
    background-color: #000080;
    color: white;
  }

  @media (max-width: 1024px) {
    .room-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  @media (max-width: 768px) {
    .room-grid {
      grid-template-columns: 1fr;
    }

    .report-btn {
      margin-left: auto;
      margin-right: auto;
    }
  }
</style>

<div class="booking-container">
  <h2 class="booking-title">ĐẶT PHÒNG</h2>

  <div class="room-grid">

    <!-- Phòng cá nhân -->
    <div class="room-card">
      <div class="room-item">
        <div class="room-image-wrapper">
          <img src="/Se_Ass_Code/Images/canhan.jpg" alt="Phòng cá nhân">
        </div>
        <div class="room-details">
          <div class="room-desc">Không gian rộng với nhiều bàn học cá nhân</div>
          <a href="booking.php?action=book&type=personal" class="room-btn">Đặt phòng</a>
        </div>
      </div>
      <div class="room-name">Phòng tự học cá nhân</div>
    </div>

    <!-- Phòng học đôi -->
    <div class="room-card">
      <div class="room-item">
        <div class="room-image-wrapper">
          <img src="/Se_Ass_Code/Images/hainguoi.jpg" alt="Phòng học đôi">
        </div>
        <div class="room-details">
          <div class="room-desc">Không gian mở với các bàn đôi dành cho hai người</div>
          <a href="booking.php?action=book&type=double" class="room-btn">Đặt phòng</a>
        </div>
      </div>
      <div class="room-name">Phòng tự học đôi</div>
    </div>

    <!-- Phòng nhóm -->
    <div class="room-card">
      <div class="room-item">
        <div class="room-image-wrapper">
          <img src="/Se_Ass_Code/Images/nhom10.jpg" alt="Phòng nhóm 10 người">
        </div>
        <div class="room-details">
          <div class="room-desc">Gồm các phòng nhỏ, mỗi phòng có sức chứa tối đa 10 người</div>
          <a href="booking.php?action=book&type=group" class="room-btn">Đặt phòng</a>
        </div>
      </div>
      <div class="room-name">Phòng tự học 10 người</div>
    </div>

  </div>

  <div class="report-wrapper">
    <a href="#" class="report-btn" id="reportBtn">Gửi báo cáo</a>
  </div>

  <!-- Modal Đặt phòng -->
  <div id="bookingPopup" class="popup-overlay">
    <div class="popup-content">
      <h3>THÔNG TIN ĐẶT CHỖ</h3>

      <div class="row">
        <label>BKNetID</label>
        <input type="text" value="2211110" readonly>
      </div>
      <div class="row">
        <label>Họ và tên</label>
        <input type="text" value="Trần Văn A" readonly>
      </div>
      <div class="row">
        <label>Loại phòng</label>
        <select>
          <option>Phòng tự học - Tầng 1-H1</option>
          <option>Phòng tự học - Tầng 2-H2</option>
        </select>
      </div>
      <div class="row">
        <label>Trạng thái</label>
        <input type="text" value="Còn trống" readonly>
      </div>
      <div class="row">
        <label>Bắt đầu lúc</label>
        <input type="time" value="14:00">
      </div>
      <div class="row">
        <label>Kết thúc lúc</label>
        <input type="time" value="15:00">
      </div>

      <div class="btn-group">
        <button class="cancel" onclick="closeModal('bookingPopup')">Nhập lại</button>
        <button class="confirm">Xác nhận</button>
      </div>
    </div>
  </div>

  <!-- Modal Gửi báo cáo -->
  <div id="reportPopup" class="popup-overlay">
    <div class="popup-content">
      <h3>GỬI BÁO CÁO</h3>

      <div class="row">
        <label>BKNetID</label>
        <input type="text" value="2211110" readonly>
      </div>
      <div class="row">
        <label>Họ và tên</label>
        <input type="text" value="Trần Văn A" readonly>
      </div>
      <div class="row">
        <label>Loại phòng</label>
        <select>
          <option>Phòng tự học - Tầng 1-H1</option>
        </select>
      </div>
      <div class="row">
        <label>Vị trí</label>
        <input type="text" value="Ghế 16">
      </div>
      <div class="row">
        <label>Nội dung</label>
      </div>
      <textarea placeholder="Điều hòa phòng học bị hỏng"></textarea>

      <div class="btn-group">
        <button class="cancel" onclick="closeModal('reportPopup')">Nhập lại</button>
        <button class="confirm">Gửi</button>
      </div>
    </div>
  </div>

<script>
  const bookingPopup = document.getElementById("bookingPopup");
  const reportPopup = document.getElementById("reportPopup");
  const reportBtn = document.getElementById("reportBtn");

  // Xử lý sự kiện cho nút Đặt phòng
  document.querySelectorAll(".room-btn").forEach(btn => {
    btn.addEventListener("click", function (e) {
      e.preventDefault();
      bookingPopup.style.display = "flex";
    });
  });

  // Xử lý sự kiện cho nút Gửi báo cáo
  reportBtn.addEventListener("click", function (e) {
    e.preventDefault();
    reportPopup.style.display = "flex";
  });

  // Đóng popup khi click ra ngoài
  window.addEventListener("click", function (e) {
    if (e.target === bookingPopup) {
      bookingPopup.style.display = "none";
    }
    if (e.target === reportPopup) {
      reportPopup.style.display = "none";
    }
  });

  // Hàm đóng modal được chỉ định
  function closeModal(modalId) {
    document.getElementById(modalId).style.display = "none";
  }
</script>

<?php include('footer.php'); ?>
