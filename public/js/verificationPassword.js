document.addEvenListener('DOMContentLoaded', function() {
    const password = document.getElementById('registration_form_password');
    const confirmPassword = document.getElementById('registration_form_confirmPassword');
    const submitBtn = document.getElementById('submit-btn');
    const passwordStrength = document.getElementById('password-strength');
    const passwordMatch = document.getElementById('password-match');
    console.log(password);
    
    function checkPasswordStrength() 
    {
        const pass = password.value;
        let strength = 0;

        if (pass.length >= 8) strength++;
        if (/[A-Z]/.test(pass)) strength++;
        if (/[a-z]/.test(pass)) strength++;
        if (/[0-9]/.test(pass)) strength++;
        if (/[\W]/.test(pass)) strength++;

        switch (strength) 
        {
            case 1:

            case 2:
                passwordStrength.textContent = "Faible (utilisez plus de caractères, de majuscules et de chiffres )";
                passwordStrength.classList.add("text-danger");
                passwordStrength.classList.remove("text-warning", "text-success");
            break

            case 3:
                passwordStrength.textContent = "Moyenne (ajouter les cactères spéciaux pour plus de sécurité)";
                passwordStrength.classList.add("text-warning");
                passwordStrength.classList.remove("text-danger", "text-success");
            break

            case 4:
            case 5:
                passwordStrength.textContent = "Forte";
                passwordStrength.classList.add("text-success");
                passwordStrength.classList.remove("text-danger", "text-warning");
            break

            default:
                passwordStrength.textContent = "";
        }
    }

    function validatePasswords() 
    {
        if (password.value === confirmPassword.value && password.value !== '')
        {
            passwordMatch.textContent = "Les mots de passes correspondent.";
            passwordMatch.classList.add("text-success");
            passwordMatch.classList.remove("text-danger");
            submitBtn.disabled = false;
        }
        else 
        {
            passwordMatch.textContent = "Les mots de passes ne correspondent pas.";
            passwordMatch.classList.add("text-danger");
            passwordMatch.classList.remove("text-success");
            submitBtn.disabled = true;
        }
    }

    password.addEvenListener('input', function() {
        checkPasswordStrength();
        validatePasswords();
    });

    confirmPassword.addEvenListener('input', validatePasswords);

})