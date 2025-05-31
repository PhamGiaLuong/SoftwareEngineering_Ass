// GIA LUONG-------------------------------------------------------------------------------


function showToast() {
    const toastLive = document.getElementById('liveToast')
    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLive)
        toastBootstrap.show()
}

// Kiểm tra 2 password có giống nhau không (tab resetPassword)
function validatePassword(event) {
    let password = document.getElementById("password").value;
    let confirmPassword = document.getElementById("confirmPassword").value;
    let errorMessage = document.getElementById("error-message");

    if (password !== confirmPassword) {
        errorMessage.innerHTML = "Mật khẩu không khớp!";
        errorMessage.classList.remove("d-none");
        if (event) event.preventDefault(); 
        return false; // Ngăn form submit
    } else {
        errorMessage.classList.add("d-none");
        return true; // Cho phép submit
    }
}

// Hiển thị lựa chọn cho pop-up đặt phòng roomBooking
const radios = document.querySelectorAll('input[name="roomType"]');
// const selfRoom = document.getElementById('selfRoomSelect');
const dualRoom = document.getElementById('dualRoomSelect');
const groupRoom = document.getElementById('groupRoomSelect');
radios.forEach(radio => {
    radio.addEventListener('change', () => {
        if (radio.value === "self") {
            selfRoom.classList.remove('d-none');
            dualRoom.classList.add('d-none');
            groupRoom.classList.add('d-none');
        } else if (radio.value === "dual") {
            dualRoom.classList.remove('d-none');
            // selfRoom.classList.add('d-none');
            groupRoom.classList.add('d-none');
        } else if (radio.value === "group") {
            groupRoom.classList.remove('d-none');
            // selfRoom.classList.add('d-none');
            dualRoom.classList.add('d-none');
        }
    });
});

// Hiển thị lựa chọn cho pop-up edit roomBooking
const radiosEdit = document.querySelectorAll('input[name="typeEdit"]');
const selfRoomEdit = document.getElementById('selfRoomEditSelect');
const dualRoomEdit = document.getElementById('dualRoomEditSelect');
const groupRoomEdit = document.getElementById('groupRoomEditSelect');
radiosEdit.forEach(radio => {
    radio.addEventListener('change', () => {
        if (radio.value === "self") {
            selfRoomEdit.classList.remove('d-none');
            dualRoomEdit.classList.add('d-none');
            groupRoomEdit.classList.add('d-none');
        } else if (radio.value === "dual") {
            dualRoomEdit.classList.remove('d-none');
            selfRoomEdit.classList.add('d-none');
            groupRoomEdit.classList.add('d-none');
        } else if (radio.value === "group") {
            groupRoomEdit.classList.remove('d-none');
            selfRoomEdit.classList.add('d-none');
            dualRoomEdit.classList.add('d-none');
        }
    });
});

// Hiển thị alert nếu có
function showAlertMessage(message, type) {
    let alertBox;
    let alertContent;
    if (type == "success") {
        alertBox = document.getElementById("successAlert");
        alertContent = document.getElementById("successContent");
    } else {
        alertBox = document.getElementById("errorAlert");
        alertContent = document.getElementById("errorContent");
    }

    alertContent.textContent = message;  // Cập nhật nội dung
    alertBox.classList.remove("d-none");

    // Tự động ẩn sau 3 giây (3000ms)
    setTimeout(() => {
        alertBox.classList.add("d-none");
    }, 5000);
}


