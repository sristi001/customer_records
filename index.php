<?php require_once __DIR__ . '/templates/header.php'; ?>
<?php require_once __DIR__ . '/includes/db.php'; ?>

<?php
$pdo = DatabaseConnection::getConnection();
?>

<div class="row g-4">
    <div class="col-12 col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Add / Update Customer</strong>
                <a class="btn btn-sm btn-outline-secondary" href="customers.php">View Customers</a>
            </div>
            <div class="card-body">
                <form action="create.php" method="post" class="needs-validation" novalidate>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Location</label>
                            <input type="text" name="location" class="form-control">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Contact Number</label>
                            <input type="text" name="contact_number" class="form-control">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Product</label>
                            <input type="text" name="product" class="form-control">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Amount Paid</label>
                            <input type="number" step="0.01" name="amount_paid" class="form-control" value="0">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Cash on Amount</label>
                            <input type="number" step="0.01" name="cash_on_amount" class="form-control" value="0">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Delivery Option</label>
                            <select name="delivery_option" class="form-select">
                                <option value="Self">Self</option>
                                <option value="Home Delivery">Home Delivery</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Date</label>
                            <input type="date" name="order_date" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                        </div>
                    </div>
                    <div class="mt-3 d-flex gap-2">
                        <button class="btn btn-primary" type="submit">Save Customer</button>
                        <a class="btn btn-outline-secondary" href="customers.php">Go to List</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="card shadow-sm h-100">
            <div class="card-header"><strong>Quick Search</strong></div>
            <div class="card-body">
                <form action="customers.php" method="get" class="row g-2">
                    <div class="col-12">
                        <input type="text" name="q" class="form-control" placeholder="Search by name, contact, product...">
                    </div>
                    <div class="col-12">
                        <button class="btn btn-success" type="submit">Search</button>
                        <a class="btn btn-outline-secondary" href="customers.php">Open Full List</a>
                    </div>
                </form>
                <div class="text-muted mt-3">Tip: Use partial words or numbers.</div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/templates/footer.php'; ?>


