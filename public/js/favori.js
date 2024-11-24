document.getElementById('favori-request-btn').addEventListener('click', function() {
    const button = this;
    const memberId = button.getAttribute('data-member-id');
    const csrfToken = button.getAttribute('data-csrf-token');
    let requestStatus = button.getAttribute('data-request-status');
    
    let url = '';
    switch (requestStatus) 
    {
        case 'ajouterFavori':
            url = '/futulove/public/favori/ajout-favori/' + memberId; 
            break;

        case 'supprimerFavori':
            url = '/futulove/public/favori/supprimer-favori/' + memberId; 
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
            if (requestStatus === 'supprimerFavori') {
                button.setAttribute('data-request-status', 'ajouterFavori');
                button.classList.add('btn-success');
                button.classList.remove('btn-danger');
                button.textContent = 'Ajouter dans mes favoris';
            } 
            else if(requestStatus === 'ajouterFavori')
            {
                button.setAttribute('data-request-status', 'supprimerFavori');
                button.classList.remove('btn-success');
                button.classList.add('btn-danger');
                button.textContent = "Supprimer de mes favoris";
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