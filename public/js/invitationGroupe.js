document.addEventListener('DOMContentLoaded', (event) => {
    document.querySelectorAll('.envoyer-invitation').forEach(button => {
        button.addEventListener('click', function () {
            const groupeId = this.dataset.groupeId;
            const userId = this.dataset.userId;
            const csrfToken = this.dataset.csrfToken;

            fetch('/futulove/public/groupe/inviter-groupe/' + groupeId + '/' + userId, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken // Assurez-vous de générer un jeton CSRF pour la sécurité
                },
                //body: JSON.stringify({user_id: userId})
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    button.setAttribute('data-request-status', 'sent');
                    button.classList.remove('btn-success');
                    button.classList.remove('envoyer-invitation');
                    button.classList.add('btn-danger');
                    button.classList.add('btn-sm');
                    button.classList.add('annuler-invitation');
                    button.textContent = 'Annuler l\'invitation';

                    //alert(data.message);
                    location.reload(); // Recharge partiellement la page, vous pouvez le remplacer par une mise à jour dynamique
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });

    document.querySelectorAll('.annuler-invitation').forEach(button => {
        button.addEventListener('click', function () {
            const groupeId = this.dataset.groupeId;
            const userId = this.dataset.userId;
            const csrfToken = this.dataset.csrfToken;

            fetch('/futulove/public/groupe/annuler-invitation/' + groupeId + '/' + userId, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken // Assurez-vous de générer un jeton CSRF pour la sécurité
                },
                //body: JSON.stringify({user_id: userId})
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    button.classList.remove('btn-danger');
                    button.classList.remove('annuler-invitation');
                    button.classList.add('btn-success');
                    button.classList.add('btn-sm');
                    button.classList.add('envoyer-invitation');
                    button.textContent = "Inviter";
                    //alert(data.message);
                    location.reload(); // Recharge partiellement la page, vous pouvez le remplacer par une mise à jour dynamique
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
});
