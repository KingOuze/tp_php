// JavaScript pour basculer l'affichage du formulaire
document.getElementById('toggle-admin-form').addEventListener('click', function() {
    var form = document.getElementById('add-admin-form');
    if (form.classList.contains('hidden')) {
        form.classList.remove('hidden');
    } else {
        form.classList.add('hidden');
    }
});





let timerDisplay = document.getElementById('timer');
        let timeout;
        let timeLeft = 60; // Temps d'inactivité en secondes

        function resetTimer() {
            clearTimeout(timeout);
            timeLeft = 60;
            updateTimerDisplay();
            timeout = setTimeout(decrementTimer, 1000);
        }

        function decrementTimer() {
            timeLeft--;
            if (timeLeft <= 0) {
                timeLeft = 0;
                alert("Vous avez été inactif pendant 60 secondes.");
                window.location.href = '../login.php';
            }
            updateTimerDisplay();
            timeout = setTimeout(decrementTimer, 1000);
        }

        function updateTimerDisplay() {
            timerDisplay.textContent = `${timeLeft}`;
            if (timeLeft < 10) {
                timerDisplay.classList.add('urgent');
            } else {
                timerDisplay.classList.remove('urgent');
            }
        }

        document.addEventListener('mousemove', resetTimer);
        document.addEventListener('keydown', resetTimer);
        
        // Initial call to start the timer
        resetTimer();

        function showPopup() {
            var popup = document.getElementById('success-popup');
            var overlay = document.getElementById('popup-overlay');
        
            console.log(popup);  // Vérifier si l'élément est correctement sélectionné
            console.log(overlay); // Vérifier si l'élément est correctement sélectionné
        
            if (popup && overlay) {
                popup.style.display = 'block';  // Afficher le popup
                overlay.style.display = 'block'; // Afficher l'overlay
            }
        }
        
        function closePopup() {
            var popup = document.getElementById('success-popup');
            var overlay = document.getElementById('popup-overlay');
        
            if (popup && overlay) {
                popup.style.display = 'none';  // Masquer le popup
                overlay.style.display = 'none'; // Masquer l'overlay
            }
        }
        
        // Appeler showPopup si un message de succès est présent
        document.addEventListener('DOMContentLoaded', function() {
            var successMessage = "<?php echo addslashes($success_message); ?>";
            if (successMessage) {
                showPopup();
                setTimeout(closePopup, 5000); // Fermer automatiquement après 5 secondes
            }
        });
        