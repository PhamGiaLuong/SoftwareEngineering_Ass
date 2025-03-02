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