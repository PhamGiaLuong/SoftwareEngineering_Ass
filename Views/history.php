<?php 
include('header.php'); 

// Giả lập dữ liệu lịch sử đặt chỗ
$reservation_history = [
    [
        'id' => '1123',
        'date' => '29/3/2025',
        'name' => 'Phòng học nhóm số 1',
        'address' => 'H1-401',
        'start_time' => '08:00',
        'end_time' => '10:00',
        'status' => 'Hoàn tất',
        'report' => [ 
            [
                'date' => "29/3/2025 9:30",
                'content' => 'á bê cê',
                'status' => 'Đã xử lý'
            ],
            [
                'date' => "29/3/2025 9:45",
                'content' => 'đố rê min',
                'status' => 'Đã xử lý'
            ]       
        ]
    ],
    [
        'id' => '1153',
        'date' => '31/3/2025',
        'name' => 'Phòng tự học số 1',
        'address' => 'H1-113',
        'start_time' => '09:00',
        'end_time' => '11:00',
        'status' => 'Đã hủy',
        'report' => [
        ]
    ],
    [
        'id' => '1204',
        'date' => '1/4/2025',
        'name' => 'Phòng tự học số 2',
        'address' => 'H6-115',
        'start_time' => '13:00',
        'end_time' => '15:00',
        'status' => 'Hoàn tất',
        'report' => [
            [
                'date' => "1/4/2025 13:30",
                'content' => 'á bê cê',
                'status' => 'Đã xử lý'
            ]
        ]
    ],
    [
        'id' => '1268',
        'date' => '3/4/2025',
        'name' => 'Phòng tự học số 2',
        'address' => 'H6-115',
        'start_time' => '10:00',
        'end_time' => '14:00',
        'status' => 'Hoàn tất',
        'report' => [
        ]
    ],
    [
        'id' => '1312',
        'date' => '5/4/2025',
        'name' => 'Phòng tự học số 1',
        'address' => 'H1-113',
        'start_time' => '13:00',
        'end_time' => '15:00',
        'status' => 'Hoàn tất',
        'report' => [
            [
                'date' => "1/4/2025 13:30",
                'content' => 'á bê cê',
                'status' => 'Chưa xử lý'
            ]
        ]
    ]
];
?>

<div class="container mt-3 d-flex flex-wrap justify-content-center">
    <div class="d-flex justify-content-center col-12 mb-3">
        <h2>LỊCH SỬ ĐẶT PHÒNG</h2>
    </div>

    <div class="col-12 d-flex flex-wrap justify-content-md-end justify-content-between gap-3 mb-2">
        <div class="d-grid col-5 col-md-3">
            <!-- Button trigger modal -->
            <a type="button" class="btn btn-main" href="/SE_Ass_Code/index.php?url=booking">
                Đặt phòng mới
            </a>
        </div>
    </div>
    <div class="overflow-x-auto">
    <table class="table table-bordered text-center">
        <thead class="table-dark custom-thead">
            <tr>
                <th>Mã đặt phòng</th>
                <th>Thời gian</th>
                <th style="width: 20%;">Phòng</th>
                <th>Vị trí</th>
                <th>Giờ bắt đầu</th>
                <th>Giờ kết thúc</th>
                <th>Trạng thái</th>
                <th>Báo cáo</th>
            </tr>
        </thead>
        <tbody id="reservationHistoryBody">
            <?php if (!empty($reservation_history)): ?>
                <?php foreach ($reservation_history as $reservation): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($reservation['id']); ?></td>
                        <td><?php echo htmlspecialchars($reservation['date']); ?></td>
                        <td class="text-start"><?php echo htmlspecialchars($reservation['name']); ?></td>
                        <td><?php echo htmlspecialchars($reservation['address']); ?></td>
                        <td><?php echo htmlspecialchars($reservation['start_time']); ?></td>
                        <td><?php echo htmlspecialchars($reservation['end_time']); ?></td>
                        <td><?php echo htmlspecialchars($reservation['status']); ?></td>
                        <td onclick="toggleReplies(<?= $reservation['id']; ?>)" style="color: #030391;">
                            <?php echo htmlspecialchars(count($reservation['report'])); ?>
                        </td>
                    </tr>

                    <tr id="details-<?= $reservation['id']; ?>" class="collapse">
                        <td colspan="8">
                            <table class="table mb-0">
                                <thead class="table-secondary">
                                    <tr>
                                        <th style="width: 20%;">Thời gian</th>
                                        <th class="text-start" style="width: 80%;">Nội dung</th>
                                        <th style="width: 20%;">Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($reservation['report'] as $report): ?>
                                        <tr>
                                            <td><?= $report['date']; ?></td>
                                            <td class="text-start"><?= $report['content']; ?></td>
                                            <td><?= $report['status']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">Không tìm thấy lịch sử đặt chỗ</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    </div>
</div>

<!-- <script src="../assets/js/reservation_history.js"></script> -->

<?php include('footer.php'); ?>
