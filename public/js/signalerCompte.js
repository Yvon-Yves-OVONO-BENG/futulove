document.getElementById('signalement-request-btn').addEventListener('click', function() {
    const button = this;
    const memberId = button.getAttribute('data-member-id');
    const csrfToken = button.getAttribute('data-csrf-token');
    let requestStatus = button.getAttribute('data-request-status');
    
    let url = '';
    switch (requestStatus) 
    {
        case 'ajouterSignalement':
            url = '/futulove/public/signalement/signaler/' + memberId; 
            break;

        case 'supprimerSignalement':
            url = '/futulove/public/signalement/designaler/' + memberId; 
            break;

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
            if (requestStatus === 'supprimerSignalement') {
                button.setAttribute('data-request-status', 'ajouterSignalement');
                button.classList.add('btn-danger');
                button.classList.remove('btn-success');
                button.textContent = 'Signaler';
            } 
            else if(requestStatus === 'ajouterSignalement')
            {
                button.setAttribute('data-request-status', 'supprimerSignalement');
                button.classList.remove('btn-danger');
                button.classList.add('btn-success');
                button.textContent = "Annuler le signalement";
            }
        } else {
            // alert('Une erreur est survenu, veuillez réessayer.');
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert(data.message);
    });
});
