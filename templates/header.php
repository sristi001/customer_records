<?php require_once __DIR__ . '/../includes/config.php'; ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Customer Records</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?php echo $baseUrl; ?>">Customer Records</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="<?php echo $baseUrl; ?>">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo $baseUrl; ?>customers.php">Customers</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo $baseUrl; ?>create.php">Add Customer</a></li>
            </ul>
        </div>
    </div>
    
</nav>
<main class="container">


