$(document).ready(function() {
    // DataTable initialization
    $('#product_table').DataTable({
        ajax: {
            url: 'products/fetch_products',
            dataSrc: ''
        },
        columns: [
            { data: 'name' },
            { data: 'price' },
            {
                data: null,
                render: function(data, type, row) {
                    return '<button class="btn btn-info btn-sm" onclick="edit_product(' + row.id + ')">Edit</button>' +
                        '<button class="btn btn-danger btn-sm ml-2" onclick="delete_product(' + row.id + ')">Delete</button>';
                }
            }
        ]
    });
});

function add_product() {
    $('#add_product_modal').load('products/add_product_modal', function() {
        $('#add_product_modal').modal('show');
    });
}

function edit_product(id) {
    $('#update_product_modal').load('products/update_product_modal/' + id, function() {
        $('#update_product_modal').modal('show');
    });
}

function delete_product(id) {
    if (confirm('Are you sure you want to delete this product?')) {
        $.ajax({
            url: 'products/delete_product/' + id,
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    $('#product_table').DataTable().ajax.reload();
                }
            }
        });
    }
}
