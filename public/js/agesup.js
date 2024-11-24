let agemin = document.getElementById("agemin");
agemin.addEventListener("change",() => {
    let div = document.getElementById("agesup");
    const data = new FormData();
    data.append('ageMinimum', agemin.value);
    const requeteAjax = new XMLHttpRequest();
    requeteAjax.open("POST", div.getAttribute("data-path"));
    requeteAjax.onload = function(){
        console.log(agemin.value);
        const resultat = JSON.parse(requeteAjax.responseText);
        let option = '<option value="">Sélectionner</option>';
        const html = resultat.reverse().map(function(age){
        if (age) {
            return `
                <option value="${ age.id}">${ age.age }</option>
            `
        } 
        }).join('');
        const ages = document.getElementById("agemax");
        option += html;
        ages.innerHTML = option;
        ages.scrollTop = ages.scrollHeight;
    }
    requeteAjax.send(data);
})