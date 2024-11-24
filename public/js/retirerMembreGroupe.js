document.getElementById('btn-retirer-membre-groupe').addEventListener('click', function() {
    const button = this;
    const membreGroupeId = button.getAttribute('data-membreGroupe-id');
    const csrfToken = button.getAttribute('data-csrf-token');
    let requestStatus = button.getAttribute('data-request-status');
    
    let url = '';
    switch (requestStatus) 
    {
        case 'retirer':
            url = '/futulove/public/groupe/retirer-membre-groupe/' + membreGroupeId; 
            break

    }

    fetch(url, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken  // Assurez-vous d'inclure un token CSRF
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            button.style.display = 'none';
        } else {
            // alert('Une erreur est survenu, veuillez réessayer.');
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert('Une erreur est survenue, veuillez réessayer.');
    });
});