document.addEventListener("DOMContentLoaded", function () {
    const postForm = document.getElementById("addNewPostForm");
    const replyForm = document.getElementById("addNewReplyForm");
    const selfStudyForm = document.getElementById("selfStudyBookingForm");
    const roomForm = document.getElementById("roomBookingForm");
    const cancelBookingForm = document.getElementById("cancelBookingForm");
    const reportBookingForm = document.getElementById("reportBookingForm");
    const editBookingForm = document.getElementById("editBookingForm");
    const topicSelect = document.getElementById("forumTopicFilter");
    const genNote = document.getElementById("generalNoteBox");
    const bookingHistory = document.getElementById("bookingHistoryBody");
    const todayBooking = document.getElementById("todayBookingBody");
    const toastBox = document.getElementById("toastBox");

    if (toastBox) {
        const toastBox = document.getElementById("toastBox");
        fetch(`/SE_Ass_Code/index.php?url=booking/getUserReminders/${currentUserID}`)
            .then(response => response.json())
            .then(data => {     
                if (data.error) {
                    showAlertMessage(data.error, "error");
                    return;
                }
                toastBox.innerHTML = "";
                if (data.reminderCount > 0) {
                    data.remindersList.forEach(rmd => {
    
                        const toast = document.createElement("div");
                        toast.className = "toast mb-3";
                        toast.id = "liveToast";
                        toast.setAttribute("role", "alert");
                        toast.setAttribute("aria-live", "assertive");
                        toast.setAttribute("aria-atomic", "true");
                        toast.setAttribute("data-bs-delay", "10000"); // Tự đóng sau 10s
    
                        toast.innerHTML = `
                            <div class="toast-header">
                                <img src="/SE_Ass_Code/Images/S3MRS_logo.png" class="rounded me-2" alt="S3MRS_logo" width="30px">
                                <strong class="me-auto">Lịch đặt phòng: ${rmd.booking_id}</strong>
                                <small>${rmd.diff > 0 ? `${rmd.diff} phút nữa` : `${Math.abs(rmd.diff)} phút trước`}</small>
                                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                        `;
                        if (rmd.diff >= -10) {
                            toast.innerHTML += `
                                <div class="toast-body">
                                    <p class="m-1">Bạn có lịch đặt phòng ở 
                                        <strong>${rmd.room.address}${rmd.seat_number ? " - Ghế " + rmd.seat_number : ""}</strong> vào lúc <strong>${rmd.time_start}</strong>
                                    </p>
                                    ${rmd.diff > 0
                                        ? '<p class="m-1">Hãy chuẩn bị sẵn sàng nhận phòng nhé!</p>'
                                        : '<p class="m-1">Hãy nhanh chóng nhận phòng trước <strong>'+ (10 + rmd.diff) +"</strong> phút nữa</p>"
                                    }
                                    <p class="m-1">Lịch đặt sẽ bị hủy nếu trễ quá 10 phút.</p>
                                </div>
                            `;
                        } else {
                            toast.innerHTML += `
                                <div class="toast-body">
                                    <p class="m-1">Lịch đặt phòng của bạn ở 
                                        <strong>${rmd.room.address}${rmd.seat_number ? " - Ghế " + rmd.seat_number : ""}</strong> vào lúc <strong>${rmd.time_start}</strong>
                                    </p>
                                    <strong class="m-1">Đã bị hệ thống hủy do quá hạn 10 phút.</strong>
                                </div>
                            `;
                        }
                        toastBox.appendChild(toast);
                    });
                    showToast(); // Hiển thị toast
                }
            })
            .catch(error => console.error("Lỗi:", error));
    }

    // Kiểm tra và xử lý sự kiện cho form tạo bài viết
    if (postForm) {
        postForm.addEventListener("submit", function (event) {
            event.preventDefault();
            let formData = new FormData(this);
            document.querySelector(".modal .btn-close").click();
            postForm.reset();

            fetch("/SE_Ass_Code/index.php?url=forum/addNewPost", {
                method: "POST",
                body: formData,
            })
                .then(response => response.json())
                .then(data => {
                    if (data.info) {
                        table.innerHTML = `<tr><td colspan="7" class="text-center">${data.info}</td></tr>`;
                        return;
                    }
                    if (data.error) {
                        showAlertMessage(data.error, "error");
                        return;
                    }
                    if (data.success) {
                        showAlertMessage(data.success, "success");
                        fetchPosts("all");
                    }
                })
                .catch(error => console.error("Lỗi:", error));
        });
    }

    // Kiểm tra và xử lý sự kiện cho form tạo phản hồi
    if (replyForm) {
        replyForm.addEventListener("submit", function (event) {
            event.preventDefault();
            let formData = new FormData(this);
            document.querySelector(".modal .btn-close").click();
            replyForm.reset();

            fetch("/SE_Ass_Code/index.php?url=forum/addNewReply", {
                method: "POST",
                body: formData,
            })
                .then(response => response.json())
                .then(data => {
                    if (data.info) {
                        table.innerHTML = `<tr><td colspan="7" class="text-center">${data.info}</td></tr>`;
                        return;
                    }
                    if (data.error) {
                        showAlertMessage(data.error, "error");
                        return;
                    }
                    if (data.success) {
                        showAlertMessage(data.success, "success");
                    }
                    if (data.author && data.reply) {
                        let element = createReplyBox(data.reply, data.author);
                        document.getElementById("postReplies").appendChild(element);
                    }
                })
                .catch(error => console.error("Lỗi:", error));
        });
    }

    function createReplyBox(reply, author) {
        const roles = {
            student: "Sinh viên",
            teacher: "Giảng viên",
            staff: "Quản lý",
            admin: "Quản trị viên"
        };
    
        // Tạo thẻ chứa toàn bộ nội dung
        const container = document.createElement("div");
        container.className = "col-11 border border-2 rounded-3 p-2 fade-in visible";
    
        // Avatar + Info
        const infoWrapper = document.createElement("div");
        infoWrapper.className = "col-12 d-flex";
    
        const avatar = document.createElement("div");
        avatar.className = "col-12 rounded-circle overflow-hidden border";
        avatar.style.width = "50px";
        avatar.style.height = "50px";
        avatar.style.background = `url('${author.image}') center/cover no-repeat`;
    
        const infoContent = document.createElement("div");
        infoContent.className = "col-10 px-3";
    
        const nameP = document.createElement("p");
        nameP.className = "m-0";
    
        const nameLink = document.createElement("a");
        if (reply.author === currentUserID) {
            nameLink.href = "/SE_Ass_Code/index.php?url=account";
        } else {
            const id = (author.role === "admin" || author.role === "staff")
                ? author.id
                : author.BKNetID;
            nameLink.href = `/SE_Ass_Code/index.php?url=account/otherInfo/${id}`;
        }
    
        const nameStrong = document.createElement("strong");
        nameStrong.textContent = author.name;
    
        const roleTag = document.createElement("i");
        roleTag.className = "opacity-50 fs-6";
        roleTag.textContent = " " + (roles[author.role] || "Không xác định");
    
        nameLink.appendChild(nameStrong);
        nameP.appendChild(nameLink);
        nameP.appendChild(roleTag);
    
        const timeTag = document.createElement("small");
        timeTag.className = "m-0 opacity-50";
        timeTag.textContent = reply.time;
    
        infoContent.appendChild(nameP);
        infoContent.appendChild(timeTag);
    
        infoWrapper.appendChild(avatar);
        infoWrapper.appendChild(infoContent);
    
        // Nội dung reply
        const replyContent = document.createElement("div");
        replyContent.className = "col-11 col-md-12 ms-3 ps-5";
        replyContent.innerHTML = reply.content;
    
        // Gắn vào container chính
        container.appendChild(infoWrapper);
        container.appendChild(replyContent);
    
        return container;
    }
    

    let currentTopic = 'all'; // Lưu topic hiện tại
     
    // Kiểm tra và xử lý bộ lọc topic
    if (topicSelect) {
        fetchPosts(currentTopic); // Tải bài viết ngay khi trang mở
        topicSelect.addEventListener("change", function() {
            currentTopic = this.value;
            fetchPosts(this.value);
        });
    }
    
   
    document.querySelectorAll('.topic-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const postId = this.dataset.postId;
            const topic = this.dataset.topic;
            toggleReplies(postId);
            fetchPosts(topic);
        });
    });

    // Chọn tất cả các phần tử có class "fade-in"
    const fadeIns = document.querySelectorAll(".fade-in");
    // Hàm xử lý khi cuộn trang
    function handleScroll() {
        fadeIns.forEach((element) => {
            const rect = element.getBoundingClientRect();
            if (rect.top < window.innerHeight && rect.bottom >= 0) {
                element.classList.add("visible");
            }
        });
    }
    // Lắng nghe sự kiện cuộn trang
    window.addEventListener("scroll", handleScroll);
    // Gọi một lần khi trang tải để kiểm tra các phần tử đã có sẵn trong viewport
    handleScroll();

    // Lấy danh sách thông báo chung
    if (genNote) {
        getGenNote();
    }
    // Lấy lịch sử đặt phòng
    if (bookingHistory) {
        getBookingList();
    }
    // Lấy danh sách đặt phòng hôm nay
    if (todayBooking) {
        getTodayBookingList();
    }

    // Tab đặt phòng
    if (selfStudyForm) {
        // Lấy Thông tin đặt phòng tự học
        const roomSelect = document.querySelector("#room_id");
        const startTimeInput = document.querySelector("[name='start_time']");
        const endTimeInput = document.querySelector("[name='end_time']");
        // Lắng nghe khi người dùng thay đổi giá trị
        roomSelect.addEventListener("change", getAvailableSeat);
        startTimeInput.addEventListener("change", getAvailableSeat);
        endTimeInput.addEventListener("change", getAvailableSeat);

        getAvailableSeat();
        selfStudyForm.addEventListener("submit", function (event) {
            event.preventDefault();
            let formData = new FormData(this);
            document.querySelector(".modal .btn-close").click();
            selfStudyForm.reset();
            
            fetch("/SE_Ass_Code/index.php?url=booking/bookSelfStudySeat", {
                method: "POST",
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    showAlertMessage(data.error, "error");
                    return;
                }
                if (data.success) {
                    showAlertMessage(data.success, "success");
                    getTodayBookingList();
                    return;
                }
            })
            .catch(error => console.error("Lỗi:", error));
        });
    }
    if (roomForm) {
        // Lấy Thông tin đặt phòng học đôi/nhóm
        const room2DSelect = document.querySelector("[name='room2d_id'");
        const room2GSelect = document.querySelector("[name='room2g_id'");
        const type2Select = document.querySelector("[name='roomType'");
        const startTime2Input = document.querySelector("[name='start_room']");
        const endTime2Input = document.querySelector("[name='end_room']");
        // Lắng nghe khi người dùng thay đổi giá trị
        room2DSelect.addEventListener("change", getAvailableRoom);
        room2GSelect.addEventListener("change", getAvailableRoom);
        type2Select.addEventListener("change", getAvailableRoom);
        startTime2Input.addEventListener("change", getAvailableRoom);
        endTime2Input.addEventListener("change", getAvailableRoom);

        getAvailableRoom();
        roomForm.addEventListener("submit", function (event) {
            event.preventDefault();
            let formData = new FormData(this);
            document.querySelector("#roomBooking .btn-close").click();
            roomForm.reset();
            
            fetch("/SE_Ass_Code/index.php?url=booking/bookRoom", {
                method: "POST",
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    showAlertMessage(data.error, "error");
                    return;
                }
                if (data.success) {
                    showAlertMessage(data.success, "success");
                    getTodayBookingList();
                    return;
                }
            })
            .catch(error => console.error("Lỗi:", error));
        });
    }
    if (cancelBookingForm) {
        cancelBookingForm.addEventListener("submit", function (event) {
            event.preventDefault();
            let formData = new FormData(this);
            document.querySelector("#cancelBooking .btn-close").click();
            cancelBookingForm.reset();
            
            fetch("/SE_Ass_Code/index.php?url=booking/cancelBooking", {
                method: "POST",
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    showAlertMessage(data.error, "error");
                    return;
                }
                if (data.success) {
                    showAlertMessage(data.success, "success");
                    getTodayBookingList();
                    return;
                }
            })
            .catch(error => console.error("Lỗi:", error));
        });
    }
    if (reportBookingForm) {
        reportBookingForm.addEventListener("submit", function (event) {
            event.preventDefault();
            let formData = new FormData(this);
            document.querySelector("#bookingReport .btn-close").click();
            reportBookingForm.reset();console.error("reportBookingForm      ");
            
            fetch("/SE_Ass_Code/index.php?url=booking/reportBooking", {
                method: "POST",
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    showAlertMessage(data.error, "error");
                    return;
                }
                if (data.success) {
                    showAlertMessage(data.success, "success");
                    getTodayBookingList();
                    return;
                }
            })
            .catch(error => console.error("Lỗi:", error));
        });
    }
    if (editBookingForm) {
        const selfSelect = document.querySelector("[name='roomSEdit_id'");
        const dualSelect = document.querySelector("[name='roomDEdit_id'");
        const groupSelect = document.querySelector("[name='roomGEdit_id'");
        const typeEditSelect = document.querySelector("[name='typeEdit'");
        const startTime = document.querySelector("[name='startEdit']");
        const endTime = document.querySelector("[name='endEdit']");
        // Lắng nghe khi người dùng thay đổi giá trị
        selfSelect.addEventListener("change", getStatusForEditBooking);
        dualSelect.addEventListener("change", getStatusForEditBooking);
        groupSelect.addEventListener("change", getStatusForEditBooking);
        typeEditSelect.addEventListener("change", getStatusForEditBooking);
        startTime.addEventListener("change", getStatusForEditBooking);
        endTime.addEventListener("change", getStatusForEditBooking);

        getStatusForEditBooking();
        editBookingForm.addEventListener("submit", function (event) {
            event.preventDefault();
            let formData = new FormData(this);
            document.querySelector("#editBooking .btn-close").click();
            editBookingForm.reset();
            
            fetch("/SE_Ass_Code/index.php?url=booking/editBooking", {
                method: "POST",
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    showAlertMessage(data.error, "error");
                    return;
                }
                if (data.success) {
                    showAlertMessage(data.success, "success");
                    getTodayBookingList();
                    return;
                }
            })
            .catch(error => console.error("Lỗi:", error));
        });
    }
    const checkinForm = document.getElementById("checkinQRForm");
    if (checkinForm) {
        checkinForm.addEventListener("submit", function (event) {
            event.preventDefault();
            let formData = new FormData(this);
            document.querySelector('#checkinQRForm button[type="reset"]').click();
            checkinForm.reset();
            
            fetch("/SE_Ass_Code/index.php?url=booking/checkinBooking", {
                method: "POST",
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    showAlertMessage(data.error, "error");
                    return;
                }
                if (data.success) {
                    showAlertMessage(data.success, "success");
                    getTodayBookingList();
                    return;
                }
            })
            .catch(error => console.error("Lỗi:", error));

        })
    }

    const reportBox = document.getElementById("reportBox");
    if (reportBox) getUnsolvedReports();
});

