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
            alert('Une erreur s\'est produite. Veuillez réessayer.');
        }
    };
    xhr.onerror = function() {
        alert('Une erreur s\'est produite. Veuillez réessayer.');
    };
    xhr.send(formData);
}
