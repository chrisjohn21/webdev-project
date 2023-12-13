<?php
include_once "./Product.php";

$search = isset($_GET['search']) ? $_GET['search'] : '';

$productList = [];

if (!empty($search)) {
    // If search parameter is set, perform search
    $productList = Product::searchProducts($search);
} else {
    // If no search query, get all products
    $productList = Product::getAllProducts();
}
?>

<table class="table table-striped table-bordered" id="productTable">
    <thead class="p-3">
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Description</th>
            <th>Quantity</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
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
                    <button class="btn btn-sm btn-warning" onclick="deleteProduct(' . $product->getId() . ', \'' . $product->getName() . '\')">Delete</button>
                </td>';
                echo '</tr>';
            }
        } else {
            // Display a message instead of an empty row when no products are found
            if (!empty($search)) {
                echo '<tr><td colspan="5">No products found for "' . $search . '"</td></tr>';
            } else {
                echo '<tr><td colspan="5">No products found</td></tr>';
            }
        }
        ?>
    </tbody>
</table>
