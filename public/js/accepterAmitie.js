
function onClickBtnAccepterAmitie(event)
{
    event.preventDefault();

    const url = this.href;
    const icone = this.querySelector('i');
    const parent = this.parentNode;
    const message = this.parentNode.parentNode.querySelector('#vousEtesDesormaisAmis');
    const parentBouton = this.parentNode.parentNode;

    parent.style.display = "none";
    message.style.display = "";

    axios.get(url).then(function(response)
    {

        console.log(response);

        if(icone.classList.contains('icofont-check'))
        {
            icone.classList.replace('icofont-check', 'icofont-close');
        }
        else
        {
            icone.classList.replace('icofont-close', 'icofont-check');
        } 


    })
}


document.querySelectorAll('a.lienAccepterAmitie').forEach(function(link)
{
    link.addEventListener('click', onClickBtnAccepterAmitie);

})