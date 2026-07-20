<?php
require_once 'classes/UserManager.class.php';
require_once 'includes/functions.php';

$keyword = isset($_GET['keyword']) ? sanitizeInput($_GET['keyword']) : '';
$userManager = new UserManager();

if ($keyword) {
    $users = $userManager->searchUsers($keyword);
} else {
    $users = $userManager->getActiveUsers();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

</head>
<body>
    <div class="container">
        <h1>Search Results</h1>
        <p class="search-summary">Found <?= count($users) ?> users for keyword: <strong>"<?= htmlspecialchars($keyword) ?>"</strong></p>
        
        <div class="actions-bar">
            <a href="index.php" class="btn btn-secondary">Back to List</a>
            <form action="search.php" method="GET" class="search-form">
                <input type="text" name="keyword" placeholder="Search users..." class="search-input" value="<?= htmlspecialchars($keyword) ?>">
                <button type="submit" class="btn btn-info">Search</button>
            </form>
        </div>
        
        <div class="table-container">
            <table class="users-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Secret Name</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                        <tr>
                            <td colspan="6" class="text-center">No users found</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= $user->getId() ?></td>
                            <td><?= htmlspecialchars($user->getUsername()) ?></td>
                            <td><?= htmlspecialchars($user->getEmail()) ?></td>
                            <td><code><?= htmlspecialchars($user->getSecretName()) ?></code></td>
                            <td><?= displayStatusBadge($user->getStatus()) ?></td>
                            <td>
                                <div class="actions">
                                    <a href="read.php?id=<?= $user->getId() ?>" class="btn btn-sm btn-info">View</a>
                                    <a href="update.php?id=<?= $user->getId() ?>" class="btn btn-sm btn-warning">Edit</a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>