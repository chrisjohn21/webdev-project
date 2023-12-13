// Add this JavaScript function for handling user deletion
function deleteUser(userId) {
    Swal.fire({
        title: 'Confirm Delete',
        text: 'Are you sure you want to delete this user?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Delete'
    }).then((result) => {
        if (result.isConfirmed) {
            // Perform AJAX request to delete user
            $.ajax({
                url: './deleteUser.php',
                type: 'POST',
                data: {
                    user_id: userId
                },
                dataType: 'json'
            }).then((response) => {
                if (response.status === 'success') {
                    Swal.fire('User Deleted', response.message, 'success');
                    // You can optionally reload the page or update the UI here
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            });
        }
    });
}
