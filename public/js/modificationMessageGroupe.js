function closeModal() {
    document.getElementById('edit-message-modal').style.display = 'none';
    document.getElementById('modal-overlay').style.display = 'none';
}

document.querySelectorAll('.edit-message').forEach(button => {
    button.addEventListener('click', function() {
        const messageId = this.getAttribute('data-id');
        
        console.log(messageId);
        // Récupérer le contenu du messageGroupe via AJAX
        fetch(`/futulove/public/groupe/message-groupe-edit/${messageId}/edit`)
            .then(response => response.json())
            .then(data => {
                
                // Remplir le textarea avec le contenu du messageGroupe
                document.getElementById('edit-message-textarea').value = data.messageGroupeContent;
                document.getElementById('edit-message-modal').style.display = 'block';
                
                // Mettre à jour l'action du formulaire
                document.getElementById('edit-message-form').onsubmit = function(event) {
                    event.preventDefault();
                    // Envoyer la modification via AJAX
                    miseAjourMessage(messageId);
                };
            });
    });
});

function miseAjourMessage(messageId) {
    const messageGroupeContent = document.getElementById('edit-message-textarea').value;
    const csrfToken = document.getElementById('csrf_token');

    fetch(`/futulove/public/groupe/message-groupe-update/${messageId}/update`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-Token': csrfToken
        },
        body: JSON.stringify({ content: messageGroupeContent })
    })
    .then(response => response.json())
    .then(data => {
        // Mettre à jour le contenu du messageGroupe sur la page sans recharger
        // closeModal();
        // document.getElementById('modal-overlay').style.display = 'none';
        document.getElementById('edit-message-modal').style.display = 'none';
        location.reload();
        document.querySelector(`#message-content-${messageId}`).innerText = data.newContent;
    });
}