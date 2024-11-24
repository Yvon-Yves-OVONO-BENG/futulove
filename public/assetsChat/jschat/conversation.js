// let idRouteAmi = document.getElementById("route_id");
// let chatBox = document.getElementById("chat_box");
// incoming_id = form.querySelector(".incoming_id").value,
// $(document).ready(function() {
//     $("#message_box").submit(function(e) {
//         e.preventDefault();
//         let url = e.currentTarget.action;
//          $.ajax({
//                 url: url,
//                 type: 'post',
//                 data: $("#message_box").serialize(),
//                 success: function(data) {
//                     $('#commentaire').html(data);
//                     $("#message_box")[0].reset();
//                     chatBox.scrollTop=document.chatBox;
                 

//                 },
//                 error: function(xhr, error){
//                     console.debug(xhr);
//                     console.debug(error);
//                 }
//             });

        
        
//         $.ajax({
//             url: idRouteAmi.getAttribute("data-path"),
//             method: "POST",
//             success: function (data) {
//                 document.getElementById("chat_liste").reset();
//                 // let objJSON = JSON.parse(data);
//                 // $("#texte2").text("Le prix du numero " + objJSON.numero + " est : " + objJSON.prix + " €");
//             }
//         });
            
//     });


   

//     //  setInterval(function(){
//     //     window.location.reload();
//     //     },1000);


//     // /////********ceci rafraichit la page en renvoyant les données */
//     // $("button").click(function() {
//     //     location.reload(true);
//     // })
//     // ////////////*********************************** */

//         // setInterval(function(e){
//         // let url = e.currentTarget.action;   
//         // $.ajax({
//         //     url: url,
//         //     data:{get:true},
//         //     method:'post',
//         //     success:function(data){
//         //       $('#chat_box').html(data);
//         //     }
//         // })
//         // },1000);

//         setInterval(() =>{
//             let xhr = new XMLHttpRequest();
//             xhr.open("POST", idRouteAmi.getAttribute("data-path"), true);
//             xhr.onload = ()=>{
//               if(xhr.readyState === XMLHttpRequest.DONE){
//                   if(xhr.status === 200){
//                     let data = xhr.response;
//                     chatBox.innerHTML = data;
//                     if(!chatBox.classList.contains("active")){
//                         scrollToBottom();
//                       }
//                   }
//               }
//             }
//             xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
//             xhr.send("incoming_id="+incoming_id);
//         }, 500);


//         // var xhr = new XMLHttpRequest(), monResultat; 
//         // xhr.open('POST', url); 
//         // xhr.onreadystatechange = function(){ 
//         //     if(xhr.readyState == 4 && xhr.status == 200){ 
//         //         monResultat = xhr.responseText; 
//         //         alert(monResultat); 
//         //     } 
//         // }; 
//         // xhr.send('variable=valeur'); 
//         // alert(monResultat);

//     return false;
// });






// // /**
// //  * @typedef {Object} MessageFormResponse
// //  * @property {string} code
// //  * @property {string} html
// //  */
// // const formAmi = document.querySelector('#ami_liste');
// // const messageList = document.querySelector('#chat_liste');
// // formAmi.addEventListener('submit', function (e) {
// //     e.preventDefault();

// //     fetch(this.action, {
// //         body: new FormData(e.target),
// //         method: 'POST'
// //     })
// //         .then(response => response.json())
// //         .then(json => {
// //             handleResponse(json);
// //         });
// // });

// // /**
// //  * @param {MessageFormResponse} response
// //  */
// // const handleResponse = function (response) {
// //     switch(response.code) {
// //         case 'MESSAGE_ADDED_SUCCESSFULLY':
// //             messageList.innerHTML += response.html;
// //             break;
        
// //     }
// // }


