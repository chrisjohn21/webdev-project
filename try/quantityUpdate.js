function updateQuantity(productId, action) {
    Swal.fire({
        title: 'Update Quantity',
        input: 'text',
        inputPlaceholder: 'Enter quantity',
        showCancelButton: true,
        confirmButtonText: action === 'in' ? 'Add' : 'Remove',
        cancelButtonText: 'Cancel',
        preConfirm: (quantity) => {
            if (!quantity || isNaN(quantity)) {
                Swal.showValidationMessage('Invalid quantity');
            }
            return quantity;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Send the data to your server to update the quantity
            const xhr = new XMLHttpRequest();
            xhr.open('POST', './updateQuantity.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    const updatedQuantity = parseInt(result.value);
                    const currentQuantityElement = document.getElementById(`quantity-${productId}`);
                    const currentQuantity = parseInt(currentQuantityElement.textContent);
                    const newQuantity = action === 'in' ? currentQuantity + updatedQuantity : Math.max(0, currentQuantity - updatedQuantity);

                    // Update the quantity in the UI
                    currentQuantityElement.textContent = newQuantity;

                    // Check if the action is 'out', the new quantity is zero, and the current quantity was not zero
                    if (action === 'out' && newQuantity === 0 && currentQuantity !== 0) {
                        // Notify that the product is sold out
                        Swal.fire('Product Sold Out!', '', 'warning');
                    } else {
                        // Notify quantity update success
                        Swal.fire('Quantity Updated!', '', 'success');
                    }
                } else {
                    Swal.fire('Error!', 'Quantity could not be updated.', 'error');
                }
            };
            xhr.send(`productId=${productId}&action=${action}&quantity=${result.value}`);
        }
    });
}
