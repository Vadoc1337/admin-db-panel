<?php
require_once __DIR__ . '/../classes/Auth.php'; // Include the Auth class for authentication

$auth = Auth::getInstance(); // Get an instance of the Auth class

if ($auth->isLoggedIn()) {
    header('Location: index.php'); // Redirect to index.php if user is already logged in
    exit();
}

$error = '';

// Get the username and password from the POST data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

// Redirect to index.php after successful login
    if (strlen($username)> 50) {
        $error = 'Username cannot exceed 50 characters.';
    } elseif (strlen($password) > 255) {
        $error = 'Password cannot exceed 255 characters.';
    } else {
        if ($auth->login($username, $password)) {
            header('Location: index.php');
            exit();
        } else {
            // Set error message in session if login fails
            $_SESSION['error'] = 'Invalid username or password';
            // Redirect back to the login page
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit();
        }
    }
}

if (isset($_SESSION['error'])) {
    $error = $_SESSION['error']; // Get the error message from the session
    unset($_SESSION['error']); // Removing the error from the session after use
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous" defer></script>
    <script src="js/script.js" defer></script>
</head>
<body class="login-page">
<main>
    <h1 class="text-center mt-5">Admin panel</h1>
    <?php if ($error): ?>
        <p class="error"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form method="POST" class="form">
        <div class="mb-3 mx-auto">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control login-page__input" id="username" name="username" oninput="checkForSpaces(this)" required autocomplete="off" maxlength="50">
        </div>
        <div class="mb-3 mx-auto">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control login-page__input" id="password" name="password" oninput="checkForSpaces(this)" required autocomplete="off" maxlength="255">
        </div>
        <button type="submit" class="btn btn-success btn-md mx-auto d-block">Login</button>
    </form>
</main>
</body>
</html>

