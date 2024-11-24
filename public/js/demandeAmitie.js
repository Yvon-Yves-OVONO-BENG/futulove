document.getElementById('friend-request-btn').addEventListener('click', function() {
    const button = this;
    const memberId = button.getAttribute('data-member-id');
    const csrfToken = button.getAttribute('data-csrf-token');
    let requestStatus = button.getAttribute('data-request-status');
    
    let url = '';
    switch (requestStatus) 
    {
        case 'not_sent':
            url = '/futulove/public/amitie/demande-amitie/' + memberId; 
            break;
    
        case 'sent':
            url = '/futulove/public/amitie/annuler-amitie/' + memberId; 
            break;
        
        case 'pending':
            url = '/futulove/public/amitie/refuser-amitie/' + memberId; 
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
            if (requestStatus === 'not_sent') {
                button.setAttribute('data-request-status', 'sent');
                button.classList.remove('btn-success');
                button.classList.add('btn-danger');
                button.textContent = 'Annuler la demande';
            } 
            else if(requestStatus === 'pending')
            {
                document.getElementById('friend-request-btn').style.display = 'none';
                document.getElementById('friend-request-btn-accepter').style.display = 'none';
            }
            else {
                button.setAttribute('data-request-status', 'not_sent');
                button.classList.remove('btn-danger');
                button.classList.add('btn-success');
                button.textContent = "Demander d'amitié";

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

document.getElementById('friend-request-btn-accepter').addEventListener('click', function() {
    const button = this;
    const memberId = button.getAttribute('data-member-id');
    const csrfToken = button.getAttribute('data-csrf-token');
    let requestStatus = button.getAttribute('data-request-status');
    
    let url = '';
    switch (requestStatus) 
    {
        case 'accepter':
            url = '/futulove/public/amitie/accepter-amitie/' + memberId; 
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
            document.getElementById('friend-request-btn').style.display = 'none';
            document.getElementById('friend-request-btn-accepter').style.display = 'none';
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

///////////////////////////////////////




