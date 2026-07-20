<?php
require_once 'classes/UserManager.class.php';
require_once 'classes/User.class.php';
require_once 'includes/functions.php';

$userManager = new UserManager();
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$user = $userManager->getUserById($id);

if (!$user) {
    header('Location: index.php?error=User not found');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user->setUsername(sanitizeInput($_POST['username']));
    $user->setEmail(sanitizeInput($_POST['email']));
    $user->setFullName(sanitizeInput($_POST['full_name']));
    $user->setStatus(sanitizeInput($_POST['status']));
    $user->setIpAddress(getClientIP());
    $user->setUserAgent(getCurrentUserAgent());
    
    if (!empty($_POST['password'])) {
        $user->setPassword($_POST['password']);
    }
    
    try {
        $userManager->updateUser($user);
        header('Location: read.php?id=' . $user->getId() . '&success=User updated successfully');
        exit;
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Update User: <?= htmlspecialchars($user->getUsername()) ?></h1>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <form method="POST" class="user-form">
            <div class="form-group">
                <label>Username *</label>
                <input type="text" name="username" value="<?= htmlspecialchars($user->getUsername()) ?>" required>
            </div>
            <div class="form-group">
                <label>Email *</label>
                <input type="email" name="email" value="<?= htmlspecialchars($user->getEmail()) ?>" required>
            </div>
            <div class="form-group">
                <label>New Password (leave blank to keep current)</label>
                <input type="password" name="password">
            </div>
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="full_name" value="<?= htmlspecialchars($user->getFullName()) ?>">
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status">
                    <option value="active" <?= $user->getStatus() === 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="blocked" <?= $user->getStatus() === 'blocked' ? 'selected' : '' ?>>Blocked</option>
                </select>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update User</button>
                <a href="read.php?id=<?= $user->getId() ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>