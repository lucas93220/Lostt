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
            alert(xhr.responseText);
        } else {
            alert('Une erreur s\'est produite lors de l\'ajout au panier. Veuillez réessayer.');
        }
    };
    xhr.onerror = function() {
        alert('Une erreur s\'est produite lors de l\'ajout au panier. Veuillez réessayer.');
    };
    xhr.send(formData);
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
            window.location.reload(); // Recharger la page après la suppression
        })
        .catch(error => console.error('Erreur lors de la suppression du produit:', error));
    }
}
