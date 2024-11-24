document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.adore-button').forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();

            const url = e.currentTarget.getAttribute('data-url');
            const csrfToken = button.getAttribute('data-csrf-token');
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken  // Assurez-vous d'inclure un token CSRF
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.estAdore) {
                    e.currentTarget.classList.add('adore');
                } else {
                    e.currentTarget.classList.remove('adore');
                }
                
                e.currentTarget.querySelector('.adore-count').innerText = data.loveCount;
            })
            .catch(error => console.error('Error:', error));
        });
    });
});
