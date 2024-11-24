let email = document.getElementById("email");
let route = document.getElementById("route");
const test = document.getElementById('test');
const connexion = document.getElementById('connexion');

document.addEventListener('DOMContentLoaded', function(){
    test.style.display = 'none';
    connexion.disabled = true;
    connexion.classList.add('disabled');
})

email.addEventListener('blur', function(){
    const data = new FormData();
    data.append('email', email.value);
    console.log(email.value);
    const requeteAjax = new XMLHttpRequest();
    requeteAjax.open("POST", route.getAttribute("data-path"));
    requeteAjax.onload = function(){
        const resultat = JSON.parse(requeteAjax.responseText);
        resultat.forEach(function(reponse){
            if (reponse.test == 0) {
                test.style.display = 'block';
                connexion.disabled = true;
                connexion.classList.add('disabled');
            }else{
                test.style.display = 'none'; 
                connexion.disabled = false;
                connexion.classList.add('disabled');
            }
        })
    }
    // On envoie la requête
    requeteAjax.send(data);
})

  