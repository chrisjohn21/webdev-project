function confirmDelete(productName) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You are about to delete ' + productName + '. This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Perform the delete operation
            deleteProduct(productName);
        }
    });
}

function deleteProduct(productName) {
    $.ajax({
        type: 'POST',
        url: 'deleteProduct.php',
        data: { product_name: productName },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                // Reload the page or update the product list
                location.reload(true);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message
                });
            }
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to communicate with the server'
            });
        }
    });
}
