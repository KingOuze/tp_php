// script.js

document.addEventListener('DOMContentLoaded', function() {
    // Obtenir les éléments du formulaire
    const emailField = document.getElementById('email');
    const passwordField = document.getElementById('password');
    const loginButton = document.getElementById('login-button');

    // Fonction pour vérifier si tous les champs sont remplis
    function checkFormCompletion() {
        if (emailField.value.trim() && passwordField.value.trim()) {
            loginButton.disabled = false; // Activer le bouton si tous les champs sont remplis
        } else {
            loginButton.disabled = true; // Désactiver le bouton si un champ est vide
        }
    }

    // Ajouter des événements pour vérifier les champs à chaque modification
    emailField.addEventListener('input', checkFormCompletion);
    passwordField.addEventListener('input', checkFormCompletion);
});



