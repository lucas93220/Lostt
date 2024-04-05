// Attend que le DOM soit chargé
document.addEventListener("DOMContentLoaded", function() {
    // Récupère le lien "Shop"
    var shopLink = document.getElementById("shop-link");
    // Récupère la sous-navigation des catégories
    var categoryNav = document.getElementById("sous-navigation");

    // Affiche la sous-navigation des catégories lorsque la souris survole le lien "Shop"
    shopLink.addEventListener("mouseenter", function() {
        categoryNav.style.display = "block";
    });

    // Masque la sous-navigation des catégories lorsque la souris quitte le lien "Shop"
    shopLink.addEventListener("mouseleave", function() {
        categoryNav.style.display = "none";
    });
});
