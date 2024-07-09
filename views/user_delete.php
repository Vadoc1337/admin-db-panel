<?php
require_once __DIR__ . '/../classes/Auth.php';
require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/User.php';

$auth = Auth::getInstance();

if (!$auth->isLoggedIn()) {
    header('Location: ../public/login.php');
    exit();
}

$db = Database::getInstance();
$userModel = new User($db);

$login = $_GET['login'] ?? '';

// Check if 'login' parameter is provided and the request method is POST
if ($login && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Delete the user based on the 'login' parameter
    $userModel->deleteUser($login);
    // Redirect to the index page after deleting the user
    header('Location: ../public/index.php');
    exit();
}

// Get user details based on the 'login' parameter
$user = $userModel->getUser($login);

// Redirect to index page if user does not exist
if (!$user) {
    header('Location: ../public/index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>
<header>
    <h1>Delete User</h1>
    <nav>
        <a href="../public/index.php">Back to List</a>
        <a href="../public/index.php?logout">Logout</a>
    </nav>
</header>
<main>
    <h2>Are you sure you want to delete this user?</h2>
    <p><strong>Login:</strong> <?php echo htmlspecialchars($user['login']); ?></p>
    <p><strong>Name:</strong> <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></p>
    <form method="POST">
        <button type="submit">Confirm Delete</button>
        <a href="../public/index.php" class="button">Cancel</a>
    </form>
</main>
</body>
</html>