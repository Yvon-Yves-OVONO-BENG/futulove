///////////////////FONCTION QUI RECUPPERE LES MESSAGES -DEBUT-//////////////////////////
function getMessages(){
    // on créer une requête AJAX pour se connecter au serveur, et notamment au fichier handler.php
    const requeteAjax = new XMLHttpRequest();

    let idRouteMessage = document.getElementById("users-conversation");

    let idUser = document.getElementById("id_user").getAttribute("data-path");
    requeteAjax.open("POST", idRouteMessage.getAttribute("data-path"));

    // on traite les données avant d'afficher au format HTML
    requeteAjax.onload = function(){
        const resultat = JSON.parse(requeteAjax.responseText);
        if (resultat.code) {
            console.log('success');
        }else{
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
        
                
            }
            ).join('');
            const messages = document.querySelector("#users-conversation");
            messages.innerHTML = html;
            messages.scrollTop = messages.scrollHeight;
        }
        //on écoute la suppression
        let listemessage = document.querySelectorAll("a.selection-message");
        listemessage.forEach(function(link)
        {
            link.addEventListener('click', onClickLienMessage);

        }) 
    }
    // On envoie la requête
    requeteAjax.send();

}
//On actualise la page des messages
const interval = window.setInterval(getMessages, 3000);
///////////////////FONCTION QUI RECUPPERE LES MESSAGES -FIN-////////////////////////////


///////////////////FONCTION QUI SUPPRIME LES MESSAGES -DEBUT-///////////////////////////
function onClickLienMessage(event)
{
    event.preventDefault();
    const url = this.href;
    $.ajax({
        url: url,
        type: 'post',
        data: $(".selection-message").serialize(),
        success: function(data) {
            $('#commentaire').html(data);
            
        },
        error: function(xhr, error){
            console.debug(xhr);
            console.debug(error);
        }
    });
}
///////////////////FONCTION QUI SUPPRIME LES MESSAGES -FIN-/////////////////////////////


////////////////////FONCTION QUI POSTE LES MESSAGES -DEBUT-/////////////////////////////
function postMessage(event){
    // On stope le submit du formulaire
    event.preventDefault();

    // on récpère les données du formulaire
    const author = document.querySelector('#author');
    const content = document.querySelector('#chat-input');
    const image = document.querySelector('#galleryfile-input').files[0];

    // On conditionne les données
    const data = new FormData();
    data.append('author', author.value);
    data.append('chat-input', content.value);
    data.append('image', image);

    // On configure une requête ajax en POST et envoyer les données
    const requeteAjax = new XMLHttpRequest();
    let idRouteMessage = document.getElementById("chatinput-form");
    requeteAjax.open('POST', idRouteMessage.getAttribute("action"));
    requeteAjax.onload = function(){
        content.value = '';
        content.focus();
        getMessages();
    }
    requeteAjax.send(data);
}
//On écoute le boubon de soumission des messages
document.querySelectorAll('form.envoiMessage').forEach(function(form)
{
    form.addEventListener('submit', postMessage);

})
////////////////////FONCTION QUI POSTE LES MESSAGES -FIN-/////////////////////////////



//////////////////////FONCTION QUI CHERCHE LES MESSAGES NON-LUS -DEBUT-//////////////////////////
function getMessagesNonLus(){
    const requeteAjax = new XMLHttpRequest();
    let idRouteAmi = document.getElementById("usersList");
    let iduserconnect = document.getElementById("iduserconnect");
    let smallid = document.getElementById("smallid");
    requeteAjax.open("POST", idRouteAmi.getAttribute("data-path"));
    requeteAjax.onload = function(){
        const resultat = JSON.parse(requeteAjax.responseText);
        //on écoute la liste des amis
        let listeamis = document.querySelectorAll('a.selectionConversation');
        const online = 'chat-user-img online align-self-center me-2 ms-0';
        const offline = 'chat-user-img offline align-self-center me-2 ms-0';
        const onlineselect = 'flex-shrink-0 chat-user-img online user-own-img align-self-center me-3 ms-0';
        const offlineselect = 'flex-shrink-0 chat-user-img offline user-own-img align-self-center me-3 ms-0';
       
        listeamis.forEach(function(link)
        {
            resultat.forEach(function(ami){
                if (ami.id == link.getAttribute('id')) {
                    link.children[0].children[2].children[0].textContent = ami.nonLu;
                }

                if (ami.id == link.getAttribute('id') && ami.enLigne == 0) {
                    link.children[0].children[0].setAttribute('class', online);
                }

                if (ami.id == link.getAttribute('id') && ami.enLigne == 1) {
                    link.children[0].children[0].setAttribute('class', offline);
                }

                if (ami.id == link.getAttribute('id') && ami.id == ami.destinataire && ami.enLigne == 0) {
                    iduserconnect.setAttribute('class', onlineselect);
                    smallid.textContent = 'En ligne';
                }

                if (ami.id == link.getAttribute('id') && ami.id == ami.destinataire && ami.enLigne == 1) {
                    iduserconnect.setAttribute('class', offlineselect);
                    smallid.textContent = 'Hors ligne';
                }
            })
        }) 
    }
    // On envoie la requête
    requeteAjax.send();
}
//On actualise la liste des messages non lus
const intervalMessagesNonLus = window.setInterval(getMessagesNonLus, 5000);
//////////////////////FONCTION QUI CHERCHE LES MESSAGES NON-LUS -FIN-//////////////////////////


////////////////////FONCTION QUI MET LES UTILISATEUR HORS LIGNE APRES UNE HEURE D'INACTIVITE -DEBUT-////////
function enLigne(){
    const div = document.getElementById('enligne');
    const requeteAjax = new XMLHttpRequest();
    requeteAjax.open('POST', div.getAttribute("data-path"));
    requeteAjax.onload = function(){
        console.log(div);
    }
    requeteAjax.send();
}
//balayage après 15min
const intervalEnligne = window.setInterval(enLigne, 900000);
////////////////////FONCTION QUI MET LES UTILISATEUR HORS LIGNE APRES UNE HEURE D'INACTIVITE -FIN-////////