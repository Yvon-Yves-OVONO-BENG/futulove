// function onClickLienConversation(event)
// {
//     event.preventDefault();
//     const url = this.href;
//     $.ajax({
//         url: url,
//         type: 'post',
//         data: $(".selectionConversation").serialize(),
//         success: function(data) {
//             $('#commentaire').html(data);
//             getEntete();
//         },
//         error: function(xhr, error){
//             console.debug(xhr);
//             console.debug(error);
//         }
//     });

// }


// document.querySelectorAll('a.selectionConversation').forEach(function(link)
// {
//     link.addEventListener('click', onClickLienConversation);

// })


// function getEntete(){
//     // 1. Elle doit créer une requête AJAX pour se connecter au serveur, et notamment au fichier handler.php
//     const requeteAjax = new XMLHttpRequest();
//     let idRouteMembre = document.getElementById("id_entete");
//     requeteAjax.open("POST", idRouteMembre.getAttribute("data-path"));
//     console.log(idRouteMembre.getAttribute("data-path"));
    
//     // 2. Quand elle reçoit les données, il faut qu'elle les traite (en exploitant le JSON) et il faut qu'elle affiche ces données au format HTML
//     requeteAjax.onload = function(){
//       const resultat = JSON.parse(requeteAjax.responseText);
//       const html = resultat.reverse().map(function(destinataire){
//         if (destinataire.enligne == 0) {
//             return `
//               <div class="d-flex mb-2 mb-sm-0">
//                 <div class="flex-shrink-0 avatar me-2">
//                     <img class="avatar-img rounded-circle" src="images/photoProfils/${destinataire.photo}" alt="">
//                 </div>
//                 <div class="d-block flex-grow-1">
//                     <h6 class="mb-0 mt-1">${destinataire.nom}</h6>
//                     <div class="small text-secondary"><i class="fa-solid fa-circle text-success me-1"></i>Online</div>
//                 </div>
//             </div>
//             `
//         } else { 
//             return `
//             <div class="d-flex mb-2 mb-sm-0">
//             <div class="flex-shrink-0 avatar me-2">
//               <img class="avatar-img rounded-circle" src="images/photoProfils/${destinataire.photo}" alt="">
//             </div>
//             <div class="d-block flex-grow-1">
//               <h6 class="mb-0 mt-1">${destinataire.nom}</h6>
//               <div class="small text-secondary"><i class="fa-solid fa-circle text-danger me-1"></i>Last active 2 days</div>
//             </div>
//           </div>
//           `
//         }
//       }).join('');
//       const messages = document.querySelector('.infodestinataire');
  
//       messages.innerHTML = html;
//       messages.scrollTop = messages.scrollHeight;
//     }
  
//     // 3. On envoie la requête
//     requeteAjax.send();
//   }
  
