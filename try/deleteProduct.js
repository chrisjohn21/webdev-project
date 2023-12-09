function deleteProduct(productId, productName) {
    // Use SweetAlert to confirm deletion
    Swal.fire({
        title: 'Are you sure?',
        text: `You are about to delete ${productName}. This action cannot be undone!`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // AJAX request for product deletion
            jQuery.ajax({
                type: 'POST',
                url: './deleteProduct.php', // Replace with the actual server-side file handling product deletion
                data: { productId: productId },
                dataType: 'json',
                success: function (response) {
                    // Log the response to the console for debugging
                    console.log(response);

                    // Check the status returned from the server
                    if (response.status === 'success') {
                        // If successful, remove the table row
                        $(`#product-${productId}`).remove();

                        // Notify with SweetAlert
                        Swal.fire('Deleted!', response.message, 'success');
                    } else {
                        // If an error occurred, notify with SweetAlert
                        Swal.fire('Error!', response.message, 'error');
                    }
                },
                error: function (xhr, status, error) {
                    // Log the AJAX error details to the console for debugging
                    console.error(xhr, status, error);

                    // If an AJAX error occurred, notify with SweetAlert
                    Swal.fire('Error!', 'An error occurred during the deletion process', 'error');
                }
            });
        }
    });
}
