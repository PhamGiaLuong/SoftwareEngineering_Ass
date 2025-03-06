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

            fetch("/SE_Ass_Code/index.php?url=forum/addNewPost", {
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

            fetch("/SE_Ass_Code/index.php?url=forum/addNewReply", {
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
            fetch(`/SE_Ass_Code/index.php?url=forum/getTopic/${topic}`)
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
                        
                            lockButton = `<button class="btn btn-main lock-btn" onclick="location.href='/SE_Ass_Code/index.php?url=forum/${lockAction}/${post.id}'">
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




