document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('.signup-form');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');
    const email = form.querySelector('input[name="email"]');
    const warning = document.getElementById('passwordWarning');

    form.addEventListener('submit', (e) => {
        const passwordValue = password.value;
        const confirmValue = confirmPassword.value;
        const emailValue = email.value.trim();

        // Password regex: min 8 chars, 1 uppercase, 1 number, 1 special char
        const passwordRule = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]).{8,}$/;

        // Email regex: must end with @gmail.com or @yahoo.com
        const emailRule = /^[a-zA-Z0-9._%+-]+@(gmail\.com|yahoo\.com)$/;

        // Validate password
        if (!passwordRule.test(passwordValue)) {
            e.preventDefault();
            warning.style.display = 'block';
            warning.textContent = 'Password must be at least 8 characters, include 1 uppercase letter, 1 number, and 1 special character';
            return;
        }

        // Confirm password
        if (passwordValue !== confirmValue) {
            e.preventDefault();
            warning.style.display = 'block';
            warning.textContent = 'Passwords do not match';
            return;
        }

        // Validate email
        if (!emailRule.test(emailValue)) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Invalid Email',
                text: 'Email must be a Gmail or Yahoo account (e.g., example@gmail.com)',
            });
            email.focus();
            return;
        }

        // If all checks pass, hide warning
        warning.style.display = 'none';
    });
    
    const ruleLength = document.getElementById('ruleLength');
    const ruleUpper = document.getElementById('ruleUpper');
    const ruleNumber = document.getElementById('ruleNumber');
    const ruleSymbol = document.getElementById('ruleSymbol');

    // Live password check
    password.addEventListener('input', () => {
        const pwd = password.value;

        // Length
        pwd.length >= 8 ? ruleLength.classList.add('valid') : ruleLength.classList.remove('valid');
        // Uppercase
        /[A-Z]/.test(pwd) ? ruleUpper.classList.add('valid') : ruleUpper.classList.remove('valid');
        // Number
        /\d/.test(pwd) ? ruleNumber.classList.add('valid') : ruleNumber.classList.remove('valid');
        // Symbol
        /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(pwd) ? ruleSymbol.classList.add('valid') : ruleSymbol.classList.remove('valid');
    });

});
