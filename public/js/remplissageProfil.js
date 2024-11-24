document.addEventListener('DOMContentLoaded', function () {
    let currentStep = 1;
    const totalSteps = 5;
    
    document.querySelectorAll('.next-step').forEach(button => {
        button.addEventListener('click', function () {
            document.getElementById(`step-${currentStep}`).style.display = 'none';
            currentStep++;
            document.getElementById(`step-${currentStep}`).style.display = 'block';
        });
    });

    document.querySelectorAll('.prev-step').forEach(button => {
        button.addEventListener('click', function () {
            document.getElementById(`step-${currentStep}`).style.display = 'none';
            currentStep--;
            document.getElementById(`step-${currentStep}`).style.display = 'block';
        });
    });
});