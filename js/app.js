document.addEventListener("DOMContentLoaded", function() {
    const shopLink = document.getElementById("shop-link");
    const categoryNav = document.getElementById("category-nav");

    function showCategoryNav() {
        categoryNav.style.display = "block";
    }

    shopLink.addEventListener("mouseenter", showCategoryNav);

    shopLink.addEventListener("mouseleave", function() {
        categoryNav.style.display = "none";
    });
});