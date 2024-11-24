function closeModal() {
    document.getElementById('edit-comment-modal').style.display = 'none';
    document.getElementById('modal-overlay').style.display = 'none';
}

document.querySelectorAll('.edit-comment').forEach(button => {
    button.addEventListener('click', function() {
        const commentId = this.getAttribute('data-id');
        
        // Récupérer le contenu du commentaire via AJAX
        fetch(`/futulove/public/commentaire/commentaire-edit/${commentId}/edit`)
            .then(response => response.json())
            .then(data => {
                // Remplir le textarea avec le contenu du commentaire
                document.getElementById('edit-comment-textarea').value = data.commentContent;
                document.getElementById('edit-comment-modal').style.display = 'block';
                
                // Mettre à jour l'action du formulaire
                document.getElementById('edit-comment-form').onsubmit = function(event) {
                    event.preventDefault();
                    // Envoyer la modification via AJAX
                    updateComment(commentId);
                };
            });
    });
});

function updateComment(commentId) {
    const commentContent = document.getElementById('edit-comment-textarea').value;

    fetch(`/futulove/public/commentaire/commentaire-update/${commentId}/update`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-Token': '{{ csrf_token("edit_comment") }}'
        },
        body: JSON.stringify({ content: commentContent })
    })
    .then(response => response.json())
    .then(data => {
        // Mettre à jour le contenu du commentaire sur la page sans recharger
        // closeModal();
        // document.getElementById('modal-overlay').style.display = 'none';
        document.getElementById('edit-comment-modal').style.display = 'none';
        location.reload();
        document.querySelector(`#comment-content-${commentId}`).innerText = data.newContent;
    });
}