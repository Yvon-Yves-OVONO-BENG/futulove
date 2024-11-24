// function onClickLienConversation(event)
// {
//     event.preventDefault();
//     const url = this.href; 
//     // on créer une requête AJAX pour se connecter au serveur, et notamment au fichier handler.php
//     let requeteAjax = new XMLHttpRequest();
//     requeteAjax.open("POST", url);
//     requeteAjax.onload = function(){
       
//     }
//     requeteAjax.send();
    
//     let conteur = 0; 
//     let interval = window.setInterval(function(){
//         conteur++;
//         if (conteur === 1) {
//             window.clearInterval(interval);
//         }
        
//         // on créer une requête AJAX pour se connecter au serveur, et notamment au fichier handler.php
//         const requeteAjax = new XMLHttpRequest(); 
//         let idRouteMessage = document.getElementById("users-conversation");
//         let idUser = document.getElementById("id_user").getAttribute("data-path");
//         requeteAjax.open("POST", idRouteMessage.getAttribute("data-path"));
    
//         // on traite les données avant d'afficher au format HTML
//         requeteAjax.onload = function(){
//             const resultat = JSON.parse(requeteAjax.responseText);
    
//             const html = resultat.reverse().map(function(message){
//             let i = '';
//             if (message.estLu == 0) {
//                 i = '-double';
//             }
//             let cl = '';
//             let ph = '';
//             if (message.envoyePar == idUser) {
//                 cl = 'right';
//                 ph = '<div class="ctext-wrap"><div class="chat-avatar"><img src="images/photoProfils/' + message.photoEnvoyePar + '" alt=""></div>'
//             } else {
//                 cl = 'left';
//                 ph = '<div class="ctext-wrap"><div class="chat-avatar"><img src="images/photoProfils/' + message.photoEnvoyeA + '" alt=""></div>'
//             }
          
