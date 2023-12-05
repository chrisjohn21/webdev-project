// quantityUpdate.js

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
            xhr.open('POST', './updateQuantity.php', true); // Specify the correct PHP file URL
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    const updatedQuantity = parseInt(result.value);
                    const currentQuantityElement = document.getElementById(`quantity-${productId}`);
                    const currentQuantity = parseInt(currentQuantityElement.textContent);
                    const newQuantity = action === 'in' ? currentQuantity + updatedQuantity : currentQuantity - updatedQuantity;
                    currentQuantityElement.textContent = newQuantity;
                    Swal.fire('Quantity Updated!', '', 'success');
                } else {
                    Swal.fire('Error!', 'Quantity could not be updated.', 'error');
                }
            };
            xhr.send(`productId=${productId}&action=${action}&quantity=${result.value}`);
        }
    });
}
