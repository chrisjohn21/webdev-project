// search.js

var timeoutId;
var products; // Store all products initially

function fetchProducts() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            products = JSON.parse(xmlhttp.responseText); // Assuming your products are in JSON format
            updateProductList(products); // Display all products initially
        }
    };
    xmlhttp.open("GET", "products.php", true); // Use the same PHP file that fetches all products
    xmlhttp.send();
}

function updateProductList(filteredProducts) {
    var productListContainer = document.getElementById("product-list-container");
    productListContainer.innerHTML = ''; // Clear existing content

    if (filteredProducts.length > 0) {
        filteredProducts.forEach(function (row) {
            var productItem = document.createElement("div");
            productItem.className = "product-item";
            productItem.innerHTML = '<img src="data:image/jpeg;base64,' + row['product_photo'] + '" alt="Product Image">' +
                '<div class="product-info">' +
                '<h3>' + row['product_name'] + '</h3>' +
                '<p>' + row['product_desc'] + '</p>' +
                '<p>Price: $' + row['product_price'] + '</p>' +
                '</div>';
            productListContainer.appendChild(productItem);
        });
    } else {
        productListContainer.innerHTML = '<p>No products found</p>';
    }
}

function performSearch() {
    var keyword = document.getElementById('search').value.toLowerCase().replace(/\s/g, '');

    if (!products) {
        // Fetch all products if not already fetched
        fetchProducts();
    } else {
        // Filter products based on the keyword
        var filteredProducts = products.filter(function (product) {
            return (
                product['product_name'].toLowerCase().includes(keyword) ||
                product['product_desc'].toLowerCase().includes(keyword)
            );
        });

        updateProductList(filteredProducts);
    }
}
document.getElementById('searchForm').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent the default form submission
    performSearch(); // Call the performSearch function
});

// Fetch all products initially when the page loads
document.addEventListener('DOMContentLoaded', fetchProducts);
