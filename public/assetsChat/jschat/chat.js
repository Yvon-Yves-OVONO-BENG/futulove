const form = document.querySelector(".typing-area"),
incoming_id = form.querySelector(".incoming_id").value,
inputField = form.querySelector(".chat_input"),
sendBtn = form.querySelector("button"),
chatBox = document.querySelector(".chat-box");
let idRouteMessage = document.getElementById("route_msg");
let idRouteAmi = document.getElementById("route_id");
form.onsubmit = (e)=>{
    e.preventDefault();
}

inputField.focus();
inputField.onkeyup = ()=>{
    if(inputField.value != ""){
        sendBtn.classList.add("active");
    }else{
        sendBtn.classList.remove("active");
    }
}

sendBtn.onclick = ()=>{
    let xhr = new XMLHttpRequest();
    console.log(id);
    xhr.open("POST", idRouteMessage.getAttribute("data-path"), true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
              inputField.value = "";
              scrollToBottom();
          }
      }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}
chatBox.onmouseenter = ()=>{
    chatBox.classList.add("active");
}

chatBox.onmouseleave = ()=>{
    chatBox.classList.remove("active");
}

setInterval(() =>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", idRouteAmi.getAttribute("data-path"), true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
            let data = xhr.response;
            chatBox.innerHTML = data;
            if(!chatBox.classList.contains("active")){
                scrollToBottom();
              }
          }
      }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("incoming_id="+incoming_id);
}, 500);

    // setInterval(function(){   
    //     $.ajax({
    //         url: idRouteAmi.getAttribute("data-path"),
    //         data:{get:true},
    //         method:'post',
    //         success:function(data){
    //             $('#ChatBody').html(data);
    //         }
    //     })
    // },500);

function scrollToBottom(){
    chatBox.scrollTop = chatBox.scrollHeight;
  }
  