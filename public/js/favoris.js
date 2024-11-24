let lienBoutonFavori = document.getElementById('butonFavori');

function onClickBtnFavori(event)
{
    event.preventDefault();

    const url = this.href;

    const icone = this.querySelector('i');

    
    // console.log(icone);

    axios.get(url).then(function(response)
    {
        console.log(response);

        if(icone.classList.contains('icofont-heart'))
        {
            icone.classList.replace('icofont-heart', 'icofont-heart-alt');
            lienBoutonFavori.childNodes[2].nodeValue = " Supprimer de mes favoris";
            // lienBoutonFavori.classList.value = "btn btn-outline-danger js-favori";
        }
        else
        {
            icone.classList.replace('icofont-heart-alt', 'icofont-heart');
            lienBoutonFavori.childNodes[2].nodeValue = " Ajouter à mes favoris";
            // lienBoutonFavori.classList.value = "btn btn-outline-primary js-favori";
        } 
    })
}

// let button = document.querySelector('a.js-favori') ;
lienBoutonFavori.addEventListener('click', onClickBtnFavori);

// document.querySelector('a.js-favori').forEach(function(link)
// {
//     link.addEventListener('click', onClickBtnFavori);
// })



