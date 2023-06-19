document.addEventListener("DOMContentLoaded", function () { //Load the script once the page is loaded
    let visibilityButtons = document.querySelectorAll(".passwordVisibility");
    let passwordInputs = document.querySelectorAll("input[type='password']");

    for (let i = 0; i < visibilityButtons.length; i++) {
        visibilityButtons[i].parentElement.addEventListener("click", function () {
            togglePasswordVisibility(i);
        });
    }

    function togglePasswordVisibility(index) {
        if (passwordInputs[index].type === "password") {
            passwordInputs[index].type = "text";
            visibilityButtons[index].classList.remove("fa-eye");
            visibilityButtons[index].classList.add("fa-eye-slash");
        } else {
            passwordInputs[index].type = "password";
            visibilityButtons[index].classList.remove("fa-eye-slash");
            visibilityButtons[index].classList.add("fa-eye");
        }
    }
});