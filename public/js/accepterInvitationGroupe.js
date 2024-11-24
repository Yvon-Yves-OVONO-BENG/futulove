document.addEventListener('DOMContentLoaded', (event) => {
    document.querySelectorAll('.accepter-invitation-groupe').forEach(button => {
        button.addEventListener('click', function () {
            const groupeId = this.dataset.groupeId;
            const userId = this.dataset.userId;
            const csrfToken = this.dataset.csrfToken;
            const idDiv = document.getElementById("invitation-groupe-" + groupeId);
            console.log(idDiv);
            
            fetch('/futulove/public/groupe/accepter-invitation-groupe/' + groupeId + '/' + userId, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    //alert(data.message);
                    document.getElementById("invitation-groupe-" + groupeId).remove(); // Supprime l'invitation de l'interface
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });

    document.querySelectorAll('.refuser-invitation-groupe').forEach(button => {
        button.addEventListener('click', function () {
            const groupeId = this.dataset.groupeId;
            const userId = this.dataset.userId;
            const csrfToken = this.dataset.csrfToken;
            
            
            fetch('/futulove/public/groupe/annuler-invitation/' + groupeId + '/' + userId, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    //alert(data.message);
                    document.getElementById("invitation-groupe-" + groupeId).remove(); // Supprime l'invitation de l'interface
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
});