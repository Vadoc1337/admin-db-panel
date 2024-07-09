<?php
require_once __DIR__ . '/../classes/Auth.php';
require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/User.php';

$auth = Auth::getInstance();

if (!$auth->isLoggedIn()) {
    header('Location: ../public/index.php');
    exit();
}

$db = Database::getInstance();
$userModel = new User($db);

// Get the login parameter from the URL
$login = $_GET['login'] ?? '';

// Fetch user data if editing an existing user
$user = $login ? $userModel->getUser($login) : null;
$isEdit = $user !== null;

// Initialize variables for error messages and validation
$error = '';
$validationErrors = [];

// Check if a login was provided but no user was found
if ($login && !$user) {
    $error = "User not found.";
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate each field
    if (empty($_POST['login'])) {
        $validationErrors['login'] = "Login is required.";
    }

    if (!$isEdit && empty($_POST['password'])) {
        $validationErrors['password'] = "Password is required for new users.";
    }

    if (empty($_POST['first_name'])) {
        $validationErrors['first_name'] = "First name is required.";
    }

    if (empty($_POST['last_name'])) {
        $validationErrors['last_name'] = "Last name is required.";
    }

    if (empty($_POST['gender'])) {
        $validationErrors['gender'] = "Gender is required.";
    }
    // Validate and format birth date
    if (!empty($_POST['birth_date'])) {
        $birthDate = DateTime::createFromFormat('Y-m-d', $_POST['birth_date']);
        $userData['birth_date'] = $birthDate ? $birthDate->format('Y-m-d') : null;
    } else {
        $userData['birth_date'] = null;
    }

    // If there are no validation errors, proceed with database operation
    if (empty($validationErrors)) {
        $userData = [
            'login' => $_POST['login'],
            'password' => $_POST['password'] ? password_hash($_POST['password'], PASSWORD_DEFAULT) : ($user['password'] ?? ''),
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'gender' => $_POST['gender'],
            'birth_date' => $_POST['birth_date']
        ];

        try {
            if ($isEdit) {
                $userModel->updateUser($login, $userData);
            } else {
                $userModel->createUser($userData);
            }
            // Redirect to the index page after successful operation
            header('Location: ../public/index.php');
            exit();
        } catch (Exception $e) {
            // Handle specific error for username already exists
            if ($e->getMessage() === "Username already exists.") {
                $error = "This username is already taken. Please choose a different one.";
            } else {
                $error = "An error occurred. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $isEdit ? 'Edit User' : 'Add User'; ?></title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous" defer></script>
    <script src="../public/js/script.js" defer></script>
</head>
<body>
<div class="container">
    <header class="mb-4 header">
        <h1 class="mt-4 form__title"><?php echo $isEdit ? 'Edit User' : 'Add User'; ?></h1>
        <nav class="mt-4 form__nav">
            <a href="../public/index.php" class="btn btn-secondary me-2 mb-1">Back to List</a>
            <a class="btn mb-1 logout" href="../public/index.php?logout">
                <img src="../public/assets/logout.png" alt="logout" class="logout__icon">
                Logout
            </a>
        </nav>
    </header>
    <main>
        <?php if ($error): ?>
            <div class="alert alert-danger" role="alert"><?php echo htmlspecialchars($error); ?></div>
        <?php else: ?>
            <form method="POST" class="needs-validation form" novalidate>

                <div class="mb-3">
                    <label for="login" class="form-label">Login:</label>
                    <input type="text" class="form-control <?php echo isset($validationErrors['login']) ? 'is-invalid' : ''; ?>" id="login" name="login" value="<?php echo htmlspecialchars($_POST['login'] ?? $user['login'] ?? ''); ?>"
                           required
                           pattern="\S+" title="Username cannot contain spaces" oninput="checkForSpaces(this)" autocomplete="off">
                    <div class="invalid-feedback">
                        <?php echo $validationErrors['login'] ?? 'Please provide a valid username without spaces.'; ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" class="form-control <?php echo isset($validationErrors['password']) ? 'is-invalid' : ''; ?>" id="password" name="password" <?php echo $isEdit ? '' : 'required'; ?> pattern="\S*"
                           title="Password cannot contain spaces" oninput="checkForSpaces(this)" autocomplete="off">
                    <?php if ($isEdit): ?>
                        <small>(Leave empty to keep current password)</small>
                    <?php endif; ?>
                    <div class="invalid-feedback">
                        <?php echo $validationErrors['password'] ?? 'Please provide a valid password without spaces.'; ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="first_name" class="form-label">First Name:</label>
                    <input type="text" class="form-control <?php echo isset($validationErrors['first_name']) ? 'is-invalid' : ''; ?>" id="first_name" name="first_name"
                           value="<?php echo htmlspecialchars($_POST['first_name'] ?? $user['first_name'] ?? ''); ?>" required autocomplete="off">
                    <div class="invalid-feedback">
                        <?php echo $validationErrors['first_name'] ?? 'Please provide a first name.'; ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="last_name" class="form-label">Last Name:</label>
                    <input type="text" class="form-control <?php echo isset($validationErrors['last_name']) ? 'is-invalid' : ''; ?>" id="last_name" name="last_name"
                           value="<?php echo htmlspecialchars($_POST['last_name'] ?? $user['last_name'] ?? ''); ?>" required autocomplete="off">
                    <div class="invalid-feedback">
                        <?php echo $validationErrors['last_name'] ?? 'Please provide a last name.'; ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="gender" class="form-label">Gender:</label>
                    <select id="gender" class="form-select <?php echo isset($validationErrors['gender']) ? 'is-invalid' : ''; ?>" name="gender" required>
                        <option value="male" <?php echo ($_POST['gender'] ?? $user['gender'] ?? '') === 'male' ? 'selected' : ''; ?>>Male</option>
                        <option value="female" <?php echo ($_POST['gender'] ?? $user['gender'] ?? '') === 'female' ? 'selected' : ''; ?>>Female</option>
                    </select>
                    <div class="invalid-feedback">
                        <?php echo $validationErrors['gender'] ?? 'Please select a gender.'; ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="birth_date" class="form-label">Birth Date:</label>
                    <input type="date" class="form-control <?php echo isset($validationErrors['birth_date']) ? 'is-invalid' : ''; ?>" id="birth_date" name="birth_date"
                           value="<?php echo htmlspecialchars($_POST['birth_date'] ?? $user['birth_date'] ?? ''); ?>" required autocomplete="off">
                    <div class="invalid-feedback">
                        <?php echo $validationErrors['birth_date'] ?? 'Please provide a valid birth date.'; ?>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary"><?php echo $isEdit ? 'Update' : 'Create'; ?> User</button>

            </form>
        <?php endif; ?>
    </main>
</div>
</body>
</html>