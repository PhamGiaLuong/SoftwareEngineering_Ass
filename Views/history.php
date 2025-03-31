<?php 
include('header.php'); 

// Giả lập dữ liệu lịch sử đặt chỗ
$reservation_history = [
    [
        'date' => '2025-03-29',
        'space' => 'Phòng học nhóm A101',
        'start_time' => '08:00',
        'end_time' => '10:00',
        'status' => 'Đặt phòng'
    ],
    [
        'date' => '2025-03-30',
        'space' => 'Phòng tự học B202',
        'start_time' => '13:00',
        'end_time' => '15:00',
        'status' => 'Gửi báo cáo'
    ],
    [
        'date' => '2025-03-31',
        'space' => 'Thư viện tầng 3',
        'start_time' => '09:00',
        'end_time' => '11:00',
        'status' => 'Đặt phòng'
    ]
];
?>

<div class="container mt-4">
    <h2 class="mb-3">Lịch sử đặt chỗ</h2>

    <table class="table table-bordered text-center">
        <thead class="table-dark">
            <tr>
                <th>Ngày</th>
                <th>Không gian</th>
                <th>Giờ bắt đầu</th>
                <th>Giờ kết thúc</th>
                <th>Hành động</th>
                <th>Tùy chọn</th>
            </tr>
        </thead>
        <tbody id="reservationHistoryBody">
            <?php if (!empty($reservation_history)): ?>
                <?php foreach ($reservation_history as $reservation): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($reservation['date']); ?></td>
                        <td><?php echo htmlspecialchars($reservation['space']); ?></td>
                        <td><?php echo htmlspecialchars($reservation['start_time']); ?></td>
                        <td><?php echo htmlspecialchars($reservation['end_time']); ?></td>
                        <td><?php echo htmlspecialchars($reservation['status']); ?></td>
                        <td>
                            <button class="btn btn-danger">Hủy</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">Không có lịch sử đặt chỗ</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="../assets/js/reservation_history.js"></script>

<?php include('footer.php'); ?>
