<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/templates/header.php';

$pdo = DatabaseConnection::getConnection();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $contact = trim($_POST['contact_number'] ?? '');
    $product = trim($_POST['product'] ?? '');
    $amount = $_POST['amount_paid'] !== '' ? (float)$_POST['amount_paid'] : 0;
    $cashOn = $_POST['cash_on_amount'] !== '' ? (float)$_POST['cash_on_amount'] : 0;
    $delivery = trim($_POST['delivery_option'] ?? '');
    $orderDate = $_POST['order_date'] ?? date('Y-m-d');

    if ($id > 0 && $name !== '') {
        $sql = 'UPDATE customers SET name=?, location=?, contact_number=?, product=?, amount_paid=?, cash_on_amount=?, delivery_option=?, order_date=? WHERE id=?';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $location, $contact, $product, $amount, $cashOn, $delivery, $orderDate, $id]);
        header('Location: customers.php?msg=updated');
        exit;
    }
}

if ($id <= 0) {
    echo '<div class="alert alert-danger">Invalid customer ID.</div>';
    require_once __DIR__ . '/templates/footer.php';
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM customers WHERE id = ?');
$stmt->execute([$id]);
$customer = $stmt->fetch();

if (!$customer) {
    echo '<div class="alert alert-warning">Customer not found.</div>';
    require_once __DIR__ . '/templates/footer.php';
    exit;
}
?>

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <strong>Edit Customer #<?php echo htmlspecialchars((string)$customer['id']); ?></strong>
        <a class="btn btn-sm btn-outline-secondary" href="customers.php">Back</a>
    </div>
    <div class="card-body">
        <form action="edit.php" method="post" class="row g-3">
            <input type="hidden" name="id" value="<?php echo (int)$customer['id']; ?>">
            <div class="col-12">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($customer['name']); ?>" required>
            </div>
            <div class="col-12 col-md-6">
                <label class="form-label">Location</label>
                <input type="text" name="location" class="form-control" value="<?php echo htmlspecialchars((string)$customer['location']); ?>">
            </div>
            <div class="col-12 col-md-6">
                <label class="form-label">Contact Number</label>
                <input type="text" name="contact_number" class="form-control" value="<?php echo htmlspecialchars((string)$customer['contact_number']); ?>">
            </div>
            <div class="col-12 col-md-6">
                <label class="form-label">Product</label>
                <input type="text" name="product" class="form-control" value="<?php echo htmlspecialchars((string)$customer['product']); ?>">
            </div>
            <div class="col-12 col-md-6">
                <label class="form-label">Amount Paid</label>
                <input type="number" step="0.01" name="amount_paid" class="form-control" value="<?php echo htmlspecialchars((string)$customer['amount_paid']); ?>">
            </div>
            <div class="col-12 col-md-6">
                <label class="form-label">Delivery Option</label>
                <select name="delivery_option" class="form-select">
                    <option value="Self" <?php echo ($customer['delivery_option']==='Self')?'selected':''; ?>>Self</option>
                    <option value="Home Delivery" <?php echo ($customer['delivery_option']==='Home Delivery')?'selected':''; ?>>Home Delivery</option>
                </select>
            </div>
            <div class="col-12 col-md-6">
                <label class="form-label">Cash on Amount</label>
                <input type="number" step="0.01" name="cash_on_amount" class="form-control" value="<?php echo htmlspecialchars((string)($customer['cash_on_amount'] ?? '0')); ?>">
            </div>
            <div class="col-12 col-md-6">
                <label class="form-label">Date</label>
                <input type="date" name="order_date" class="form-control" value="<?php echo htmlspecialchars((string)$customer['order_date']); ?>">
            </div>
            <div class="col-12">
                <button class="btn btn-primary" type="submit">Update</button>
                <a class="btn btn-outline-secondary" href="customers.php">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/templates/footer.php'; ?>


