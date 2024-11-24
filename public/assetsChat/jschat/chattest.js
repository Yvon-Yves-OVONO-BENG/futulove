// /**
//  * Codons un chat en HTML/CSS/Javascript avec nos amis PHP et MySQL
//  */

// /**
//  * Il nous faut une fonction pour récupérer le JSON des
//  * messages et les afficher correctement
//  */
// function getMessages(){
//     // 1. Elle doit créer une requête AJAX pour se connecter au serveur, et notamment au fichier handler.php
//     const requeteAjax = new XMLHttpRequest();
  
//     let idRouteMessage = document.getElementById("id_message");
//     let idUser = document.getElementById("id_user").getAttribute("data-path");
//     requeteAjax.open("POST", idRouteMessage.getAttribute("data-path"));
   
//     // 2. Quand elle reçoit les données, il faut qu'elle les traite (en exploitant le JSON) et il faut qu'elle affiche ces données au format HTML
//     requeteAjax.onload = function(){
//       const resultat = JSON.parse(requeteAjax.responseText);
    
//       const html = resultat.reverse().map(function(message){
       
//         if (message.envoyePar == idUser) {
//           return `
//           <div class="d-flex justify-content-end text-end mb-1">
//             <div class="w-100">
//               <div class="d-flex flex-column align-items-end">
//                 <div class="bg-primary text-white p-2 px-3 rounded-2"> ${message.contenu}</div>
//                 <div class="d-flex my-2">
//                   <div class="small text-secondary">${message.duree}</div>
//                   <div class="small ms-2"><i class="fa-solid fa-check"></i></div>
//                 </div>
//               </div>
//             </div>
//             <div class="flex-shrink-0 avatar avatar-xs me-2">
//               <img class="avatar-img rounded-circle" src="images/photoProfils/${message.photoEnvoyePar}" alt="">
//             </div>
//           </div>
//         `
//         } else {
//           return `
//           <div class="d-flex mb-2">
//             <div class="flex-shrink-0 avatar avatar-xs me-2">
//               <img class="avatar-img rounded-circle" src="images/photoProfils/${message.photoEnvoyeA}" alt="">
//             </div>
//             <div class="flex-grow-1">
//               <div class="w-100">
//                 <div class="d-flex flex-column align-items-start">
//                   <div class="bg-light text-secondary p-2 px-3 rounded-2"> ${message.contenu}</div>
//                   <div class="d-flex my-2">
//                     <div class="small text-secondary">${message.duree}</div>
//                     <div class="small ms-2"><i class="fa-solid fa-check"></i></div>
//                   </div>
//                 </div>
//               </div>
//             </div>
//           </div>
//         `
//         }
       
//       }).join('');
//       const messages = document.querySelector('.messages');
  
//       messages.innerHTML = html;
//       messages.scrollTop = messages.scrollHeight;
//     }
  
//     // 3. On envoie la requête
//     requeteAjax.send();
//   }
  
//   /**
//    * Il nous faut une fonction pour envoyer le nouveau
//    * message au serveur et rafraichir les messages
//    */
  
//   function postMessage(event){
//     // 1. Elle doit stoper le submit du formulaire
//     event.preventDefault();
  
//     // 2. Elle doit récupérer les données du formulaire
//     const author = document.querySelector('#author');
//     const content = document.querySelector('#content');
  
//     // 3. Elle doit conditionner les données
//     const data = new FormData();
//     data.append('author', author.value);
//     data.append('content', content.value);
  
//     // 4. Elle doit configurer une requête ajax en POST et envoyer les données
//     const requeteAjax = new XMLHttpRequest();
//     let idRouteMessage = document.getElementById("commentform");
//     requeteAjax.open('POST', idRouteMessage.getAttribute("action"));
    
//     requeteAjax.onload = function(){
//       content.value = '';
//       content.focus();
//       getMessages();
//     }
  
//     requeteAjax.send(data);
//   }
  
  
// document.querySelectorAll('form.envoiMessage').forEach(function(form)
// {
//     form.addEventListener('submit', postMessage);

// })

//   // document.querySelector('form').addEventListener('submit', postMessage);
  
//   /**
//    * Il nous faut une intervale qui demande le rafraichissement
//    * des messages toutes les 3 secondes et qui donne 
//    * l'illusion du temps réel.
//    */
//   const interval = window.setInterval(getMessages, 1000);
  
//   getMessages();