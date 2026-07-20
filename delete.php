<?php
require_once 'classes/UserManager.class.php';

$userManager = new UserManager();
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    try {
        $userManager->deleteUser($id);
        header('Location: index.php?success=User deleted successfully');
    } catch (Exception $e) {
        header('Location: index.php?error=' . urlencode($e->getMessage()));
    }
} else {
    header('Location: index.php?error=Invalid user ID');
}
exit;
?>