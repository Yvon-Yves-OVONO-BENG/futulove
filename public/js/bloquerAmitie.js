document.querySelectorAll('.block-button').forEach(button => {
    button.addEventListener('click', function() {
        let memberId = this.dataset.memberId;
        const csrfToken = button.getAttribute('data-csrf-token');
        
        
        fetch('/futulove/public/amitie/bloquer-amitie', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-Token': csrfToken // Si vous utilisez un token CSRF
            },
            body: JSON.stringify({ memberId: memberId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                this.textContent = 'Débloquer';
                this.classList.add('btn-success');
                this.classList.remove('btn-danger');
                this.classList.remove('block-button');
                this.classList.add('unblock-button');
            } else {
                alert('Erreur lors du blocage.');
            }
        })
        .catch(error => console.error('Error:', error));
    });
});

document.querySelectorAll('.unblock-button').forEach(button => {
    button.addEventListener('click', function() {
        let memberId = this.dataset.memberId;
        const csrfToken = button.getAttribute('data-csrf-token');
        fetch('/futulove/public/amitie/debloquer-amitie', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-Token': csrfToken // Si vous utilisez un token CSRF
            },
            body: JSON.stringify({ memberId: memberId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                this.textContent = 'Bloquer';
                this.classList.add('block-button');
                this.classList.add('btn-danger')
                this.classList.remove('unblock-button');
                this.classList.remove('btn-success')
            } else {
                alert('Erreur lors du déblocage.');
            }
        })
        .catch(error => console.error('Error:', error));
    });
});