<?php
require_once 'classes/UserManager.class.php';
require_once 'includes/functions.php';

$userManager = new UserManager();
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$user = $userManager->getUserById($id);

if (!$user) {
    header('Location: index.php?error=User not found');
    exit;
}

// Update last login
$userManager->updateLastLogin($id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>User Details</h1>
        
        <div class="user-details">
            <div class="detail-row">
                <span class="label">ID:</span>
                <span class="value">#<?= $user->getId() ?></span>
            </div>
            <div class="detail-row">
                <span class="label">Username:</span>
                <span class="value"><?= htmlspecialchars($user->getUsername()) ?></span>
            </div>
            <div class="detail-row">
                <span class="label">Email:</span>
                <span class="value"><?= htmlspecialchars($user->getEmail()) ?></span>
            </div>
            <div class="detail-row">
                <span class="label">Full Name:</span>
                <span class="value"><?= htmlspecialchars($user->getFullName() ?: 'Not provided') ?></span>
            </div>
            <div class="detail-row">
                <span class="label">Secret Name:</span>
                <span class="value"><code><?= htmlspecialchars($user->getSecretName()) ?></code></span>
            </div>
            <div class="detail-row">
                <span class="label">Status:</span>
                <span class="value"><?= displayStatusBadge($user->getStatus()) ?></span>
            </div>
            <div class="detail-row">
                <span class="label">IP Address:</span>
                <span class="value"><?= htmlspecialchars($user->getIpAddress()) ?></span>
            </div>
            <div class="detail-row">
                <span class="label">User Agent:</span>
                <span class="value"><?= htmlspecialchars($user->getUserAgent()) ?></span>
            </div>
            <div class="detail-row">
                <span class="label">Last Login:</span>
                <span class="value"><?= formatDate($user->getLastLogin()) ?></span>
            </div>
            <div class="detail-row">
                <span class="label">Created At:</span>
                <span class="value"><?= formatDate($user->getCreatedAt()) ?></span>
            </div>
            <div class="detail-row">
                <span class="label">Updated At:</span>
                <span class="value"><?= formatDate($user->getUpdatedAt()) ?></span>
            </div>
        </div>
        
        <div class="form-actions">
            <a href="update.php?id=<?= $user->getId() ?>" class="btn btn-warning">Edit</a>
            <a href="index.php" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
</body>
</html>