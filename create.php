<?php
require_once __DIR__ . '/includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = DatabaseConnection::getConnection();

    $name = trim($_POST['name'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $contact = trim($_POST['contact_number'] ?? '');
    $product = trim($_POST['product'] ?? '');
    $amount = $_POST['amount_paid'] !== '' ? (float)$_POST['amount_paid'] : 0;
    $cashOn = $_POST['cash_on_amount'] !== '' ? (float)$_POST['cash_on_amount'] : 0;
    $delivery = trim($_POST['delivery_option'] ?? '');
    $orderDate = $_POST['order_date'] ?? date('Y-m-d');

    if ($name === '') {
        header('Location: index.php');
        exit;
    }

    $sql = 'INSERT INTO customers (name, location, contact_number, product, amount_paid, cash_on_amount, delivery_option, order_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $location, $contact, $product, $amount, $cashOn, $delivery, $orderDate]);

    header('Location: customers.php?msg=created');
    exit;
}

header('Location: index.php');
?>


