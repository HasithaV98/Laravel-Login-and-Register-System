var table;

$(document).ready(function () {
    table=$('#user-table').DataTable( {
        paging: true,
        info: true,
        ordering: true,
        searching: true,
        serverSide: true,
        destroy: true,
        responsive: true,
        dom: "lBfrtip",
        // "order": [6, 'ASC' ],
        buttons: ["copy", "csv", "excel", "pdf"],
        columns: [
            { data: "username", name: "username", orderable: true },
            { data: "name", name: "name", orderable: true },
            { data: "email", name: "email", orderable: true },
            { data: "usertype_lable", name: "usertype_lable", orderable: false },
            { 
                data: "edit_button", 
                name: "edit_button", 
                orderable: false,
                render: function (data, type, row, meta) {
                    return data; 
                },
            },
            { 
                data: "is_active_button", 
                name: "is_active_button", 
                orderable: false,
                render: function (data, type, row, meta) {
                    return data; 
                },
            },
        ],
        order: [[1, "asc"]],
        ajax: {
            url:"/get-user-details",
            type:"POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'), 

            },

        },
        columnDefs: [
            {
                targets: [4, 5], 
                render: function (data, type, row, meta) {
                    return $('<div/>').html(data).text(); 
                },
            },
        ],
    } );
});

function statusChanger(id,status){
    console.log(id);
    console.log(status);
    
    Swal.fire({
        title: "Confirmation",
        text: "Do you wat to status change",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#28a745",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes"
    }).then((result) => {
        if (result.isConfirmed) {

            

            $.ajax({
                method: "POST",
                url: "/user-status-changer",
                cache: false,
                async: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: id,
                    action: status,
                },
                success: function (response) {
                    table.draw();
                    console.log(response);
                    if(response.status=='success'){
                        Swal.fire({
                            title: "Success!",
                            text: "User action was successful.",
                            icon: "success"
                        });
                    }
                    else{
                        Swal.fire({
                            title: "Error!",
                            text: "User action was Unsuccessful.",
                            icon: "error"
                        });
                    }
                },
            });
        }
    });
    

}
function openEditablePopup(button) {
    var userId = button.getAttribute('data-id');
    var name = button.getAttribute('data-name');
    var username = button.getAttribute('data-username');
    var email = button.getAttribute('data-email');

    Swal.fire({
        title: 'Edit User',
        html:
            '<div class="swal2-input-group">' +
            '<label for="editName" class="swal2-label">Name:</label>' +
            '<input type="text" id="editName" class="swal2-input" value="' + name + '">' +
            '</div>' +
            '<div class="swal2-input-group">' +
            '<label for="editUsername" class="swal2-label">Username:</label>' +
            '<input type="text" id="editUsername" class="swal2-input" value="' + username + '">' +
            '</div>' +
            '<div class="swal2-input-group">' +
            '<label for="editEmail" class="swal2-label">Email:</label>' +
            '<input type="email" id="editEmail" class="swal2-input" value="' + email + '">' +
            '</div>',
        showCancelButton: true,
        confirmButtonText: 'Save Changes',
        cancelButtonText: 'Cancel',
        showLoaderOnConfirm: true,
        preConfirm: function () {
            var newName = document.getElementById('editName').value;
            var newUsername = document.getElementById('editUsername').value;
            var newEmail = document.getElementById('editEmail').value;

            return $.ajax({
                method: "POST",
                url: "/update-user",
                data: {
                    id: userId,
                    name: newName,
                    username: newUsername,
                    email: newEmail,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                dataType: "json",
            });
        },
        allowOutsideClick: false,
    }).then(function (result) {
        if (result.value && result.value.status === 'success') {
            table.draw();
            Swal.fire({
                title: 'Success!',
                text: 'User information updated successfully.',
                icon: 'success',
            });
        } else {
            Swal.fire({
                title: 'Error!',
                text: 'Failed to update user information.',
                icon: 'error',
            });
        }
    });
}
