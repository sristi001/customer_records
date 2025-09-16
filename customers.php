<?php
require_once __DIR__ . '/templates/header.php';
require_once __DIR__ . '/includes/db.php';

$pdo = DatabaseConnection::getConnection();

$q = trim($_GET['q'] ?? '');
$where = '';
$params = [];
if ($q !== '') {
    $where = "WHERE name LIKE ? OR contact_number LIKE ? OR product LIKE ?";
    $like = "%$q%";
    $params = [$like, $like, $like];
}

$sql = "SELECT * FROM customers $where ORDER BY id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$customers = $stmt->fetchAll();
?>

<div class="d-flex flex-column flex-md-row gap-2 justify-content-between align-items-md-center mb-3">
    <h1 class="h4 m-0">Customers</h1>
    <div class="d-flex gap-2">
        <a class="btn btn-outline-secondary" href="export.php">Export CSV</a>
        <a class="btn btn-primary" href="create.php" onclick="return false;">Add Customer</a>
        <a class="btn btn-primary" href="index.php">Add Customer</a>
    </div>
</div>

<form method="get" class="row g-2 mb-3">
    <div class="col-12 col-md-6 col-lg-4">
        <input class="form-control" type="text" name="q" value="<?php echo htmlspecialchars($q); ?>" placeholder="Search name, contact, product">
    </div>
    <div class="col-12 col-md-auto">
        <button class="btn btn-success" type="submit">Search</button>
        <a class="btn btn-outline-secondary" href="customers.php">Reset</a>
    </div>
</form>

<div class="table-responsive border rounded shadow-sm">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Contact</th>
                <th>Product</th>
                <th>Amount</th>
                <th>Cash On</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!$customers): ?>
                <tr><td colspan="8" class="text-center text-muted">No customers found.</td></tr>
            <?php else: ?>
                <?php foreach ($customers as $c): ?>
                <tr>
                    <td><?php echo (int)$c['id']; ?></td>
                    <td>
                        <div class="fw-semibold"><?php echo htmlspecialchars($c['name']); ?></div>
                        <div class="small text-muted"><?php echo htmlspecialchars((string)$c['location']); ?></div>
                    </td>
                    <td><?php echo htmlspecialchars((string)$c['contact_number']); ?></td>
                    <td><?php echo htmlspecialchars((string)$c['product']); ?></td>
                    <td>₹<?php echo number_format((float)$c['amount_paid'], 2); ?></td>
                    <td>₹<?php echo number_format((float)($c['cash_on_amount'] ?? 0), 2); ?></td>
                    <td><?php echo htmlspecialchars((string)$c['order_date']); ?></td>
                    <td class="text-nowrap">
                        <a class="btn btn-sm btn-outline-primary" href="edit.php?id=<?php echo (int)$c['id']; ?>">Edit</a>
                        <a class="btn btn-sm btn-outline-danger" href="delete.php?id=<?php echo (int)$c['id']; ?>" onclick="return confirm('Delete this customer?');">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/templates/footer.php'; ?>


