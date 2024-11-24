/**
 *
 * @typedef {Object} VideoFormResponse
 * @property {string} code
 * @property {Object} errors
 * @property {string} html
 */

const formProfil = document.querySelector('#formProfil');
console.log(formProfil);
formProfil.addEventListener('submit', function (e) {
    e.preventDefault();
    fetch(this.action, {
        body: new FormData(e.target),
        method: 'POST'
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
const handleResponse = function (response) {
    removeErrors();
    switch(response.code) {
        case 'PHOTO_ADDED_SUCCESSFULLY':
            videosList.innerHTML += response.html;
            break;
        case 'PHOTO_INVALID_FORM':
            handleErrors(response.errors);
            break;
    }
}

const removeErrors = function() {
    const invalidFeedbackElements = document.querySelectorAll('.invalid-feedback');
    const isInvalidElements = document.querySelectorAll('.is-invalid');

    invalidFeedbackElements.forEach(errorElement => errorElement.remove());
    isInvalidElements.forEach(isInvalidElement => isInvalidElement.classList.remove('is-invalid'));
}

/**
 *
 * @param {Object} errors
 */
const handleErrors = function(errors) {
    if (errors.length === 0) return;

    for (const key in errors) {
        let element = document.querySelector(`#video_${key}`);
        element.classList.add('is-invalid');

        let div = document.createElement('div');
        div.classList.add('invalid-feedback', 'd-block');
        div.innerText = errors[key];

        element.after(div);
    }
}