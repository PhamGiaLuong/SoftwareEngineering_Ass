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

// Xử lý dữ liệu cho Tạo bài viết (tab forum)
document.addEventListener("DOMContentLoaded", function () {
    const postForm = document.getElementById("addNewPostForm");
    const replyForm = document.getElementById("addNewReplyForm");
    const topicSelect = document.getElementById("forumTopicFilter");
    const postList = document.querySelector("#postList tbody");

    // Kiểm tra và xử lý sự kiện cho form tạo bài viết
    if (postForm) {
        postForm.addEventListener("submit", function (event) {
            event.preventDefault();
            let formData = new FormData(this);

            fetch("/SoftwareEngineering_Ass/index.php?url=forum/addNewPost", {
                method: "POST",
                body: formData,
            })
                .then(response => response.text())
                .then(data => {
                    if (data) {
                        alert("Bài viết đã được tạo thành công!");
                        location.reload();
                    } else {
                        alert("Lỗi: " + data);
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

            fetch("/SoftwareEngineering_Ass/index.php?url=forum/addNewReply", {
                method: "POST",
                body: formData,
            })
                .then(response => response.text())
                .then(data => {
                    if (data) {
                        alert("Phản hồi đã được gửi!");
                        location.reload(); 
                    } else {
                        alert("Lỗi: " + data);
                    }
                })
                .catch(error => console.error("Lỗi:", error));
        });
    }

    // Kiểm tra và xử lý bộ lọc topic
    if (topicSelect && postList) {
        function fetchPosts(topic) {
            fetch(`/SoftwareEngineering_Ass/index.php?url=forum/getTopic/${topic}`)
                .then(response => response.json())
                .then(posts => {
                    postList.innerHTML = ""; // Xóa danh sách cũ
                    if (posts.error) {
                        postList.innerHTML = `<tr><td colspan="7" class="text-center">${posts.error}</td></tr>`;
                        return;
                    }
                    posts.reverse();
                    posts.forEach(post => {
                        let row = document.createElement("tr");
        
                        // Chỉ admin mới có thể thấy nút "Khóa"
                        let lockButton = "";
                        if (userRole === "admin") {
                            let lockText = post.status === "Đã khóa" ? "Mở" : "Khóa";
                            let lockIcon = post.status === "Đã khóa" ? "bi-unlock-fill" : "bi-lock-fill";
                            let lockAction = post.status === "Đã khóa" ? "unlockPost" : "lockPost";
                        
                            lockButton = `<button class="btn btn-main lock-btn" onclick="location.href='/SoftwareEngineering_Ass/index.php?url=forum/${lockAction}/${post.id}'">
                                            <i class="bi fs-5 ${lockIcon}"></i> ${lockText}
                                          </button>`;
                        }
        
                        row.innerHTML = `
                            <td><a href="/SoftwareEngineering_Ass/index.php?url=forum/detail/${post.id}">${post.title}</a></td>
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
                })
                .catch(error => {
                    console.error("Lỗi khi tải dữ liệu:", error);
                    postList.innerHTML = `<tr><td colspan="7" class="text-center text-danger">Lỗi khi tải dữ liệu</td></tr>`;
                });
        }
        

        let currentTopic = topicSelect.value; // Lưu trạng thái hiện tại
        // fetchPosts(currentTopic); // Tải bài viết ngay khi trang mở

        topicSelect.addEventListener("change", function () {
            if (this.value !== currentTopic) { // Chỉ thực hiện nếu có thay đổi
                fetchPosts(this.value);
                currentTopic = this.value;
            }
        });
    }
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
});



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
document.getElementById('userForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Ngừng hành động mặc định (không reload trang)
    
    // Lấy dữ liệu từ form
    const userData = {
        id: document.getElementById('userId').value,
        name: document.getElementById('userName').value,
        email: document.getElementById('userEmail').value,
        role: document.getElementById('userRole').value,
        status: document.getElementById('userStatus').value
    };

    // Kiểm tra xem là tạo mới hay chỉnh sửa
    const method = userData.id ? 'PUT' : 'POST';
    const url = userData.id ? `/api/users/${userData.id}` : '/api/users';

    // Gửi dữ liệu lên server (sử dụng Fetch API)
    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(userData),
    })
    .then(response => response.json())
    .then(data => {
        alert('Tài khoản đã được lưu thành công!');
        loadUsers(); // Tải lại danh sách tài khoản sau khi lưu thành công
        document.getElementById('addUserModal').querySelector('.btn-close').click(); // Đóng modal
    })
    .catch(error => {
        console.error('Lỗi khi thêm tài khoản:', error);
        alert('Có lỗi xảy ra khi lưu tài khoản. Vui lòng thử lại!');
    });
});

// Tải danh sách người dùng
function loadUsers() {
    fetch('/api/users') 
        .then(response => response.json())
        .then(data => {
            const table = document.getElementById('userTableBody');
            table.innerHTML = '';
            data.forEach(user => {
                table.innerHTML += `
                    <tr>
                        <td>${user.id}</td>
                        <td>${user.name}</td>
                        <td>${user.email}</td>
                        <td>${user.role}</td>
                        <td>${user.status}</td>
                        <td>
                            <button onclick="editUser(${user.id})" class="btn btn-warning btn-sm">Sửa</button>
                            <button onclick="confirmDelete(${user.id})" class="btn btn-danger btn-sm">Xóa</button>
                        </td>
                    </tr>`;
            });
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




document.addEventListener("DOMContentLoaded", function() {
    loadSpaces();
});

// Load danh sách không gian học tập
function loadSpaces() {
    fetch('/api/spaces') // API Backend (Cần có sẵn)
        .then(response => response.json())
        .then(data => {
            const table = document.getElementById('spaceTableBody');
            table.innerHTML = '';
            data.forEach(space => {
                table.innerHTML += `
                    <tr>
                        <td>${space.name}</td>
                        <td>${space.type}</td>
                        <td>${space.status}</td>
                        <td>${space.capacity}</td>
                        <td>
                            <button onclick="editSpace(${space.id})" class="btn btn-warning btn-sm">Sửa</button>
                            <button onclick="confirmDelete(${space.id})" class="btn btn-danger btn-sm">Xóa</button>
                        </td>
                    </tr>`;
            });
        });
}

// Thêm/Sửa không gian học tập
document.getElementById('spaceForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Ngừng hành động mặc định (không reload trang)

    const spaceData = {
        id: document.getElementById('spaceId').value,
        name: document.getElementById('spaceName').value,
        type: document.getElementById('spaceType').value,
        capacity: document.getElementById('spaceCapacity').value,
        status: document.getElementById('spaceStatus').value
    };

    const method = spaceData.id ? 'PUT' : 'POST';
    const url = spaceData.id ? `/api/spaces/${spaceData.id}` : '/api/spaces';

    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(spaceData),
    })
    .then(response => response.json())
    .then(data => {
        alert('Không gian học tập đã được lưu thành công!');
        loadSpaces();
        document.getElementById('addSpaceModal').querySelector('.btn-close').click(); // Đóng modal
    })
    .catch(error => {
        console.error('Lỗi khi thêm không gian học tập:', error);
        alert('Có lỗi xảy ra khi lưu không gian học tập. Vui lòng thử lại!');
    });
});

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




