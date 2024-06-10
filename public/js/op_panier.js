document.addEventListener('DOMContentLoaded', function () {
    const panierContent = document.getElementById('panier-content');
    const panierBtn = document.querySelector('.active');

    document.body.addEventListener('click', function (event) {
        if (panierContent && panierContent.style.display === 'block' && !panierContent.contains(event.target) && !panierBtn.contains(event.target)) {
            panierContent.style.display = 'none';
        }
    });

    if (panierBtn) {
        panierBtn.addEventListener('click', function (event) {
            event.preventDefault();
            if (panierContent.style.display === 'block') {
                panierContent.style.display = 'none';
            } else {
                panierContent.style.display = 'block';
                updateCartContent();
            }
        });
    }
});

function addToCart(event, productId, productName, productPrice, size) {
    event.preventDefault();

    var formData = new FormData();
    formData.append('action', 'add');
    formData.append('product_id', productId);
    formData.append('product_name', productName);
    formData.append('product_price', productPrice);
    formData.append('size', size);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', '../controller/panier.php', true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            console.log(xhr.responseText);
            updateCartContent();
        } else {
            console.error('Une erreur s\'est produite lors de l\'ajout au panier. Veuillez réessayer.');
        }
    };
    xhr.onerror = function () {
        console.error('Une erreur s\'est produite lors de l\'ajout au panier. Veuillez réessayer.');
    };
    xhr.send(formData);
}

function updateCartContent() {
    fetch('../controller/panier.php')
        .then(response => response.text())
        .then(data => {
            const panierContent = document.getElementById('panier-content');
            if (panierContent) {
                panierContent.innerHTML = data;
                attachCartEventListeners();
            }
        })
        .catch(error => console.error('Erreur lors de la récupération du contenu du panier :', error));
}

function supprimerDuPanier(product_id, size) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce produit du panier ?')) {
        const formData = new FormData();
        formData.append('action', 'delete');
        formData.append('product_id', product_id);
        formData.append('size', size);

        fetch('../controller/panier.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.text())
            .then(data => {
                console.log(data);
                updateCartContent();
            })
            .catch(error => console.error('Erreur lors de la suppression du produit:', error));
    }
}

function changerQuantite(product_id, size, newQuantity) {
    const formData = new FormData();
    formData.append('action', 'update_quantity');
    formData.append('product_id', product_id);
    formData.append('size', size);
    formData.append('quantity', newQuantity);

    fetch('../controller/panier.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.text())
        .then(data => {
            console.log(data);
            updateCartContent();
        })
        .catch(error => console.error('Erreur lors de la mise à jour de la quantité du produit:', error));
}

function attachCartEventListeners() {
    document.querySelectorAll('.deleteButton').forEach(button => {
        button.addEventListener('click', function () {
            const productId = this.getAttribute('data-product-id');
            const size = this.getAttribute('data-size');
            supprimerDuPanier(productId, size);
        });
    });

    document.querySelectorAll('input[type="number"]').forEach(input => {
        input.addEventListener('change', function () {
            const productId = this.getAttribute('data-product-id');
            const size = this.getAttribute('data-size');
            const quantity = this.value;
            changerQuantite(productId, size, quantity);
        });
    });
}