//             if (message.image == null) {
//                 return `
//                     <li class="chat-list ${cl}" id="chat-list-' + messageIds + '" >
//                             <div class="conversation-list">
//                                 <div class="user-chat-content"> ${ph}
//                                         <div class="ctext-wrap-content">
//                                             <p class="mb-0 ctext-content">${message.contenu}</p>
//                                         </div>
//                                         <div class="dropdown align-self-start message-box-drop">
//                                             <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
//                                                 <i class="ri-more-2-fill"></i>
//                                             </a>
//                                             <div class="dropdown-menu">
//                                                 <a class="dropdown-item d-flex align-items-center justify-content-between reply-message" href="#" data-bs-toggle="collapse" data-bs-target=".replyCollapse">Reply <i class="bx bx-share ms-2 text-muted"></i></a>
//                                                 <a class="dropdown-item d-flex align-items-center justify-content-between" href="#" data-bs-toggle="modal" data-bs-target=".forwardModal">Forward <i class="bx bx-share-alt ms-2 text-muted"></i></a>
//                                                 <a class="dropdown-item d-flex align-items-center justify-content-between copy-message" href="#" id="copy-message-' + messageIds +'">Copy <i class="bx bx-copy text-muted ms-2"></i></a>
//                                                 <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Bookmark <i class="bx bx-bookmarks text-muted ms-2"></i></a>
//                                                 <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Mark as Unread <i class="bx bx-message-error text-muted ms-2"></i></a>
//                                                 <div class="dropdown-item d-flex align-items-center justify-content-between delete-item" id="liste-message">
//                                                     <a class="selection-message" id="${message.id}" href="message-supprimer/${message.id}">Delete <i class="bx bx-trash text-muted ms-2"></i></a>
//                                                 </div>
//                                             </div>
//                                         </div>
//                                     </div>
//                                     <div class="conversation-name">
//                                         <small class="text-muted time">${message.duree}</small>
//                                         <span class="text-success check-message-icon"><i class="bx bx-check${i}"></i></span>\
//                                     </div>
//                                 </div>
//                             </div>
//                         </li>
//                     `
//             } else {
//                 return `
//                 <li class="chat-list ${cl}" id="chat-list-' + messageIds + '" >
//                 <div class="ctext-wrap">
//                     <div class="message-img mb-0">
//                     <div class="message-img-list">
//                             <div>
//                             <a class="popup-img d-inline-block" href="images/imageChat/${message.image}">
//                                 <img src="images/imageChat/${message.image}" alt="" class="rounded border" width="100px" height="100px">
//                             </a>
//                             </div>
//                             <div class="message-img-link">
//                             <ul class="list-inline mb-0">
//                                 <li class="list-inline-item dropdown">
//                                     <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
//                                         <i class="bx bx-dots-horizontal-rounded"></i>
//                                     </a>
//                                     <div class="dropdown-menu">
//                                         <a class="dropdown-item d-flex align-items-center justify-content-between" href="images/imageChat/${message.image}" download>Download <i class="bx bx-download ms-2 text-muted"></i></a>
//                                         <a class="dropdown-item d-flex align-items-center justify-content-between"  href="#" data-bs-toggle="collapse" data-bs-target=".replyCollapse">Reply <i class="bx bx-share ms-2 text-muted"></i></a>
//                                         <a class="dropdown-item d-flex align-items-center justify-content-between" href="#" data-bs-toggle="modal" data-bs-target=".forwardModal">Forward <i class="bx bx-share-alt ms-2 text-muted"></i></a>
//                                         <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Bookmark <i class="bx bx-bookmarks text-muted ms-2"></i></a>
//                                         <div class="dropdown-item d-flex align-items-center justify-content-between delete-item" id="liste-message">
//                                             <a class="selection-message" href="message-supprimer/${message.id}">Delete <i class="bx bx-trash ms-2 text-muted"></i></a>
//                                         </div>
//                                     </div>
//                                 </li>
//                             </ul>
//                         </div>
//                         <div class="conversation-name">
//                             <span class="text-success check-message-icon"><i class="bx bx-check${i}"></i></span>\
//                             <small class="text-muted time">${message.duree}</small>
//                         </div>
//                     </div>
//                 </div>
//                 </li>
//                 `
//             }
    
            
//             }).join('');
//             const messages = document.querySelector("#users-conversation");
//             messages.innerHTML = html;
//             messages.scrollTop = messages.scrollHeight;
    
//             //on écoute la suppression
//             let listemessage = document.querySelectorAll("a.selection-message");
//             listemessage.forEach(function(link)
//             {
//                 link.addEventListener('click', onClickLienMessage);
    
//             }) 
//         }
//         // On envoie la requête
//         requeteAjax.send();
//     }, 50);

   

// }


// document.querySelectorAll('a.selectionConversation').forEach(function(link)
// {
//     link.addEventListener('click', onClickLienConversation);
 

// })

let links = document.querySelectorAll('.selectionConversation');
links.forEach(link => {
    link.addEventListener('click', function(event) {
        event.preventDefault();
        const url = this.href;
        let conteur = 0; 
        let interval = window.setInterval(function(){
            conteur++;
            if (conteur === 1) {
                window.clearInterval(interval);
            }
            getMessages(url);
        }, 0);
    })
})


