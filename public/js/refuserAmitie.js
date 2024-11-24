document.getElementById('refuse-friend-request').addEventListener('click', function() {
    let requestId = this.dataset.requestId;

    fetch('/refuse-friend-request', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-Token': '{{ csrf_token("refuse_friend_request") }}' // Si vous utilisez un token CSRF
        },
        body: JSON.stringify({ requestId: requestId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Demande d\'amitié refusée.');
            // Vous pouvez également masquer le bouton ou modifier son texte
            document.getElementById('refuse-friend-request').style.display = 'none';
        } else {
            alert('Une erreur est survenue, veuillez réessayer.');
        }
    })
    .catch(error => console.error('Error:', error));
});