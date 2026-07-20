<?php
require_once 'classes/UserManager.class.php';

$userManager = new UserManager();
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    try {
        $result = $userManager->toggleUserStatus($id);
        header('Location: index.php?success=User status updated to ' . $result['new_status']);
    } catch (Exception $e) {
        header('Location: index.php?error=' . urlencode($e->getMessage()));
    }
} else {
    header('Location: index.php?error=Invalid user ID');
}
exit;
?>