<?php
require_once __DIR__ . '/includes/db.php';

$pdo = DatabaseConnection::getConnection();

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=customers_export_' . date('Ymd_His') . '.csv');

$output = fopen('php://output', 'w');
fputcsv($output, ['ID','Name','Location','Contact','Product','Amount Paid','Cash On Amount','Delivery Option','Order Date','Created At']);

$stmt = $pdo->query('SELECT id, name, location, contact_number, product, amount_paid, cash_on_amount, delivery_option, order_date, created_at FROM customers ORDER BY id DESC');
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    fputcsv($output, $row);
}

fclose($output);
exit;
?>


