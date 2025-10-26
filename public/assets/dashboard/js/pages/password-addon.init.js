var passwordAddonButton = document.getElementById("password-addon");

if (passwordAddonButton) {
    passwordAddonButton.addEventListener("click", function () {
        var passwordInput = document.getElementById("password-input");
        
        if (passwordInput) {
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        }
    });
}