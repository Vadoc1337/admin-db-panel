<?php
require_once __DIR__ . '/../classes/Auth.php';
require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/User.php';

// Get full info about user

$auth = Auth::getInstance();

if (!$auth->isLoggedIn()) {
    header('Location: ../public/index.php');
    exit();
}

$db = Database::getInstance();
$userModel = new User($db);

$login = $_GET['login'] ?? '';
$user = $userModel->getUser($login);

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
    <title>User Details</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous" defer></script>
</head>
<body>
<div class="container">
    <header class="mb-4 header">
        <h1 class="mt-4 form__title">User Details</h1>
        <nav class="mt-4 form__nav">
            <a href="../public/index.php" class="btn btn-secondary me-2">Back to List</a>
            <a class="btn mb-1 logout" href="../public/index.php?logout">
                <img src="../public/assets/logout.png" alt="logout_icon" class="logout__icon">
                Logout
            </a>
        </nav>
    </header>
    <main class="card user-card">
            <div class="card-header">
                <h2 class="card-title"><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></h2>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Login:</strong> <?php echo htmlspecialchars($user['login']); ?></li>
                    <li class="list-group-item"><strong>Password:</strong> <?php echo htmlspecialchars($user['password']); ?></li>
                    <li class="list-group-item"><strong>Gender:</strong> <?php echo htmlspecialchars($user['gender']); ?></li>
                    <li class="list-group-item"><strong>Birth Date:</strong> <?php echo htmlspecialchars($user['birth_date']); ?></li>
                </ul>
            </div>
            <div class="card-footer">
                <a href="user_form.php?login=<?php echo urlencode($user['login']); ?>" class="btn btn-primary">Edit</a>
        </div>
    </main>
</div>
</body>
</html>