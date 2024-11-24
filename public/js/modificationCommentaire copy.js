document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById("editCommentModal");
    const span = document.getElementsByClassName("close")[0];
    const editButtons = document.querySelectorAll('.edit-comment');
    const commentContent = document.getElementById('commentContent');
    const editForm = document.getElementById('editCommentForm');
    let currentCommentId;
    
    // Ouvrir la modale lorsque l'utilisateur clique sur "Modifier"
    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            currentCommentId = this.dataset.commentId;
            const commentText = document.getElementById('comment-${currentCommentId}').textContent;
            console.log('Comment ID', currentCommentId);
            console.log('Comment Text', commentText);
            
            commentContent.value = commentText;
            modal.style.display = "block";
        });
    });

    // Fermer la modale
    span.addEventListener('click', function () {
        modal.style.display = "none";
    });

    window.addEventListener('click', function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    });

    // Soumettre les modifications via AJAX
    // editForm.addEventListener('submit', function (event) {
    //     event.preventDefault();

    //     fetch(/comment/edit/${currentCommentId}, {
    //         method: 'POST',
    //         headers: {
    //             'Content-Type': 'application/json',
    //             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    //         },
    //         body: JSON.stringify({ content: commentContent.value })
    //     })
    //     .then(response => response.json())
    //     .then(data => {
    //         if (data.success) {
    //             document.getElementById('comment-${currentCommentId}').textContent = commentContent.value;
    //             modal.style.display = "none";
    //         } else {
    //             alert('Une erreur est survenue lors de la modification du commentaire.');
    //         }
    //     });
    // });

});