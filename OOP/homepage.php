    <?php
    include_once "./connection.php";
    include_once "./Product.php";
    include_once "./users.php";

    $search = isset($_GET['search']) ? $_GET['search'] : '';

    // Check if the user is logged in
if (isset($_SESSION['username'])) {
    $welcomeMessage = 'Welcome, ' . $_SESSION['username'] . '!';
} else {
    $welcomeMessage = '';
}
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <link rel="stylesheet" href="./homepage.css">
        <script src="./quantityUpdate.js"></script>
        <script src="./Product.js"></script>
        <title>Crazy Whisk</title>
    </head>
    <body>

    <div id="navbar">
        <img src="./bakery_icon.png" alt="Crazy Whisk Logo" id="logo">
        <a href="./homepage.php">Products</a>
        <a href="./transactions.php">Transactions</a>
        <a href="./userPage.php">Users</a>
        <a href="./loginUser.php">Log Out</a>
    </div>

    <div class="container mt-4 vh-100">
        <h1 id="products">Product List</h1>
          <!-- Search form -->
    <form action="#" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Search products..." name="search" id="searchInput">
        </div>
    </form>
        <button id="addProductButton" class="btn custom-bg-gradient mb-3" style="font-weight: bold; font-size:20px;">Add Product</button>
        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
            <table class="table table-striped table-bordered" id="productTable">
                
            <?php
            $productList = [];

            if (!empty($search)) {
                // If search parameter is set, perform search
                $productList = Product::searchProducts($search);
            } else {
                // If no search query, get all products
                $productList = Product::getAllProducts();
            }

            if (!empty($productList)) {
                foreach ($productList as $product) {
                    echo '<tr>';
                    echo '<td>' . $product->getName() . '</td>';
                    echo '<td>₱ ' . $product->getPrice() . '</td>';
                    echo '<td>' . $product->getDescription() . '</td>';
                    echo '<td id="quantity-' . $product->getId() . '">' . $product->getQuantity() . '</td>';
                    echo '<td>
                    <button class="btn btn-sm btn-success" onclick="updateQuantity(' . $product->getId() . ', \'in\')">In</button>
                    <button class="btn btn-sm btn-danger" onclick="updateQuantity(' . $product->getId() . ', \'out\')">Out</button>
                    <button class="btn btn-sm btn-warning" onclick="deleteProduct(' . $product->getId() . ', \'' . $product->getName() . '\')">Delete Product</button>
                </td>';
                }
            } else {
                echo '<tr><td colspan="6">No products found</td></tr>';
            }
            ?>
            </table>
        </div>
    </div>
    <script>
// Attach keyup event to the search input
$('#searchInput').keyup(function() {
    // Get the search input value
    var search = $(this).val();

    // Perform AJAX request to fetch updated product list
    $.ajax({
        type: 'GET',
        url: 'searchProducts.php', // Create a new PHP file for handling search
        data: { search: search },
        success: function(data) {
            // Update the product table with the new data
            $('#productTable').html(data);
        },
        error: function() {
            console.log('Error fetching product data');
        }
    });
});

// Trigger the initial AJAX request on page load to show all products
$(document).ready(function() {
    $.ajax({
        type: 'GET',
        url: 'searchProducts.php', // Create a new PHP file for handling search
        data: { search: '' }, // Empty search parameter to get all products
        success: function(data) {
            // Update the product table with the new data
            $('#productTable').html(data);
        },
        error: function() {
            console.log('Error fetching product data');
        }
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('addProductButton').addEventListener('click', function () {
        Swal.fire({
            title: 'Add Product',
            html:
                '<input id="productName" class="swal2-input" placeholder="Product Name">' +
                '<input id="productPrice" class="swal2-input" placeholder="Product Price">' +
                '<input id="productDescription" class="swal2-input" placeholder="Product Description">' +
                '<input id="productQuantity" class="swal2-input" placeholder="Product Quantity">',
            showCancelButton: true,
            confirmButtonText: 'Add',
            cancelButtonText: 'Cancel',
            preConfirm: function () {
                return {
                    name: document.getElementById('productName').value,
                    price: document.getElementById('productPrice').value,
                    description: document.getElementById('productDescription').value,
                    quantity: document.getElementById('productQuantity').value
                };
            },
        }).then(function (result) {
            if (result.isConfirmed) {
                // Send the data to your server to add the product
                const xhr = new XMLHttpRequest();
                xhr.open('POST', './addProduct.php', true); // Specify the correct PHP file URL
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        Swal.fire('Product Added!', '', 'success');
                        // You can perform any additional actions here, like updating the product list
                    } else {
                        Swal.fire('Error!', 'Product could not be added.', 'error');
                    }
                };
                xhr.send(`name=${result.value.name}&price=${result.value.price}&description=${result.value.description}&quantity=${result.value.quantity}`);
            }
        });
    });
});
</script>
    </body>
    </html>
                