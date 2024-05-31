document.addEventListener("DOMContentLoaded", function () {
    const panierLink = document.querySelector('a[href="../controller/panier.php"]');
    const panierContent = document.getElementById('panier-content');



    function togglePanierContent() {
        if (panierContent.classList.contains('show')) {
            hidePanierContent();
        } else {
            fetchPanierContent();
        }
    }
    panierLink.addEventListener('click', function (event) {
        event.preventDefault();
        togglePanierContent();
    });

    function fetchPanierContent() {

        fetch('../controller/panier.php')
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
