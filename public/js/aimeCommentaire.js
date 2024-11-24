document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.like-button').forEach(button => {
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
                if (data.estAime) {
                    e.currentTarget.classList.add('aime');
                } else {
                    e.currentTarget.classList.remove('aime');
                }
                
                e.currentTarget.querySelector('.like-count').innerText = data.likeCount;
            })
            .catch(error => console.error('Error:', error));
        });
    });
});
