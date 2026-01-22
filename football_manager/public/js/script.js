// 2-JavaScript.pdf - Page 251 : Exemple de validation
function validerForm(event) {
    // On récupère tous les champs input du formulaire soumis
    let inputs = event.target.querySelectorAll('input');

    for (let i = 0; i < inputs.length; i++) {
        // Si un champ est vide
        if (inputs[i].value.trim() === "") {
            alert("Le champ " + inputs[i].name + " doit être saisi !");
            event.preventDefault(); // Empêcher l'envoi du formulaire (Page 242)
            return false;
        }
    }
    return true;
}

// Attendre que le DOM soit chargé (Page 205)
document.addEventListener("DOMContentLoaded", function () {
    // Sélectionner tous les formulaires
    let forms = document.querySelectorAll("form");

    // Ajouter l'écouteur d'événement sur chaque formulaire
    forms.forEach(function (form) {
        form.addEventListener("submit", validerForm);
    });

    // Mobile Menu Toggle
    const mobileBtn = document.getElementById('mobile-menu-btn');
    const sidebar = document.querySelector('.sidebar');

    if (mobileBtn) {
        mobileBtn.addEventListener('click', function () {
            sidebar.classList.toggle('active');
        });
    }
});
