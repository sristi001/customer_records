<?php
require_once __DIR__ . '/includes/db.php';

if (!isset($_GET['id'])) {
    header('Location: customers.php');
    exit;
}

$id = (int)$_GET['id'];
$pdo = DatabaseConnection::getConnection();
$stmt = $pdo->prepare('DELETE FROM customers WHERE id = ?');
$stmt->execute([$id]);

header('Location: customers.php?msg=deleted');
exit;
?>