function getMessages(url){
    // on créer une requête AJAX pour se connecter au serveur, et notamment au fichier handler.php
    let requeteAjax = new XMLHttpRequest();
    let idUser = document.getElementById("id_user").getAttribute("data-path");
    requeteAjax.open("POST", url);
    
    // on traite les données avant d'afficher au format HTML
    requeteAjax.onload = function(){
        console.log(url);
        const resultat = JSON.parse(requeteAjax.responseText);
        const html = resultat.reverse().map(function(message){
        let i = '';
        if (message.estLu == 0) {
            i = '-double';
        }
        let cl = '';
        let ph = '';
        if (message.envoyePar == idUser) {
            cl = 'right';
            ph = '<div class="ctext-wrap"><div class="chat-avatar"><img src="images/photoProfils/' + message.photoEnvoyePar + '" alt=""></div>'
        } else {
            cl = 'left';
            ph = '<div class="ctext-wrap"><div class="chat-avatar"><img src="images/photoProfils/' + message.photoEnvoyeA + '" alt=""></div>'
        }
      
        if (message.image == null) {
            return `
                <li class="chat-list ${cl}" id="chat-list-' + messageIds + '" >
                        <div class="conversation-list">
                            <div class="user-chat-content"> ${ph}
                                    <div class="ctext-wrap-content">
                                        <p class="mb-0 ctext-content">${message.contenu}</p>
                                    </div>
                                    <div class="dropdown align-self-start message-box-drop">
                                        <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="ri-more-2-fill"></i>
                                        </a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item d-flex align-items-center justify-content-between reply-message" href="#" data-bs-toggle="collapse" data-bs-target=".replyCollapse">Reply <i class="bx bx-share ms-2 text-muted"></i></a>
                                            <a class="dropdown-item d-flex align-items-center justify-content-between" href="#" data-bs-toggle="modal" data-bs-target=".forwardModal">Forward <i class="bx bx-share-alt ms-2 text-muted"></i></a>
                                            <a class="dropdown-item d-flex align-items-center justify-content-between copy-message" href="#" id="copy-message-' + messageIds +'">Copy <i class="bx bx-copy text-muted ms-2"></i></a>
                                            <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Bookmark <i class="bx bx-bookmarks text-muted ms-2"></i></a>
                                            <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Mark as Unread <i class="bx bx-message-error text-muted ms-2"></i></a>
                                            <div class="dropdown-item d-flex align-items-center justify-content-between delete-item" id="liste-message">
                                                <a class="selection-message" id="${message.id}" href="message-supprimer/${message.id}">Delete <i class="bx bx-trash text-muted ms-2"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="conversation-name">
                                    <small class="text-muted time">${message.duree}</small>
                                    <span class="text-success check-message-icon"><i class="bx bx-check${i}"></i></span>\
                                </div>
                            </div>
                        </div>
                    </li>
                `
        } else {
            return `
            <li class="chat-list ${cl}" id="chat-list-' + messageIds + '" >
            <div class="ctext-wrap">
                <div class="message-img mb-0">
                <div class="message-img-list">
                        <div>
                        <a class="popup-img d-inline-block" href="images/imageChat/${message.image}">
                            <img src="images/imageChat/${message.image}" alt="" class="rounded border" width="100px" height="100px">
                        </a>
                        </div>
                        <div class="message-img-link">
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item dropdown">
                                <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item d-flex align-items-center justify-content-between" href="images/imageChat/${message.image}" download>Download <i class="bx bx-download ms-2 text-muted"></i></a>
                                    <a class="dropdown-item d-flex align-items-center justify-content-between"  href="#" data-bs-toggle="collapse" data-bs-target=".replyCollapse">Reply <i class="bx bx-share ms-2 text-muted"></i></a>
                                    <a class="dropdown-item d-flex align-items-center justify-content-between" href="#" data-bs-toggle="modal" data-bs-target=".forwardModal">Forward <i class="bx bx-share-alt ms-2 text-muted"></i></a>
                                    <a class="dropdown-item d-flex align-items-center justify-content-between" href="#">Bookmark <i class="bx bx-bookmarks text-muted ms-2"></i></a>
                                    <div class="dropdown-item d-flex align-items-center justify-content-between delete-item" id="liste-message">
                                        <a class="selection-message" href="message-supprimer/${message.id}">Delete <i class="bx bx-trash ms-2 text-muted"></i></a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="conversation-name">
                        <span class="text-success check-message-icon"><i class="bx bx-check${i}"></i></span>\
                        <small class="text-muted time">${message.duree}</small>
                    </div>
                </div>
            </div>
            </li>
            `
        }

        
        }).join('');
        const messages = document.querySelector("#users-conversation");
        messages.innerHTML = html;
        messages.scrollTop = messages.scrollHeight;

       
    }
    // On envoie la requête
    requeteAjax.send();

}

let listeconversation = document.getElementById('listeconversation');
    listeconversation.addEventListener('click', function(event) {
    sessionStorage.removeItem("destinataire");
    console.log('listeconversation');
});