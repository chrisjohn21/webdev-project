// Add this JavaScript function for handling product deletion
function deleteProduct(productId, productName) {
    Swal.fire({
        title: 'Confirm Delete',
        text: 'Are you sure you want to delete the product "' + productName + '"?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Delete'
    }).then((result) => {
        if (result.isConfirmed) {
            // Perform AJAX request to delete product
            $.ajax({
                url: './deleteProduct.php',
                type: 'POST',
                data: {
                    product_id: productId
                },
                dataType: 'json'
            }).then((response) => {
                if (response.status === 'success') {
                    Swal.fire('Product Deleted', response.message, 'success');
                    // You can optionally reload the page or update the UI here
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            });
        }
    });
}