// Lấy các báo cáo chưa được xử lý
function getUnsolvedReports() {
    const reportBox = document.getElementById("reportBox");
    fetch(`/SE_Ass_Code/index.php?url=home/getUnsolvedReports`)
        .then(response => response.json())
        .then(data => {
            reportBox.innerHTML = "";

            if (data.length === 0) {
                reportBox.innerHTML = `<div class="text-center m-2">Không có báo cáo cần giải quyết!</div>`;
                return;
            }

            const roles = {
                student: "Sinh viên",
                teacher: "Giảng viên",
                staff: "Quản lý",
                admin: "Quản trị viên"
            };

            data.forEach(rpt => {
                const isOwner = currentName === rpt.author.name;
                const authorURL = isOwner
                    ? "/SE_Ass_Code/index.php?url=account"
                    : `/SE_Ass_Code/index.php?url=account/otherInfo/${rpt.user_id}`;
                const seat = rpt.seat_number ? " - Ghế " + rpt.seat_number : "";

                reportBox.innerHTML += `
                    <div class="col-12 border border-bottom-2 p-2 fade-in visible">
                        <div class="col-12 d-flex">
                            <div class="col-12 rounded-circle overflow-hidden border"
                                 style="width: 50px; height: 50px; background: url('${rpt.author.image}') center/cover no-repeat;"></div>
                            <div class="col-10 px-3">
                                <p class="m-0">
                                    <a href="${authorURL}"><strong>${rpt.author.name}</strong></a>
                                    <i class="opacity-50 fs-6"> ${roles[rpt.author.role] || "Không xác định"}</i>
                                </p>
                                <small class="m-0 opacity-50">${rpt.created_at}</small>
                                <small class="m-0">${rpt.room.address} ${seat}</small>
                            </div>
                        </div>
                        <div class="col-11 ms-3 ps-5 mt-2 pe-2 d-flex flex-wrap justify-content-end">
                            <div class="col-12">${rpt.content}</div>
                            <button type="button" class="btn btn-warning" onclick="solveReport(${rpt.booking_id}, ${rpt.report_id}, 'denied')">Từ chối</button>
                            <button type="button" class="btn btn-primary" onclick="solveReport(${rpt.booking_id}, ${rpt.report_id}, 'solved')">Xử lý</button>
                        </div>
                    </div>
                `;
                console.error(rpt);
            });

        })
        .catch(error => {
            console.error("Lỗi khi tải dữ liệu:", error);
        });
}
// Xử lý báo cáo
function solveReport(bookingID, reportID, status) {
    fetch(`/SE_Ass_Code/index.php?url=home/updateBookingReportStatus`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            booking_id: bookingID,
            report_id: reportID,
            status: status,
            solver: currentUserID
        }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            showAlertMessage(data.error, "error");
            return;
        }
        if (data.success) {
            showAlertMessage(data.success, "success");
        }
        if (document.getElementById("reportBox")) getUnsolvedReports();
        if (document.getElementById("reportTableBody")) loadReports();
    })
    .catch(error => {
        console.error("Lỗi khi tải dữ liệu:", error);
    });

}

// Lấy danh sách thông báo chung
function getGenNote() {
    const genNote = document.getElementById("generalNoteBox");
    fetch(`/SE_Ass_Code/index.php?url=home/getGenNote`)
        .then(response => response.json())
        .then(data => {
            if (data.info) {
                genNote.innerHTML = `<div>${data.info}</div>`;
                return;
            }
            genNote.innerHTML = "";
            if (data.pinnedList.length > 0) {
                addNoteToHomepage(data.pinnedList, genNote);
            }
            if (data.noteList.length > 0) {
                addNoteToHomepage(data.noteList, genNote);
            }

        })
        .catch(error => {
            console.error("Lỗi khi tải dữ liệu:", error);
        });
}
// Thêm các thông báo vào html
function addNoteToHomepage(noteList, genNote) {
    const roleMap = {
        student: "Sinh viên",
        teacher: "Giảng viên",
        staff: "Quản lý",
        admin: "Quản trị viên"
    };
    noteList.forEach(noti => {
        const user = noti.author;
        let link;
        if (currentName !== undefined) {
            const isCurrentUser = (currentName === user.name);
            link = isCurrentUser 
                ? "/SE_Ass_Code/index.php?url=account"
                : `/SE_Ass_Code/index.php?url=account/otherInfo/${user.id}`;
        } else {
            link = "#";
        }

        const notiId = `noti-full-${noti.id}`;
        const pin = (noti.pin == true) ? `<i class="bi bi-pin-angle"></i>` : "";
        const edited = (noti.edit_at != false) 
            ? `<small class="m-0 opacity-50">${noti.edit_at}, edited</small>` 
            : `<small class="m-0 opacity-50">${noti.created_at}</small>`;

        const div = document.createElement("div");
        div.className = "col-12 border border-2 rounded-3 p-2 fade-in visible";
        div.innerHTML = `
            <div class="col-12 d-flex">
                <div class="col-12 rounded-circle overflow-hidden border"
                    style="width: 50px; height: 50px; background: url('${user.image}') center/cover no-repeat;">
                </div>
                <div class="col-10 px-3">
                    <p class="m-0">
                        <a href="${link}">
                            <strong>${user.name}</strong>
                        </a>
                        <i class="opacity-50 fs-6">${roleMap[user.role] || "Không xác định"}</i>
                        ${pin}
                    </p>
                    ${edited}
                </div>
            </div>
            <div class="col-11 col-md-12 ms-3 ps-5 pe-2 mt-2">
                <h4>${noti.title}</h4>
                <div class="collapse" id="${notiId}">
                    <p>${decodeHTML(noti.content)}</p>
                </div>
                <div class="col-11 d-flex justify-content-end mx-2">
                    <button class="btn btn-custom m-0 px-3 py-0"
                            data-bs-toggle="collapse"
                            data-bs-target="#${notiId}"
                            aria-expanded="false"
                            aria-controls="${notiId}">
                        <i class="bi bi-eye-fill fs-4"></i>
                    </button>
                </div>
            </div>
        `;
        genNote.appendChild(div);
    });
}
function decodeHTML(text) {
    const txt = document.createElement("textarea");
    txt.innerHTML = text;
    return txt.value;
}

