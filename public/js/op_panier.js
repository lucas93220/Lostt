document.body.addEventListener('click', function(event) {
    var panierContent = document.getElementById('panier-content');
    var panierBtn = document.querySelector('.active');

    if (!panierContent.contains(event.target) && !panierBtn.contains(event.target)) {
        panierContent.style.display = 'none';
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
    xhr.open('POST', 'panier.php', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            console.log(xhr.responseText);
            updateCartContent();
        } else {
            console.error('Une erreur s\'est produite lors de l\'ajout au panier. Veuillez réessayer.');
        }
    };
    xhr.onerror = function() {
        console.error('Une erreur s\'est produite lors de l\'ajout au panier. Veuillez réessayer.');
    };
    xhr.send(formData);
}

function updateCartContent() {
    fetch('panier.php')
        .then(response => response.text())
        .then(data => {
            const panierContent = document.getElementById('panier-content');
            panierContent.innerHTML = data;
        })
        .catch(error => console.error('Erreur lors de la récupération du contenu du panier :', error));
}

function supprimerDuPanier(product_id, size) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce produit du panier ?')) {
        const formData = new FormData();
        formData.append('action', 'delete');
        formData.append('product_id', product_id);
        formData.append('size', size);

        fetch('panier.php', {
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

    fetch('panier.php', {
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

