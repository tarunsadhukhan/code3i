<!DOCTYPE html>
<html>
<head>
    <title>CRUD with CodeIgniter</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/datatables.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/custom.css'); ?>">
</head>
<body>
    <div class="container mt-4">
        <h2 class="mb-3">Product CRUD</h2>
        <button class="btn btn-success mb-3" onclick="add_product()">Add Product</button>
        <div class="table-responsive">
            <table class="table table-striped" id="product_table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <!-- Add Product Modal -->
    <div class="modal fade" id="add_product_modal" tabindex="-1" role="dialog">
        <!-- Modal content here -->
    </div>

    <!-- Update Product Modal -->
    <div class="modal fade" id="update_product_modal" tabindex="-1" role="dialog">
        <!-- Modal content here -->
    </div>

    <script src="<?= base_url('assets/js/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('assets/js/bootstrap.min.js'); ?>"></script>
    <script src="<?= base_url('assets/js/datatables.min.js'); ?>"></script>
    <script src="<?= base_url('assets/js/custom.js'); ?>"></script>
</body>
</html>