function getStatusForEditBooking() {
    const stateBox = document.querySelector("#roomEditState");
    const typeSelect = document.querySelector("input[name='typeEdit']:checked").value;
    const startTime = document.querySelector("[name='startEdit']").value;
    const endTime = document.querySelector("[name='endEdit']").value;
    const submitBtn = document.getElementById('submitEditBtn');

    let roomID = document.querySelector("[name='roomSEdit_id']").value;
    if (typeSelect == "dual") roomID = document.querySelector("[name='roomDEdit_id']").value;
    else if (typeSelect == "group") roomID = document.querySelector("[name='roomGEdit_id']").value;

    if (roomID!="---" && roomID<200 && startTime && endTime) {
        fetch("/SE_Ass_Code/index.php?url=booking/getAvailableSeat", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                userID: currentUserID,
                room_id: roomID,
                start_time: startTime,  
                end_time: endTime,
            }),
        })
        .then(res => res.json())
        .then(data => {
            if (data.seat_number) {
                stateBox.value = `Số ghế: ${data.seat_number}`;
                document.querySelector("[name='seatNum']").value = data.seat_number;
                stateBox.classList.remove('bg-info-subtle');
                stateBox.classList.remove('bg-danger-subtle');
                stateBox.classList.add('bg-success-subtle');
                submitBtn.disabled = false;
            } else if (data.error) {
                stateBox.value = data.error;
                stateBox.classList.remove('bg-info-subtle');
                stateBox.classList.add('bg-danger-subtle');
                stateBox.classList.remove('bg-success-subtle');
                submitBtn.disabled = true;
            } else {
                stateBox.value = "Không xác định được!";
                submitBtn.disabled = true;
            }
        })
        .catch(err => {
            console.error("Lỗi khi tìm ghế:", err);
            stateBox.value = "Lỗi khi tìm ghế!";
        });
    } else if (roomID!="---" && startTime && endTime) {
        fetch("/SE_Ass_Code/index.php?url=booking/getAvailableRoom", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                userID: currentUserID,
                room_id: roomID,
                start_time: startTime,
                end_time: endTime,
            }),
        })
        .then(res => res.json())
        .then(data => {
            if (data.status == "yes") {
                stateBox.value = "Phòng còn trống...";
                document.querySelector("[name='seatNum']").value = null;
                stateBox.classList.remove('bg-info-subtle');
                stateBox.classList.remove('bg-danger-subtle');
                stateBox.classList.add('bg-success-subtle');
                submitBtn.disabled = false;
            } else if (data.status == "no") {
                stateBox.value = "Phòng đã được đặt!";
                stateBox.classList.remove('bg-info-subtle');
                stateBox.classList.add('bg-danger-subtle');
                stateBox.classList.remove('bg-success-subtle');
                submitBtn.disabled = true;
            } else {
                stateBox.value = "Không xác định được!";
            }
        })
        .catch(err => {
            console.error("Lỗi khi tìm ghế:", err);
            stateBox.value = "Lỗi khi tìm phòng!";
        });
    } else {
        
    }
}
// Lấy chỗ trống
function getAvailableSeat() {
    const seatInput = document.querySelector("#seat_number");
    const roomSelect = document.querySelector("#room_id");
    const startTimeInput = document.querySelector("[name='start_time']");
    const endTimeInput = document.querySelector("[name='end_time']");
    const submitBtn = document.getElementById('submitBtn1');
    
    const roomID = roomSelect.value;
    const startTime = startTimeInput.value;
    const endTime = endTimeInput.value;
    if (roomID!="---" && startTime && endTime) {
        fetch("/SE_Ass_Code/index.php?url=booking/getAvailableSeat", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                userID: currentUserID,
                room_id: roomID,
                start_time: startTime,
                end_time: endTime,
            }),
        })
        .then(res => res.json())
        .then(data => {
            if (data.seat_number) {
                seatInput.value = data.seat_number;
                seatInput.classList.remove('bg-info-subtle');
                seatInput.classList.remove('bg-danger-subtle');
                seatInput.classList.add('bg-success-subtle');
                submitBtn.disabled = false;
            } else if (data.error) {
                seatInput.value = data.error;
                seatInput.classList.remove('bg-info-subtle');
                seatInput.classList.add('bg-danger-subtle');
                seatInput.classList.remove('bg-success-subtle');
                submitBtn.disabled = true;
            } else {
                seatInput.value = "Không xác định được!";
                submitBtn.disabled = true;
            }
        })
        .catch(err => {
            console.error("Lỗi khi tìm ghế:", err);
            seatInput.value = "Lỗi khi tìm ghế!";
        });
    } else {
        seatInput.value = "Hãy điền đủ thông tin phía trên!";
        seatInput.classList.add('bg-info-subtle');
        seatInput.classList.remove('bg-danger-subtle');
        seatInput.classList.remove('bg-success-subtle');
    }
}
// Lấy phòng trống
function getAvailableRoom() {
    const status = document.querySelector("#roomState");
    const typeSelect = document.querySelector("input[name='roomType']:checked");
    const roomDSelect = document.querySelector("[name='room2d_id']");
    const roomGSelect = document.querySelector("[name='room2g_id']");
    const startTimeInput = document.querySelector("[name='start_room']");
    const endTimeInput = document.querySelector("[name='end_room']");
    const submitBtn = document.getElementById('submitBtn');
    
    let roomID = roomGSelect.value;
    if (typeSelect.value == "dual") roomID = roomDSelect.value;
    const startTime = startTimeInput.value;
    const endTime = endTimeInput.value;
    if (roomID!="---" && startTime && endTime) {
        fetch("/SE_Ass_Code/index.php?url=booking/getAvailableRoom", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                userID: currentUserID,
                room_id: roomID,
                start_time: startTime,
                end_time: endTime,
            }),
        })
        .then(res => res.json())
        .then(data => {
            if (data.status == "yes") {
                status.value = "Phòng còn trống...";
                status.classList.remove('bg-info-subtle');
                status.classList.remove('bg-danger-subtle');
                status.classList.add('bg-success-subtle');
                submitBtn.disabled = false;
            } else if (data.status == "no") {
                status.value = "Phòng đã được đặt!";
                status.classList.remove('bg-info-subtle');
                status.classList.add('bg-danger-subtle');
                status.classList.remove('bg-success-subtle');
                submitBtn.disabled = true;
            } else if (data.status == "locked") {
                status.value = "Tài khoản của bạn đã bị khóa, vui lòng liên hệ với quản trị viên để biết thêm thông tin!";
                status.classList.remove('bg-info-subtle');
                status.classList.add('bg-danger-subtle');
                status.classList.remove('bg-success-subtle');
                submitBtn.disabled = false;
            } else {
                status.value = "Không xác định được!";
            }
        })
        .catch(err => {
            console.error("Lỗi khi tìm ghế:", err);
            status.value = "Lỗi khi tìm phòng!";
        });
    } else {
        status.value = "Hãy điền đủ thông tin phía trên!";
        status.classList.add('bg-info-subtle');
        status.classList.remove('bg-danger-subtle');
        status.classList.remove('bg-success-subtle');
    }

}

// Lấy danh sách đặt phòng theo trang
function getBookingList(page = 1) {
    const bookingTable = document.getElementById("bookingHistoryBody");
    fetch(`/SE_Ass_Code/index.php?url=history/getMyBooking/${currentUserID}/${page}`)
        .then(response => response.json())
        .then(data => {
            bookingTable.innerHTML = ""; // Xóa danh sách cũ
            if (data.error) {
                bookingTable.innerHTML = `<tr><td colspan="9" class="text-center">${data.error}</td></tr>`;
                return;
            }
            if (data.bookingList) {
                data.bookingList.forEach(reservation => {
                    const {
                        booking_id,
                        user_id,
                        room_id,
                        seat_number,
                        time_start,
                        time_end,
                        created_at,
                        booking_date,
                        status,
                        report,
                        author,
                        room
                    } = reservation;
            
                    const reportCount = report.length;
                    const row = document.createElement("tr");
                    row.innerHTML = `
                        <td>${booking_id}</td>
                        <td class="text-start">${booking_date} ${created_at}</td>
                        <td class="text-start">${room.name}</td>
                        <td>${room.address}</td>
                        <td>${seat_number === null ? "---" : seat_number}</td>
                        <td>${time_start}</td>
                        <td>${time_end}</td>
                        <td>${status}</td>
                        <td onclick="toggleReplies(${booking_id})" style="color: #030391;">${reportCount}</td>
                    `;
                    bookingTable.appendChild(row);
            
                    const detailRow = document.createElement("tr");
                    detailRow.id = `details-${booking_id}`;
                    detailRow.classList.add("collapse");
            
                    let reportHtml = "";
                    if (reportCount === 0) {
                        reportHtml = `
                            <tr>
                                <td colspan="6" class="text-center">Không có dữ liệu báo cáo</td>
                            </tr>`;
                    } else {
                        report.forEach(rep => {
                            reportHtml += `
                                <tr>
                                    <td>${rep.created_at}</td>
                                    <td class="text-start">${rep.content}</td>
                                    <td>${rep.status}</td>
                                    <td>${rep.solver.name} - ${rep.solved_at}</td>
                                </tr>`;
                        });
                    }
            
                    detailRow.innerHTML = `
                        <td colspan="9">
                            <table class="table table-bordered mb-0">
                                <thead class="table-secondary">
                                    <tr>
                                        <th style="width: 20%;">Thời gian</th>
                                        <th class="text-start" style="width: 80%;">Nội dung</th>
                                        <th style="width: 20%;">Trạng thái</th>
                                        <th style="width: 40%;">Người xử lý</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${reportHtml}
                                </tbody>
                            </table>
                        </td>
                    `;
                    bookingTable.appendChild(detailRow);
                });
                // Render phân trang
                renderPagination("bookingList", "none", page, data.totalPages);
            }
        })
        .catch(error => {
            console.error("Lỗi khi tải dữ liệu:", error);
            bookingTable.innerHTML = `<tr><td colspan="9" class="text-center text-danger">Lỗi khi tải dữ liệu</td></tr>`;
        });

}

