document.getElementById('friend-request-btn-accepter-groupe').addEventListener('click', function() {
    const button = this;
    const membreGroupeId = button.getAttribute('data-membreGroupe-id');
    const csrfToken = button.getAttribute('data-csrf-token');
    let requestStatus = button.getAttribute('data-request-status');
    const idDiv = document.getElementById("demandeAjoutGroupe-" + membreGroupeId);
    console.log(idDiv);
    
    let url = '';
    switch (requestStatus) 
    {
        case 'accepter':
            url = '/futulove/public/groupe/accepter-demande-groupe/' + membreGroupeId; 
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
            // document.getElementById('friend-request-btn-refuser-groupe').style.display = 'none';
            // document.getElementById('friend-request-btn-accepter-groupe').style.display = 'none';
            document.getElementById("demandeAjoutGroupe-" + membreGroupeId).remove();
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
