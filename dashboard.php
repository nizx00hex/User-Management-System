<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management System</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">


</head>
<body>
    <?php
    require_once 'classes/UserManager.class.php';
    require_once 'includes/functions.php';
    
    $userManager = new UserManager();
    $users = $userManager->getAllUsers();
    ?>
    
    <div class="container">
        <h1>User Management System</h1>
        
        <div class="actions-bar">
            <!-- <a href="create.php" class="btn btn-primary">Create New User</a> -->
            <form action="search.php" method="GET" class="search-form">
                <input type="text" name="keyword" placeholder="Search users..." class="search-input">
                <button type="submit" class="btn btn-info">Search</button>
            </form>
        </div>
        
    <div class="container text-center">
        <div class="row">
            <table class="users-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Secret Name</th>
                        <th>Status</th>
                        <th>IP Address</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user->getId() ?></td>
                        <td><?= htmlspecialchars($user->getUsername()) ?></td>
                        <td><?= htmlspecialchars($user->getEmail()) ?></td>
                        <td><code><?= htmlspecialchars($user->getSecretName()) ?></code></td>
                        <td><?= displayStatusBadge($user->getStatus()) ?></td>
                        <td><?= htmlspecialchars($user->getIpAddress()) ?></td>
                        <td><?= formatDate($user->getCreatedAt()) ?></td>
                        <td>
                            <div class="actions">
                                <a href="read.php?id=<?= $user->getId() ?>" class="btn btn-sm btn-info">View</a>
                                <a href="update.php?id=<?= $user->getId() ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="status.php?id=<?= $user->getId() ?>" class="btn btn-sm <?= $user->getStatus() === 'active' ? 'btn-danger' : 'btn-success' ?>">
                                    <?= $user->getStatus() === 'active' ? 'Block' : 'Activate' ?>
                                </a>
                                <a href="delete.php?id=<?= $user->getId() ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>




                </tbody>
            </table>
        </div>
    </div>
    </div>
</body>
</html>