// Sinh QR code cho lịch đặt phòng
function generateQRCode(booking_id, room_id) {
    const qrText = `bookingID${booking_id}-roomID${room_id}`;
    const qrUrl = `https://quickchart.io/qr?text=${encodeURIComponent(qrText)}&size=200`;
    document.querySelector("#qrCode img").src = qrUrl;
    document.querySelector("input[name='checkinID']").value = booking_id;

}
// Chuẩn bị dữ liệu cho cancelBooking form
function cancelBookingByID(booking_id) {
    document.querySelector("#bookingID strong").innerText = booking_id;
    document.querySelector("[name='cancelBookingID']").value = booking_id;
}
// Chuẩn bị dữ liệu cho reportBooking form
function reportBookingByID(booking_id) {
    // document.getElementById("reportBookingForm").reset;
    document.querySelector("[name='reportID']").value = booking_id;
}
// Set dữ liệu cho form editBooking
function editBookingForm(booking_id, room_id, time_start, time_end, seat_number) {
    document.getElementById('bookingIDEdit').value = booking_id;
    
    if (room_id < 200) {
        document.querySelector("#e1").checked = true;
        document.getElementById('selfRoomEditSelect').classList.remove('d-none');
        document.querySelector('#selfRoomEditSelect select').value = room_id;
    } else if (room_id < 300) {
        document.querySelector("#e2").checked = true;
        document.getElementById('dualRoomEditSelect').classList.remove('d-none');
        document.getElementById('selfRoomEditSelect').classList.add('d-none');
        document.querySelector('#dualRoomEditSelect select').value = room_id;
    } else {
        document.querySelector("#e3").checked = true;
        document.getElementById('groupRoomEditSelect').classList.remove('d-none');
        document.getElementById('selfRoomEditSelect').classList.add('d-none');
        document.querySelector('#groupRoomEditSelect select').value = room_id;
    }
    // Cập nhật trạng thái thông báo
    const stateInput = document.getElementById("roomEditState");
    if (seat_number) {
        const text = `Số ghế: ${seat_number}`;
        stateInput.value = text;
        stateInput.classList.remove('bg-info-subtle');
        stateInput.classList.remove('bg-danger-subtle');
        stateInput.classList.add('bg-success-subtle');
    } else {
        stateInput.value = "Phòng đã được đặt thành công";
        stateInput.classList.remove('bg-info-subtle');
        stateInput.classList.remove('bg-danger-subtle');
        stateInput.classList.add('bg-success-subtle');
    }

    document.querySelector("[name='startEdit']").value = time_start;
    document.querySelector("[name='endEdit']").value = time_end;
}
// Lấy danh sách phòng hôm nay của chính người dùng
function getTodayBookingList(page = 1) {
    const bookingTable = document.getElementById("todayBookingBody");
    fetch(`/SE_Ass_Code/index.php?url=booking/getMyBookingToday/${currentUserID}/${page}`)
        .then(response => response.json())
        .then(data => {
            bookingTable.innerHTML = "";
            if (data.error) {
                bookingTable.innerHTML = `<tr><td colspan="9" class="text-center">${data.error}</td></tr>`;
                return;
            }
            if (data.bookingList.length > 0) {
                table = document.getElementById("todayBookingList");
                table.classList.remove("d-none");
                data.bookingList.forEach(reservation => {
                    const {
                        booking_id,
                        user_id,
                        room_id,
                        seat_number,
                        time_start,
                        time_end,
                        created_at,
                        booking_date,
                        status,
                        report,
                        author,
                        room
                    } = reservation;
            
                    const reportCount = report.length;
                    const row = document.createElement("tr");
                    const disabledAttr = status !== "waiting" ? "disabled" : "";
                    const disabledQR = (status == "waiting" || status == "overdue") ? "" : "disabled";
                    const disabledRpt = status !== "using" ? "disabled" : "";
                    row.innerHTML = `
                        <td>${booking_id}</td>
                        <td class="text-start">${booking_date} ${created_at}</td>
                        <td class="text-start">${room.address} - ${room.name}</td>
                        <td>${seat_number === null ? "---" : seat_number}</td>
                        <td>${time_start}</td>
                        <td>${time_end}</td>
                        <td>${status}</td>
                        <td class="col-12 d-flex flex-wrap justify-content-end gap-2 mt-2">
                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#editBooking" 
                                    onclick="editBookingForm(${booking_id}, ${room_id}, '${time_start}', '${time_end}', ${seat_number})" ${disabledAttr}>
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#qrCode" 
                                    onclick="generateQRCode(${booking_id}, ${room_id})" ${disabledQR}>
                                <i class="bi bi-qr-code"></i>
                            </button>
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#bookingReport" 
                                    onclick="reportBookingByID(${booking_id})" ${disabledRpt}>
                                <i class="bi bi-exclamation-circle"></i>
                            </button>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelBooking" 
                                    onclick="cancelBookingByID(${booking_id})" ${disabledAttr}>
                                <i class="bi bi-x-circle"></i>
                            </button>
                        </td>
                    `;
                        // <td onclick="toggleReplies(${booking_id})" style="color: #030391;">${reportCount}</td>
                    bookingTable.appendChild(row);
            
                    const detailRow = document.createElement("tr");
                    detailRow.id = `details-${booking_id}`;
                    detailRow.classList.add("collapse");
            
                    let reportHtml = "";
                    if (reportCount === 0) {
                        reportHtml = `
                            <tr>
                                <td colspan="6" class="text-center">Không có dữ liệu báo cáo</td>
                            </tr>`;
                    } else {
                        report.forEach(rep => {
                            reportHtml += `
                                <tr>
                                    <td>${rep.created_at}</td>
                                    <td class="text-start">${rep.content}</td>
                                    <td>${rep.status}</td>
                                </tr>`;
                        });
                    }
            
                    detailRow.innerHTML = `
                        <td colspan="8">
                            <table class="table table-bordered mb-0">
                                <thead class="table-secondary">
                                    <tr>
                                        <th style="width: 20%;">Thời gian</th>
                                        <th class="text-start" style="width: 80%;">Nội dung</th>
                                        <th style="width: 20%;">Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${reportHtml}
                                </tbody>
                            </table>
                        </td>
                    `;
                    bookingTable.appendChild(detailRow);
                });
                // Render phân trang
                renderPagination("todayBooking", "none", page, data.totalPages);
            }
        })
        .catch(error => {
            console.error("Lỗi khi tải dữ liệu:", error);
            bookingTable.innerHTML = `<tr><td colspan="9" class="text-center text-danger">Lỗi khi tải dữ liệu</td></tr>`;
        });
}

// Lấy danh sách bài viết trong forum
function fetchPosts(topic, page = 1) {
    currentTopic = topic;
    currentPage = page;
    const postList = document.querySelector("#postList tbody");
    fetch(`/SE_Ass_Code/index.php?url=forum/getTopic/${topic}/${page}/10`)
        .then(response => response.json())
        .then(data => {
            postList.innerHTML = ""; // Xóa danh sách cũ
            if (data.error) {
                postList.innerHTML = `<tr><td colspan="7" class="text-center">${data.error}</td></tr>`;
                return;
            }
            let posts = data.posts
            // Cập nhật tổng số trang
            let totalPages = data.totalPages || 1;
            // posts.reverse();
            posts.forEach(post => {
                let row = document.createElement("tr");

                // Chỉ admin mới có thể thấy nút "Khóa"
                let lockButton = "";
                if (userRole === "admin") {
                    let lockText = post.status === "Đã khóa" ? "Mở" : "Khóa";
                    let lockIcon = post.status === "Đã khóa" ? "bi-unlock-fill" : "bi-lock-fill";
                    let lockAction = post.status === "Đã khóa" ? "unlockPost" : "lockPost";
                
                    lockButton = `<button class="btn btn-main lock-btn" onclick="changePostStatus('${lockAction}', ${post.id})">
                                    <i class="bi fs-5 ${lockIcon}"></i> ${lockText}
                                  </button>`;
                }

                row.innerHTML = `
                    <td><a href="/SE_Ass_Code/index.php?url=forum/detail/${post.id}">${post.title}</a></td>
                    <td>${post.topic}</td>
                    <td>${post.author.name}</td>
                    <td>${post.time}</td>
                    <td>${post.status}</td>
                    <td onclick="toggleReplies(${post.id})" style="color: #030391;">
                        ${post.replies ? post.replies.length : 0} phản hồi
                    </td>
                    ${userRole === "admin" ? `<td>${lockButton}</td>` : ""}
                `;
                postList.appendChild(row);
            });
            // Render phân trang
            renderPagination("forumPost", "none", currentPage, totalPages);
        })
        .catch(error => {
            console.error("Lỗi khi tải dữ liệu:", error);
            postList.innerHTML = `<tr><td colspan="7" class="text-center text-danger">Lỗi khi tải dữ liệu</td></tr>`;
        });
}
// Đổi trạng thái bài viết
function changePostStatus(action, postID) {
    switch (action) {
    case "lockPost":
        fetch(`/SE_Ass_Code/index.php?url=forum/lockPost/${postID}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                showAlertMessage(data.error, "error");
                return;
            }
            if (data.success) {
                showAlertMessage(data.success, "success");
                fetchPosts("all");
            }
        })
        .catch(error => {
            console.error("Lỗi khi tải dữ liệu:", error);
            showAlertMessage("Lỗi khi tải dữ liệu", "error");
        });
    break;
    case "unlockPost":
        fetch(`/SE_Ass_Code/index.php?url=forum/unlockPost/${postID}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                showAlertMessage(data.error, "error");
                return;
            }
            if (data.success) {
                showAlertMessage(data.success, "success");
            }
        })
        .catch(error => {
            console.error("Lỗi khi tải dữ liệu:", error);
            showAlertMessage("Lỗi khi tải dữ liệu", "error");
        });
    break;
    default:
        showAlertMessage("Yêu cầu không hợp lệ", "error");
        break;
    }
    fetchPosts("all");
}

