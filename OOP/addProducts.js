// addProduct.js

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
