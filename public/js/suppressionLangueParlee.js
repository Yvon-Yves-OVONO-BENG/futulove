document.addEventListener('DOMContentLoaded', function() {
    const selectElement = document.querySelector('.select-langues');
    const selectedLanguagesDiv = document.getElementById('selected-languages');

    selectedLanguagesDiv.addEventListener('click', function(event) {
        if (event.target.classList.contains('language-item')) {
            const langue = event.target.getAttribute('data-langue');
            const options = Array.from(selectElement.options);

            // Désélectionner la langue dans la liste déroulante
            options.forEach(option => {
                if (option.value === langue) {
                    option.selected = false;
                }
            });

            // Supprimer la langue de l'affichage
            event.target.remove();
        }
    });

    // Si la sélection change dans la liste déroulante, mettre à jour l'affichage
    selectElement.addEventListener('change', function() {
        updateSelectedLanguages();
    });

    function updateSelectedLanguages() {
        const selectedOptions = Array.from(selectElement.selectedOptions)
            .map(option => <span class="language-item" data-langue="${option.value}">${option.textContent} ✖</span>)
            .join('');
        selectedLanguagesDiv.innerHTML = selectedOptions;
    }
});