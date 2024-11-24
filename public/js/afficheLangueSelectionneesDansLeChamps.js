document.addEventListener('DOMContentLoaded', function() {
    const selectElement = document.querySelector('.select-langues');
    
    selectElement.addEventListener('change', function(event) {
        const selectedOptions = Array.from(selectElement.selectedOptions)
            .map(option => option.text)
            .join(', ');

        // Afficher la sélection
        console.log('Langues sélectionnées:', selectedOptions);

        // Mettre à jour l'affichage, par exemple dans un élément dédié
        document.querySelector('#selected-languages').textContent = selectedOptions;
    });

    // Si vous voulez afficher les langues déjà sélectionnées à l'ouverture
    const initialSelectedOptions = Array.from(selectElement.selectedOptions)
        .map(option => option.text)
        .join(', ');

    document.querySelector('#selected-languages').textContent = initialSelectedOptions;
});
