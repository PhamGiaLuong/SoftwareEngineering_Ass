// GIA LUONG-------------------------------------------------------------------------------
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
    }, 3000);
}

// Xử lý dữ liệu cho Tạo bài viết (tab forum)
document.addEventListener("DOMContentLoaded", function () {
    const postForm = document.getElementById("addNewPostForm");
    const replyForm = document.getElementById("addNewReplyForm");
    const topicSelect = document.getElementById("forumTopicFilter");
    const genNote = document.getElementById("generalNoteBox");
    const bookingHistory = document.getElementById("bookingHistoryBody");

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
    // Lấy lịch sủ đặt phòng
    if (bookingHistory) {
        getBookingList();
    }
});

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
        if (currentName != null) {
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
                renderPagination("bookingList", "none", page, data.totalPages);
            }
        })
        .catch(error => {
            console.error("Lỗi khi tải dữ liệu:", error);
            bookingTable.innerHTML = `<tr><td colspan="9" class="text-center text-danger">Lỗi khi tải dữ liệu</td></tr>`;
        });

}

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
    const paginationContainer = document.getElementById('pagination');
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
        case "bookingList":
            getBookingList(page);
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

document.addEventListener("DOMContentLoaded", function() {
    loadUsers();
});

// Lắng nghe sự kiện submit từ form
// document.getElementById('userForm').addEventListener('submit', function(e) {
//     e.preventDefault(); // Ngừng hành động mặc định (không reload trang)
    
//     // Lấy dữ liệu từ form
//     const userData = {
//         id: document.getElementById('userId').value,
//         name: document.getElementById('userName').value,
//         email: document.getElementById('userEmail').value,
//         role: document.getElementById('userRole').value,
//         status: document.getElementById('userStatus').value
//     };

//     // Kiểm tra xem là tạo mới hay chỉnh sửa
//     const method = userData.id ? 'PUT' : 'POST';
//     const url = userData.id ? `/api/users/${userData.id}` : '/api/users';

//     // Gửi dữ liệu lên server (sử dụng Fetch API)
//     fetch(url, {
//         method: method,
//         headers: {
//             'Content-Type': 'application/json',
//         },
//         body: JSON.stringify(userData),
//     })
//     .then(response => response.json())
//     .then(data => {
//         alert('Tài khoản đã được lưu thành công!');
//         loadUsers(); // Tải lại danh sách tài khoản sau khi lưu thành công
//         document.getElementById('addUserModal').querySelector('.btn-close').click(); // Đóng modal
//     })
//     .catch(error => {
//         console.error('Lỗi khi thêm tài khoản:', error);
//         alert('Có lỗi xảy ra khi lưu tài khoản. Vui lòng thử lại!');
//     });
// });

// Tải danh sách người dùng
function loadUsers(page = 1) {
    currentPage = page;
    const table = document.getElementById('userTableBody');
    if (!table) return;

    fetch(`/SE_Ass_Code/index.php?url=admin/getUsers/${page}`)
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

            user.forEach(user => {
                let row = document.createElement("tr");

                // Chỉ admin mới có thể thấy nút "Khóa"
                let lockButton = "";
                if (userRole === "admin") {
                    let lockText = post.status === "Đã khóa" ? "Mở" : "Khóa";
                    let lockIcon = post.status === "Đã khóa" ? "bi-unlock-fill" : "bi-lock-fill";
                    let lockAction = post.status === "Đã khóa" ? "unlockPost" : "lockPost";
                
                    lockButton = `<button class="btn btn-main lock-btn" onclick="location.href='/SE_Ass_Code/index.php?url=forum/${lockAction}/${post.id}'">
                                    <i class="bi fs-5 ${lockIcon}"></i> ${lockText}
                                  </button>`;
                }

                row.innerHTML = `
                    
                `;
                table.appendChild(row);
            });
            // Render phân trang
            renderPagination("loadUser", "none", currentPage, totalPages);
        })
        .catch(error => {
            console.error("Lỗi khi tải dữ liệu:", error);
            table.innerHTML = `<tr><td colspan="7" class="text-center text-danger">Lỗi khi tải dữ liệu</td></tr>`;
        });
}

// Chỉnh sửa tài khoản
function editUser(id) {
    fetch(`/api/users/${id}`)
        .then(response => response.json())
        .then(user => {
            document.getElementById('userId').value = user.id;
            document.getElementById('userName').value = user.name;
            document.getElementById('userEmail').value = user.email;
            document.getElementById('userRole').value = user.role;
            document.getElementById('userStatus').value = user.status;
            document.getElementById('userModalTitle').innerText = "Chỉnh sửa tài khoản";
            new bootstrap.Modal(document.getElementById('addUserModal')).show();
        });
}

document.addEventListener("DOMContentLoaded", function () {
    const roomSelect = document.getElementById("roomFilter");
    loadSpaces("self_study");
    if (roomSelect) {
        roomSelect.addEventListener("change", function() {
            loadSpaces(this.value);
        });
    } else {
        console.error("Không tìm thấy phần tử roomFilter!");
    }

    // Thêm phòng mới
    const addRoom = document.getElementById("editSpaceForm");
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
                        console.error(roomType);
                        console.error(formData);
                        showAlertMessage(data.success, "success");
                        loadSpaces(roomType);
                    }
                })
                .catch(error => console.error("Lỗi:", error));
        });
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
                let lockText = room.status === "lock" ? "Mở" : "Khóa";
                let lockIcon = room.status === "lock" ? "bi-unlock-fill" : "bi-lock-fill";
                let lockAction = room.status === "lock" ? "unlockRoom" : "lockRoom";
            
                let lockButton = `<button class="btn btn-custom" onclick="changeRoomStatus('${lockAction}', ${room.id})">
                                <i class="bi fs-5 ${lockIcon}"></i> ${lockText}
                              </button>`;
                (userRole === "admin") ? row.innerHTML += `<td>${lockButton}</td>` : "";
                
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

// Thêm/Sửa không gian học tập
// document.getElementById('editSpaceForm').addEventListener('submit', function(e) {
//     e.preventDefault(); // Ngừng hành động mặc định (không reload trang)
//     fetch("/SE_Ass_Code/index.php?url=admin/addNewRoom", {
//         method: "POST",
//         body: formData,
//     })
//         .then(response => response.text())
//         .then(data => {
//             if (data) {
//                 alert("Phòng mới được tạo thành công!");
//                 location.reload();
//             } else {
//                 alert("Lỗi: " + data);
//             }
//         })
//         .catch(error => console.error("Lỗi:", error));
// });

// Chỉnh sửa không gian học tập
function editSpace(id) {
    fetch(`/api/spaces/${id}`)
        .then(response => response.json())
        .then(space => {
            document.getElementById('spaceId').value = space.id;
            document.getElementById('spaceName').value = space.name;
            document.getElementById('spaceType').value = space.type;
            document.getElementById('spaceCapacity').value = space.capacity;
            document.getElementById('spaceStatus').value = space.status;
            document.getElementById('spaceModalTitle').innerText = "Chỉnh sửa không gian học tập";
            new bootstrap.Modal(document.getElementById('addSpaceModal')).show();
        });
}

// Xác nhận xóa không gian học tập
function confirmDelete(id) {
    if (confirm('Bạn có chắc chắn muốn xóa không gian này?')) {
        fetch(`/api/spaces/${id}`, { method: 'DELETE' })
            .then(() => loadSpaces())
            .catch(error => console.error('Lỗi khi xóa không gian học tập:', error));
    }
}




