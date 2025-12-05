$(document).ready(function() {
    const table = $('#basic-datatables').DataTable();

    // Edit user
    $('#basic-datatables').on('click', '.edit-user', function() {
        const row = $(this).closest('tr');
        const userID = $(this).data('id');
        const username = row.find('td:nth-child(3)').text().trim();
        const roleText = row.find('td:nth-child(6)').text().trim();
        const roleID = roleText === 'Admin' ? 1 : 2;

        $('#editUserID').val(userID);
        $('#editUsername').val(username);
        $('#editRoleID').val(roleID);

        $('#editUserModal').modal('show');
    });

    // Delete user
    $('#basic-datatables').on('click', '.delete-user', function() {
        const userID = $(this).data('id');
        if (confirm('Are you sure you want to delete this user?')) {
            $.post('process/DeleteUserProcess.php', { userID }, function(res) {
                if (res.status === 'success') {
                    alert(res.message);
                    table.ajax.reload(); // reload table via DataTables if using AJAX
                    location.reload();   // or fallback reload
                } else {
                    alert(res.message);
                }
            }, 'json');
        }
    });

    $('#editUserForm').submit(function(e) {
    e.preventDefault();
    const formData = $(this).serialize();
    $.post('process/EditUserProcess.php', formData, function(res) {
        if (res.status === 'success') {
            alert(res.message);
            location.reload(); // reload page so DataTable updates
        } else {
            alert(res.message);
        }
    }, 'json');
});

});
