document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('btn-debloquer-membre-groupe').addEventListener('click', function() {
    const button = this;
    const membreGroupeId = button.getAttribute('data-membreGroupe-id');
    const csrfToken = button.getAttribute('data-csrf-token');
    let requestStatus = button.getAttribute('data-request-status');
    console.log(requestStatus);
    
    let url = '';
    switch (requestStatus) 
    {
        case 'debloquer':
            url = '/futulove/public/groupe/debloquer-membre-groupe/' + membreGroupeId; 
            break

        case 'bloquer':
            url = '/futulove/public/groupe/bloquer-membre-groupe/' + membreGroupeId; 
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
            if (requestStatus === 'bloquer')
            {
                button.setAttribute('data-request-status', 'debloquer');
                button.classList.remove('btn-danger');
                button.classList.add('btn-success');
                button.classList.add('btn-sm');
                button.textContent = 'Débloquer';
            }
            else if (requestStatus === 'debloquer')
            {
                button.setAttribute('data-request-status', 'bloquer');
                button.classList.remove('btn-success');
                button.classList.add('btn-danger');
                button.classList.add('btn-sm');
                button.textContent = 'Bloquer';
            }
        } else {
            // alert('Une erreur est survenu, veuillez réessayer.');
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert('Une erreur est survenue, veuillez réessayer. ' + error);
    });
    });

});