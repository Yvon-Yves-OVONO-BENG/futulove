let lienBoutonSuspendre = document.getElementById('butonSuspendre');

function onClickBtnSuspendre(event)
{
    event.preventDefault();

    const url = this.href;

    const icone = this.querySelector('i');

    // console.log(icone);

    axios.get(url).then(function(response)
    {
        if(icone.classList.contains('icofont-close'))
        {
            icone.classList.replace('icofont-close', 'icofont-check');
            lienBoutonSuspendre.childNodes[2].nodeValue = " Activer mon compte";
            lienBoutonSuspendre.classList.value = "btn btn-success";
        }
        else
        {
            icone.classList.replace('icofont-check', 'icofont-close');
            lienBoutonSuspendre.childNodes[2].nodeValue = " Suspendre mon compte";
            lienBoutonSuspendre.classList.value = "btn btn-danger";
        } 
    })
}

lienBoutonSuspendre.addEventListener('click', onClickBtnSuspendre);