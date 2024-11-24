const listeAmi = document.querySelector('#listeAmi');
const messagesList = document.querySelector('#messagesList');

// console.log(listeAmi);
// console.log(messagesList);

listeAmi.addEventListener('click', function (e) {
    e.preventDefault();

    fetch(this.action, {
        // body: new FormData(e.target),
        // method: 'POST'
    })
        .then(response => response.json())
        .then(json => {
            handleResponse(json);
        });
});

/**
 *
 * @param {VideoFormResponse} response
 */
const handleResponse = function (response) 
{
    messagesList.innerHTML += response.html;
}