// Hàm render phân trang
function renderPagination(data, option, currentPage, totalPages) {
    const paginationContainer = document.getElementById(data);
    if (!paginationContainer) return;
    if (totalPages <= 1) {
        paginationContainer.innerHTML = ''; // Xóa nội dung cũ
        return;
    }
    
    paginationContainer.innerHTML = ''; // Xóa nội dung cũ
    
    const ul = document.createElement('ul');
    ul.className = 'pagination justify-content-center';
    
    // Nút Previous
    if (currentPage > 1) {
        const li = document.createElement('li');
        li.className = 'page-item';
        
        const a = document.createElement('a');
        a.className = 'page-link';
        a.href = '#';
        a.textContent = 'Trước';
        a.addEventListener('click', (e) => {
            e.preventDefault();
            changePage(data, option, currentPage - 1);
        });
        
        li.appendChild(a);
        ul.appendChild(li);
    }
    
    // Các nút trang
    for (let i = 1; i <= totalPages; i++) {
        const li = document.createElement('li');
        li.className = `page-item ${i === currentPage ? 'active' : ''}`;
        
        const a = document.createElement('a');
        a.className = 'page-link';
        a.href = '#';
        a.textContent = i;
        a.addEventListener('click', (e) => {
            e.preventDefault();
            changePage(data, option, i);
        });
        
        li.appendChild(a);
        ul.appendChild(li);
    }
    
    // Nút Next
    if (currentPage < totalPages) {
        const li = document.createElement('li');
        li.className = 'page-item';
        
        const a = document.createElement('a');
        a.className = 'page-link';
        a.href = '#';
        a.textContent = 'Tiếp';
        a.addEventListener('click', (e) => {
            e.preventDefault();
            changePage(data, option, currentPage + 1);
        });
        
        li.appendChild(a);
        ul.appendChild(li);
    }
    
    paginationContainer.appendChild(ul);
}
// Hàm chuyển trang
function changePage(data, option, page) {
    if (page < 1) return;
    switch (data) {
        case "forumPost":
            fetchPosts(currentTopic, page);
            break;
        case "loadSpace":
            loadSpaces(option, page);
            break;
        case "loadUsers":
            loadUsers(page);
            break;
        case "loadReports":
            loadReports(page);
            break;
        case "loadIssues":
            loadIssues(page);
            break;
        case "loadAnnouncements":
            loadAnnouncements(page);
            break;
        case "bookingList":
            getBookingList(page);
            break;
        case "allBookingsList":
            loadBookings(option, page);
            break;
        case "todayBooking":
            getTodayBookingList(page);
            break;
        default:
            // Code thực thi nếu không có case nào khớp
      }
    return false; // Ngăn chặn hành vi mặc định của thẻ a
}


// Xử lý hiển thị danh sách replies cho mỗi post (tab Forum)
function toggleReplies(postId) {
    let detailsRow = document.getElementById("details-" + postId);
    if (detailsRow.classList.contains("show")) {
        detailsRow.classList.remove("show");
    } else {
        detailsRow.classList.add("show");
    }
}

// HAI DUONG-------------------------------------------------------------------------------





// THE HUNG-------------------------------------------------------------------------------
// Trang quản lý
document.addEventListener("DOMContentLoaded", function() {
    const userTable = document.getElementById('userTableBody');
    const announcementTable = document.getElementById('announcementTableBody');
    const reportTable = document.getElementById('reportTableBody');
    const bookingTable = document.getElementById('bookingTableBody');
    const bookingSelect = document.getElementById("bookingFilter");
    const userForm = document.getElementById("addUserForm");
    const addAnnouncement = document.getElementById('addAnnouncementForm');
    const editAnnouncement = document.getElementById('editAnnouncementForm');

    if (userTable) loadUsers();

    if (userForm) {
        userForm.addEventListener("submit", function(event) {
            event.preventDefault();
            let formData = new FormData(this);
            document.querySelector("#addUserModal .btn-close").click();
            userForm.reset();
            
            fetch("/SE_Ass_Code/index.php?url=manage/addNewMember", {
                method: "POST",
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    showAlertMessage(data.error, "error");
                    return;
                }
                if (data.success) {
                    showAlertMessage(data.success, "success");
                    loadUsers();
                    return;
                }
            })
            .catch(error => console.error("Lỗi:", error));
        });
    }

    if (announcementTable) loadAnnouncements();
    
    if (addAnnouncement) {
        addAnnouncement.addEventListener("submit", function(event) {
            event.preventDefault();
            let formData = new FormData(this);
            document.querySelector('#addAnnouncementModal  button[type="reset"]').click();
            addAnnouncement.reset();
            
            fetch("/SE_Ass_Code/index.php?url=manage/addNewAnnouncement", {
                method: "POST",
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    showAlertMessage(data.error, "error");
                    return;
                }
                if (data.success) {
                    showAlertMessage(data.success, "success");
                    loadAnnouncements();
                    return;
                }
            })
            .catch(error => console.error("Lỗi:", error));
        });
    }
    
    if (editAnnouncement) {
        editAnnouncement.addEventListener("submit", function(event) {
            event.preventDefault();
            tinymce.activeEditor.save()

            let formData = new FormData(this);
            document.querySelector('#editAnnouncementModal  button[type="reset"]').click();
            editAnnouncement.reset();
            
            fetch("/SE_Ass_Code/index.php?url=manage/editAnnouncement", {
                method: "POST",
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    showAlertMessage(data.error, "error");
                    return;
                }
                if (data.success) {
                    showAlertMessage(data.success, "success");
                    loadAnnouncements();
                    return;
                }
            })
            .catch(error => console.error("Lỗi:", error));
        });
    }

    if (reportTable) loadReports();

    if (bookingSelect) {
        loadBookings("self_study");
        bookingSelect.addEventListener("change", function() {
            loadBookings(this.value);
        });
    }
});

// Tải danh sách người dùng
function loadUsers(page = 1) {
    currentPage = page;
    const table = document.getElementById('userTableBody');
    if (!table) return;

    fetch(`/SE_Ass_Code/index.php?url=manage/getUsers/${page}`)
        .then(response => response.json())
        .then(data => {
            table.innerHTML = '';
            if (data.error) {
                table.innerHTML = `<tr><td colspan="7" class="text-center">${data.error}</td></tr>`;
                return;
            }
            users = data.userList
            // Cập nhật tổng số trang
            totalPages = data.totalPages || 1;

            users.forEach(user => {
                let row = document.createElement("tr");

                // Chỉ admin mới có thể thấy nút "Khóa"
                let lockButton = "";
                if (userRole === "admin") {
                    if (user.status == "Ngưng hoạt động") {
                        lockButton = `<button class="btn btn-main lock-btn" onclick="changeUserStatus('unlock', ${user.id})" data-bs-toggle="modal" data-bs-target="#lockConfirmModal">
                                        <i class="bi bi-unlock-fill"></i>
                                    </button>`;
                    } else {
                        lockButton = `<button class="btn btn-danger lock-btn" onclick="changeUserStatus('lock', ${user.id})" data-bs-toggle="modal" data-bs-target="#lockConfirmModal">
                                        <i class="bi bi-lock-fill"></i>
                                    </button>`;
                    }
                }

                row.innerHTML = `
                    <td>${user.id}</td>
                    <td class="text-start">${user.name}</td>
                    <td class="text-start">${user.email}</td>
                    <td>${user.role}</td>
                    <td>${user.status}</td>
                    <td>${user.date}</td>
                    ${lockButton ? `<td>${lockButton}</td>` : ""}
                `;
                    // <td><input type='checkbox' class='user-checkbox'></td>

                table.appendChild(row);
            });
            // Render phân trang
            renderPagination("loadUsers", "none", currentPage, totalPages);
        })
        .catch(error => {
            console.error("Lỗi khi tải dữ liệu:", error);
            table.innerHTML = `<tr><td colspan="7" class="text-center text-danger">Lỗi khi tải dữ liệu</td></tr>`;
        });
}

