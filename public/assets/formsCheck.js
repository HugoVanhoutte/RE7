let form = document.querySelector(".needs-validation");

//Bootstrap form validation
form.addEventListener('submit', validate);

function validate(e) { //TODO: change for password validated correctly NOT URGENT
    if (form.checkValidity() === false) {
        e.preventDefault();
    }
    form.classList.add('was-validated');
}

//Password missing requirement
let passwordInput = document.querySelector("input[name='password']");

let validationLength = document.querySelector("div#password-validation-length");
let validationLower = document.querySelector("div#password-validation-lc");
let validationUpper = document.querySelector("div#password-validation-uc");
let validationNumber = document.querySelector("div#password-validation-number");
let validationSpecial = document.querySelector("div#password-validation-spec");

let lengthPattern = /^.{8,}$/
let lowerPattern = /[a-z]/
let upperPattern = /[A-Z]/
let numberPattern = /[0-9]/
let specialPattern = /[!@#$%^&*()_+]/

document.body.addEventListener("keyup", function () {
    updateValidation();
})

function updateValidation() {
    const passwordValue = passwordInput.value;

    validationLength.classList.toggle("bg-success", lengthPattern.test(passwordValue));
    validationLength.classList.toggle("bg-danger", !lengthPattern.test(passwordValue));

    validationLower.classList.toggle("bg-success", lowerPattern.test(passwordValue));
    validationLower.classList.toggle("bg-danger", !lowerPattern.test(passwordValue));

    validationUpper.classList.toggle("bg-success", upperPattern.test(passwordValue));
    validationUpper.classList.toggle("bg-danger", !upperPattern.test(passwordValue));

    validationNumber.classList.toggle("bg-success", numberPattern.test(passwordValue));
    validationNumber.classList.toggle("bg-danger", !numberPattern.test(passwordValue));

    validationSpecial.classList.toggle("bg-success", specialPattern.test(passwordValue));
    validationSpecial.classList.toggle("bg-danger", !specialPattern.test(passwordValue));
}

