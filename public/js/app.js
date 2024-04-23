document.addEventListener("DOMContentLoaded", function() {
    const panierLink = document.querySelector('a[href="panier.php"]');
    const panierContent = document.getElementById('panier-content');

    panierLink.addEventListener('click', function(event) {
        event.preventDefault();
        togglePanierContent();
    });

    function togglePanierContent() {
        if (panierContent.classList.contains('show')) {
            hidePanierContent();
        } else {
            fetchPanierContent();
        }
    }

    function fetchPanierContent() {
       
        fetch('panier.php')
            .then(response => response.text())
            .then(data => {
                panierContent.innerHTML = data;
                showPanierContent();
            })
            .catch(error => console.error('Erreur lors de la récupération du contenu du panier :', error));
    }

    function showPanierContent() {
        panierContent.classList.add('show');
    }

    function hidePanierContent() {
        panierContent.classList.remove('show');
       
    }
});