function changeUserStatus(status, userID) {
    const text = document.querySelector("#lockConfirmModal #confirmQuestion");
    if (status == "lock") text.innerHTML = "Bạn có chắc chắn <br> muốn khóa tài khoản <br> " + userID + " không?";
    else text.innerHTML = "Bạn có chắc chắn <br> muốn mở khóa tài khoản <br> " + userID + " không?";

    document.querySelector('#lockConfirmModal button[type="submit"]').onclick = function() {
        // Đóng modal sau khi xác nhận
        document.querySelector('#lockConfirmModal button[type="reset"]').click();
        fetch(`/SE_Ass_Code/index.php?url=manage/changeUserStatus/${status}/${userID}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                showAlertMessage(data.error, "error");
                return;
            }
            if (data.success) {
                showAlertMessage(data.success, "success");
                loadUsers();
            }
        })
        .catch(error => {
            console.error("Lỗi khi tải dữ liệu:", error);
            showAlertMessage("Lỗi khi tải dữ liệu", "error");
        });
    }
}

// Tải danh sách thông báo chung
function loadAnnouncements(page = 1) {
    currentPage = page;
    const table = document.getElementById('announcementTableBody');
    if (!table) return;

    fetch(`/SE_Ass_Code/index.php?url=manage/getAnnouncementsList/${page}`)
        .then(response => response.json())
        .then(data => {
            table.innerHTML = '';
            if (data.error) {
                table.innerHTML = `<tr><td colspan="7" class="text-center">${data.error}</td></tr>`;
                return;
            }
            anns = data.announcementsList
            // Cập nhật tổng số trang
            totalPages = data.totalPages || 1;

            anns.forEach(ann => {
                let row = document.createElement("tr");

                row.innerHTML = `
                    <td>${ann.id}</td>
                    <td class="text-start" onclick="toggleReplies(${ann.id})" style="color: #030391;">${ann.title}</td>
                    <td class="text-start">${ann.author.name}</td>
                    <td class="text-start">${ann.type}</td>
                    <td>${ann.created_at}</td>
                    <td>${ann.edit_at}</td>
                    <td>${ann.pin}</td>
                `;

                table.appendChild(row);
                
                const detailRow = document.createElement("tr");
                detailRow.id = `details-${ann.id}`;
                detailRow.classList.add("collapse");
        
                let reportHtml =  `
                            <tr>
                                <td class="text-start">
                                    <div class="col-12">
                                        ${ann.content}
                                    </div>
                                    <div class="col-12 d-flex justify-content-end">
                                        <button class="btn btn-custom mb-3" data-bs-toggle="modal" data-bs-target="#editAnnouncementModal"
                                            data-id="${ann.id}"
                                            data-title="${ann.title}"
                                            data-type="${ann.type}"
                                            data-pin="${ann.pin}"
                                            data-content="${ann.content}"
                                            onclick="editAnnouncement(this)">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>`;
        
                detailRow.innerHTML = `
                    <td colspan="7">
                        <table class="table table-bordered mb-0">
                            <thead class="table-secondary">
                                <tr>
                                    <th>Nội dung</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${reportHtml}
                            </tbody>
                        </table>
                    </td>
                `;
                table.appendChild(detailRow);
            });
            // Render phân trang
            renderPagination("loadAnnouncements", "none", currentPage, totalPages);
        })
        .catch(error => {
            console.error("Lỗi khi tải dữ liệu:", error);
            table.innerHTML = `<tr><td colspan="6" class="text-center text-danger">Lỗi khi tải dữ liệu</td></tr>`;
        });
}

// Sửa thông báo
function editAnnouncement(button) {
    const id = button.dataset.id;
    const title = button.dataset.title;
    const type = button.dataset.type;
    const pin = button.dataset.pin;
    const content = button.dataset.content;

    const form = document.getElementById("editAnnouncementForm");
    form.reset();

    // Gán giá trị vào các trường
    form.querySelector("[name='announcementID']").value = id;
    form.querySelector("[name='titleEdit']").value = title;

    // Gán type (chủ đề) nếu tồn tại
    const typeSelect = form.querySelector("[name='typeEdit']");
    const optionToSelect = Array.from(typeSelect.options).find(opt => opt.value === type);
    if (optionToSelect) optionToSelect.selected = true;

    // Gán pin radio
    const pinRadios = form.querySelectorAll("[name='pinEdit']");
    pinRadios.forEach(radio => {
        radio.checked = (radio.value === pin);
    });

    tinymce.activeEditor.setContent(content);

}

// Tải danh sách báo cáo
function loadReports(page = 1) {
    currentPage = page;
    const table = document.getElementById('reportTableBody');
    if (!table) return;
    fetch(`/SE_Ass_Code/index.php?url=manage/getAllBookingReports/${page}`)
        .then(response => response.json())
        .then(data => {
            table.innerHTML = '';
            if (data.info) {
                table.innerHTML = `<tr><td colspan="7" class="text-center">${data.info}</td></tr>`;
                return;
            }
            reports = data.reportsList
            // Cập nhật tổng số trang
            totalPages = data.totalPages || 1;

            reports.forEach(rpt => {
                let row = document.createElement("tr");

                // Chỉ admin mới có thể thấy nút "Khóa"
                let handlerButtons = "";
                if (rpt.status == "waiting") {
                    handlerButtons = `
                        <button type="button" class="btn btn-warning" onclick="solveReport(${rpt.booking_id}, ${rpt.report_id}, 'denied')">Từ chối</button>
                        <button type="button" class="btn btn-primary" onclick="solveReport(${rpt.booking_id}, ${rpt.report_id}, 'solved')">Xử lý</button>
                    `;
                } else {
                    handlerButtons = `
                        <button type="button" class="btn btn-warning" onclick="solveReport(${rpt.booking_id}, ${rpt.report_id}, 'denied')" disabled>Từ chối</button>
                        <button type="button" class="btn btn-primary" onclick="solveReport(${rpt.booking_id}, ${rpt.report_id}, 'solved')" disabled>Xử lý</button>
                    `;
                }

                row.innerHTML = `
                    <td>${rpt.booking_id}-${rpt.report_id}</td>
                    <td class="text-start">${rpt.author.name}</td>
                    <div class="text-start">${rpt.content}</div>
                    <td>${rpt.created_at}</td>
                    <td>${rpt.status}</td>
                    <td>${rpt.solver.name} - ${rpt.solved_at}</td>
                    ${handlerButtons ? `<td>${handlerButtons}</td>` : ""}
                `;
                    // 
                    // <td><input type='checkbox' class='user-checkbox'></td>

                table.appendChild(row);
            });
            // Render phân trang
            renderPagination("loadReports", "none", currentPage, totalPages);
        })
        .catch(error => {
            console.error("Lỗi khi tải dữ liệu:", error);
            table.innerHTML = `<tr><td colspan="7" class="text-center text-danger">Lỗi khi tải dữ liệu</td></tr>`;
        });
}

// Tải danh sách đặt phòng
function loadBookings(roomType, page = 1) {
    const table = document.getElementById('bookingTableBody');
    fetch(`/SE_Ass_Code/index.php?url=manage/getBookingListByRoomType/${roomType}/${page}`)
        .then(response => response.json())
        .then(data => {
            table.innerHTML = '';
            if (data.info) {
                table.innerHTML = `<tr><td colspan="7" class="text-center">${data.info}</td></tr>`;
                return;
            }
            if (data.bookingList) {
                data.bookingList.forEach(booking => {
                    const reportCount = booking.report.length;
                    const row = document.createElement("tr");
                    row.innerHTML = `
                        <td>${booking.booking_id}</td>
                        <td class="text-start">${booking.booking_date} ${booking.created_at}</td>
                        <td class="text-start">${booking.author.name}</td>
                        <td>${booking.room.address}</td>
                        <td>${booking.seat_number === null ? "---" : booking.seat_number}</td>
                        <td>${booking.time_start}</td>
                        <td>${booking.time_end}</td>
                        <td>${booking.status}</td>
                        <td onclick="toggleReplies(${booking.booking_id})" style="color: #030391;">${reportCount}</td>
                    `;
                    table.appendChild(row);
            
                    const detailRow = document.createElement("tr");
                    detailRow.id = `details-${booking.booking_id}`;
                    detailRow.classList.add("collapse");
            
                    let reportHtml = "";
                    if (reportCount === 0) {
                        reportHtml = `
                            <tr>
                                <td colspan="6" class="text-center">Không có dữ liệu báo cáo</td>
                            </tr>`;
                    } else {
                        booking.report.forEach(rep => {
                            reportHtml += `
                                <tr>
                                    <td>${rep.created_at}</td>
                                    <td class="text-start">${rep.content}</td>
                                    <td>${rep.status}</td>
                                    <td>${rep.solver.name} - ${rep.solved_at}</td>
                                </tr>`;
                        });
                    }
            
                    detailRow.innerHTML = `
                        <td colspan="9">
                            <table class="table table-bordered mb-0">
                                <thead class="table-secondary">
                                    <tr>
                                        <th style="width: 20%;">Thời gian</th>
                                        <th class="text-start" style="width: 80%;">Nội dung</th>
                                        <th style="width: 20%;">Trạng thái</th>
                                        <th style="width: 40%;">Người xử lý</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${reportHtml}
                                </tbody>
                            </table>
                        </td>
                    `;
                    table.appendChild(detailRow);
                });
                // Render phân trang
                renderPagination("allBookingsList", roomType, page, data.totalPages);
            }
        })
        .catch(error => {
            console.error("Lỗi khi tải dữ liệu:", error);
            table.innerHTML = `<tr><td colspan="7" class="text-center text-danger">Lỗi khi tải dữ liệu</td></tr>`;
        });
}

// Trang quản trị
document.addEventListener("DOMContentLoaded", function () {
    const roomSelect = document.getElementById("roomFilter");
    if (roomSelect) {
        loadSpaces("self_study");
        roomSelect.addEventListener("change", function() {
            loadSpaces(this.value);
        });
    }

    // Thêm phòng mới
    const addRoom = document.getElementById("addRoomForm");
    if (addRoom) {
        addRoom.addEventListener("submit", function (event) {
            event.preventDefault();
            let formData = new FormData(this);
            document.querySelector(".modal .btn-close").click();
            addRoom.reset();

            fetch("/SE_Ass_Code/index.php?url=admin/addNewRoom", {
                method: "POST",
                body: formData,
            })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        showAlertMessage(data.error, "error");
                        return;
                    }
                    if (data.success) {
                        let roomType = formData.get("type");
                        showAlertMessage(data.success, "success");
                        loadSpaces(roomType);
                    }
                })
                .catch(error => console.error("Lỗi:", error));
        });
    }


    // Sửa thông tin phòng
    const editRoom = document.getElementById("editRoomForm");
    if (editRoom) {
        editRoom.addEventListener("submit", function (event) {
            event.preventDefault();
            let formData = new FormData(this);
            document.querySelector(".modal .btn-close").click();
            editRoom.reset();

            fetch("/SE_Ass_Code/index.php?url=manage/editRoom", {
                method: "POST",
                body: formData,
            })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        showAlertMessage(data.error, "error");
                        return;
                    }
                    if (data.success) {
                        let roomType;
                        if (formData.get("roomId") < 200) roomType = "self_study";
                        else if (formData.get("roomId") < 300) roomType = "dual";
                        else roomType = "group";
                        showAlertMessage(data.success, "success");
                        loadSpaces(roomType);
                    }
                })
                .catch(error => console.error("Lỗi:", error));
        });
    }
    
    // Báo cáo tình trạng phòng
    const reportRoom = document.getElementById("reportRoomForm");
    if (reportRoom) {
        reportRoom.addEventListener("submit", function (event) {
            event.preventDefault();
            let formData = new FormData(this);
            document.querySelector(".modal .btn-close").click();
            reportRoom.reset();

            fetch("/SE_Ass_Code/index.php?url=manage/reportRoom", {
                method: "POST",
                body: formData,
            })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        showAlertMessage(data.error, "error");
                        return;
                    }
                    if (data.success) {
                        showAlertMessage(data.success, "success");
                        if (document.getElementById("issueTableBody")) loadIssues();
                    }
                })
                .catch(error => console.error("Lỗi:", error));
        });
    }
    
    const issueTableBody = document.getElementById("issueTableBody");
    if (issueTableBody) {
        loadIssues();
    }
});

// Load danh sách không gian học tập
function loadSpaces(roomType, page = 1) {
    const table = document.getElementById('spaceTableBody');
    fetch(`/SE_Ass_Code/index.php?url=admin/getStudySpace/${roomType}/${page}`)
        .then(response => response.json())
        .then(data => {
            table.innerHTML = '';
            if (data.info) {
                table.innerHTML = `<tr><td colspan="7" class="text-center">${data.info}</td></tr>`;
                return;
            }
            if (data.error) {
                showAlertMessage(data.error, "error");
                return;
            }
            if (data.success) {
                showAlertMessage(data.success, "success");
            }

            let space = data.roomList;
            // Cập nhật tổng số trang
            let totalPages = data.totalPages || 1;
            space.forEach(room => {
                let row = document.createElement("tr");

                row.innerHTML = `
                    <td>${room.id}</td>
                    <td>${room.name}</td>
                    <td>${room.address}</td>
                    `;
                if (roomType == "self_study") {
                    row.innerHTML += `
                        <td>${room.total_seats} ghế</td>
                        <td>${room.status}</td>
                        <td>${room.available_seats}/${room.total_seats}</td>
                    `;
                } else if (roomType == "dual") {
                    row.innerHTML += `
                        <td>2 người</td>
                        <td>${room.status}</td>
                        <td>${room.status}</td>
                    `;
                } else {
                    row.innerHTML += `
                        <td>10 người</td>
                        <td>${room.status}</td>
                        <td>${room.status}</td>
                    `;
                }
                let lockIcon = room.status === "lock" ? "bi-unlock-fill" : "bi-lock-fill";
                let lockAction = room.status === "lock" ? "unlockRoom" : "lockRoom";
            
                let lockButton = `<button class="btn btn-custom" onclick="changeRoomStatus('${lockAction}', ${room.id})">
                                <i class="bi fs-5 ${lockIcon}"></i>
                              </button>`;
                              
                let editButton = `<button class="btn btn-warning" onclick="editRoom(${room.id})" data-bs-toggle="modal" data-bs-target="#editRoomModal">
                                <i class="bi fs-5 bi-pencil-square"></i>
                            </button>`;
                 row.innerHTML += `<td>${lockButton} ${editButton}</td>`;
                
                table.appendChild(row);
            });
            // Render phân trang
            renderPagination("loadSpace", roomType, page, totalPages);
        })
        .catch(error => {
            console.error("Lỗi khi tải dữ liệu:", error);
            table.innerHTML = `<tr><td colspan="7" class="text-center text-danger">Lỗi khi tải dữ liệu</td></tr>`;
        });
}

function changeRoomStatus(action, roomID) {
    switch (action) {
    case "lockRoom":
        fetch(`/SE_Ass_Code/index.php?url=admin/lockRoom/${roomID}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                showAlertMessage(data.error, "error");
                return;
            }
            if (data.success) {
                showAlertMessage(data.success, "success");
                if (roomID < 200) loadSpaces("self_study");
                else if (roomID < 300) loadSpaces("dual");
                else loadSpaces("group");
            }
        })
        .catch(error => {
            console.error("Lỗi khi tải dữ liệu:", error);
            showAlertMessage("Lỗi khi tải dữ liệu", "error");
        });
    break;
    case "unlockRoom":
        fetch(`/SE_Ass_Code/index.php?url=admin/unlockRoom/${roomID}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                showAlertMessage(data.error, "error");
                return;
            }
            if (data.success) {
                showAlertMessage(data.success, "success");
            }
        })
        .catch(error => {
            console.error("Lỗi khi tải dữ liệu:", error);
            showAlertMessage("Lỗi khi tải dữ liệu", "error");
        });
    break;
    default:
        showAlertMessage("Yêu cầu không hợp lệ", "error");
        break;
    }
    if (roomID < 200) {
        loadSpaces("self_study");
    } else if (roomID < 300) {
        loadSpaces("dual");
    } else {
        loadSpaces("group");
    }
}

function editRoom(roomID) {
    fetch(`/SE_Ass_Code/index.php?url=manage/findRoomByID/${roomID}`)
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            showAlertMessage(data.error, "error");
            return;
        }
        if (data.room) {
            const room = data.room;
            
            const [building, roomNumber] = room.address.split("-");// Xác định capacity theo id
            let capacity, type;
            if (room.id < 200) {
                capacity = room.total_seats;
                type = "Phòng tự học";
            } else if (room.id < 300) {
                capacity = 2;
                type = "Phòng học đôi";
            } else {
                capacity = 10;
                type = "Phòng học nhóm";
            }
            console.error(building, roomNumber, capacity, type)

            document.getElementById("roomId").value = room.id;
            document.querySelector("input[name='roomName']").value = room.name;
            document.querySelector("input[name='buildingE']").value = building;
            document.querySelector("input[name='roomE']").value = roomNumber;
            document.querySelector("input[name='type']").value = type;
            document.querySelector("input[name='capacityE']").value = capacity;
        }
    })
    .catch(error => {
        console.error("Lỗi khi tải dữ liệu:", error);
        showAlertMessage("Lỗi khi tải dữ liệu", "error");
    });
}

function loadIssues(page = 1) {
    currentPage = page;
    const table = document.getElementById('issueTableBody');
    if (!table) return;
    fetch(`/SE_Ass_Code/index.php?url=admin/getIssues/${page}`)    
        .then(response => response.json())
        .then(data => {
            table.innerHTML = '';
            if (data.info) {
                table.innerHTML = `<tr><td colspan="6" class="text-center">${data.info}</td></tr>`;
                return;
            }

            let issues = data.issueList;
            // Cập nhật tổng số trang
            let totalPages = data.totalPages || 1;
            issues.forEach(issue => {
                let row = document.createElement("tr");

                row.innerHTML = `
                    <td>${issue.id}</td>
                    <div class="text-start">${issue.content}</div>
                    <td class="text-start">${issue.roomName}</td>
                    <td>${issue.reporterName} - ${issue.created_at}</td>
                    <td>${issue.status} - ${issue.solved_at}</td>
                    <td>
                        <button type="button" class="btn btn-primary" onclick="solveIssue(${issue.id})" ${issue.status == "waiting" ? "" : "disabled"}>
                            Xử lý
                        </button>
                    </td>
                    `;
                
                table.appendChild(row);
            });
            // Render phân trang
            renderPagination("loadIssues", "none", page, totalPages);
        })
        .catch(error => {
            console.error("Lỗi khi tải dữ liệu:", error);
            table.innerHTML = `<tr><td colspan="6" class="text-center text-danger">Lỗi khi tải dữ liệu</td></tr>`;
        });
}

function solveIssue(issueID) {
    fetch(`/SE_Ass_Code/index.php?url=admin/solveIssue/${issueID}`)
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            showAlertMessage(data.error, "error");
            return;
        }
        if (data.success) {
            showAlertMessage(data.success, "success");
        }
        if (document.getElementById("issueTableBody")) loadIssues();
    })
    .catch(error => {
        console.error("Lỗi khi tải dữ liệu:", error);
    });

}
