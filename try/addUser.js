// addUser.js

function addUser() {
    Swal.fire({
        title: 'Add User',
        html:
            '<input id="username" class="swal2-input" placeholder="Username">' +
            '<input id="password" type="password" class="swal2-input" placeholder="Password">',
        focusConfirm: false,
        preConfirm: () => {
            const username = Swal.getPopup().querySelector('#username').value;
            const password = Swal.getPopup().querySelector('#password').value;
            // You can add additional validation here if needed

            // Call a PHP script to add the user to the database
            $.ajax({
                type: 'POST',
                url: 'addUser.php', // Adjust the actual path to the PHP script
                data: { username: username, password: password },
                success: function (response) {
                    if (response.success) {
                        Swal.fire('User Added!', '', 'success');
                        // Reload the user table to display the new user
                        loadUserTable();
                    } else {
                        Swal.fire('Error', 'Failed to add user', 'error');
                    }
                },
                error: function () {
                    Swal.fire('Error', 'Failed to communicate with the server', 'error');
                }
            });
        }
    });
}

function loadUserTable() {
    // Reload or update the user table (you can implement this based on your preference)
}
