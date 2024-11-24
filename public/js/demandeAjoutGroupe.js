document.getElementById('friend-request-btn').addEventListener('click', function() {
    const button = this;
    const groupeId = button.getAttribute('data-groupe-id');
    const csrfToken = button.getAttribute('data-csrf-token');
    let requestStatus = button.getAttribute('data-request-status');
    var icon = document.getElementById('icon');
    
    let url = '';
    switch (requestStatus) 
    {
        case 'pasEnvoye':
            url = '/futulove/public/groupe/demande-ajout-groupe/' + groupeId; 
            break;
    
        case 'envoye':
            url = '/futulove/public/groupe/annuler-demande/' + groupeId; 
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
            if (requestStatus === 'pasEnvoye') {
                button.setAttribute('data-request-status', 'envoye');
                button.classList.remove('btn-success');
                button.classList.add('btn-danger');
                button.classList.add('btn-sm');
                button.textContent = 'Annuler la demande';
            } 
            else {
                button.setAttribute('data-request-status', 'pasEnvoye');
                button.classList.remove('btn-danger');
                button.classList.add('btn-success');
                button.classList.add('btn-sm');
                button.textContent = "Demande d'ajout";

            }
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