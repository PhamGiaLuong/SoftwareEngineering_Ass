<?php include('header.php'); ?>



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
