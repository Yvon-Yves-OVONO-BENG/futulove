let lienBoutonBloquer = document.getElementById('butonBloquer');

function onClickBtnBloquer(event)
{
    event.preventDefault();

    const url = this.href;

    const icone = this.querySelector('i');

    axios.get(url).then(function(response)
    {
        console.log(response);

        if(icone.classList.contains('icofont-close'))
        {
            icone.classList.replace('icofont-close', 'icofont-check');
            lienBoutonBloquer.childNodes[2].nodeValue = " Débloquer";
            lienBoutonSuspendre.classList.value = "btn btn-success";
        }
        else
        {
            icone.classList.replace('icofont-check', 'icofont-close');
            lienBoutonBloquer.childNodes[2].nodeValue = " Bloquer";
            lienBoutonSuspendre.classList.value = "btn btn-danger";
        } 
    })
}

lienBoutonBloquer.addEventListener('click', onClickBtnBloquer);
