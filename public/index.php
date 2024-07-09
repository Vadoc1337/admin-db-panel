<?php
mb_internal_encoding('UTF-8');
require_once __DIR__ . '/../classes/Auth.php';
require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/User.php';

if (isset($_SESSION['error_message'])) {
    echo '<div class="alert alert-danger">' . htmlspecialchars($_SESSION['error_message']) . '</div>';
    unset($_SESSION['error_message']);
}

$auth = Auth::getInstance();


// Check if user is logged in
if (!$auth->isLoggedIn()) {
    header('Location: login.php');
    exit();
}

// Handle logout
if (isset($_GET['logout'])) {
    $auth->logout();
    header('Location: login.php');
    exit();
}

// Fetch users from Database
$db = Database::getInstance();
$userModel = new User($db);

$error = '';

// Handle user deletion
if (isset($_POST['delete_user'])) {
    $loginToDelete = $_POST['delete_user'];
    $userModel->deleteUser($loginToDelete);
    // Redirect to the same page to refresh the user list
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

// Pagination setup
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 10;
$offset = ($page - 1) * $perPage;

// Search functionality
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$searchTerm = mb_convert_encoding($searchTerm, 'UTF-8', mb_detect_encoding($searchTerm, 'UTF-8, ISO-8859-1', true));


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Check if search field is too long
    if (strlen($searchTerm) > 100) {
        $error = 'Too big search request, please use less than 100 characters.';
    }
}

// Sorting functionality
$sortField = isset($_GET['sort']) ? $_GET['sort'] : 'login';
$sortOrder = isset($_GET['order']) && $_GET['order'] === 'desc' ? 'DESC' : 'ASC';

// Helper function to generate sort URL
function getSortUrl($field, $currentSortField, $currentSortOrder, $searchTerm)
{
    $order = ($field === $currentSortField && $currentSortOrder === 'ASC') ? 'desc' : 'asc';
    return "?sort={$field}&order={$order}&search=" . urlencode($searchTerm);
}

// Fetch users from database with pagination, search and sorting
$users = $userModel->searchAndSortUsers($searchTerm, $sortField, $sortOrder, $offset, $perPage);
$totalUsers = $userModel->getTotalSearchUsers($searchTerm);
$totalPages = ceil($totalUsers / $perPage);

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
    <title>User Management</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous" defer></script>
    <script src="js/script.js" defer></script>
</head>
<body class="bg-light">
<div class="container">
    <header class="d-flex justify-content-between align-items-center py-3 mb-2">
        <h1 class="h2">User List</h1>
        <a class="btn logout" href="?logout">
            <img src="./assets/logout.png" alt="logout" class="logout__icon">
            Logout
        </a>
    </header>
    <main>
        <!-- Search form -->
        <form action="" method="GET" class="mb-3 search">
            <div class="input-group">
                <input type="text" name="search" id="search__input" class="form-control" style="width: 30px;" placeholder="Search" autocomplete="off" maxlength="100" value="<?php echo htmlspecialchars($searchTerm); ?>">
                <button type="button" class="btn btn-outline-secondary" id="search__clear-button" style="display: none;">&times;</button>
                <button class="btn btn-outline-secondary search__submit-button" type="submit">Search</button>
            </div>
            <?php if ($error): ?>
                <p class="error"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
        </form>
        <div class="table-responsive">
            <?php if (empty($users)): ?>
                <div class="alert alert-info" role="alert">
                    Users not found
                </div>
            <?php else: ?>
                <table class="table table-striped table-bordered table-hover">
                    <thead class="table-dark">
                    <tr>
                        <th><a href="<?php echo getSortUrl('login', $sortField, $sortOrder, $searchTerm); ?>" class="text-white">Login <?php echo ($sortField === 'login') ? ($sortOrder === 'ASC' ? '▲' : '▼') : ''; ?></a></th>
                        <th>Password</th>
                        <th><a href="<?php echo getSortUrl('first_name', $sortField, $sortOrder, $searchTerm); ?>" class="text-white">First Name <?php echo ($sortField === 'first_name') ? ($sortOrder === 'ASC' ? '▲' : '▼') : ''; ?></a></th>
                        <th><a href="<?php echo getSortUrl('last_name', $sortField, $sortOrder, $searchTerm); ?>" class="text-white">Last Name <?php echo ($sortField === 'last_name') ? ($sortOrder === 'ASC' ? '▲' : '▼') : ''; ?></a></th>
                        <th><a href="<?php echo getSortUrl('gender', $sortField, $sortOrder, $searchTerm); ?>" class="text-white">Gender <?php echo ($sortField === 'gender') ? ($sortOrder === 'ASC' ? '▲' : '▼') : ''; ?></a></th>
                        <th><a href="<?php echo getSortUrl('birth_date', $sortField, $sortOrder, $searchTerm); ?>" class="text-white">Birth Date <?php echo ($sortField === 'birth_date') ? ($sortOrder === 'ASC' ? '▲' : '▼') : ''; ?></a></th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['login']); ?></td>
                            <td><?php echo htmlspecialchars($user['password']); ?></td>
                            <td><?php echo htmlspecialchars($user['first_name']); ?></td>
                            <td><?php echo htmlspecialchars($user['last_name']); ?></td>
                            <td><?php echo htmlspecialchars($user['gender']); ?></td>
                            <td><?php echo htmlspecialchars($user['birth_date']); ?></td>
                            <td class="d-flex gap-2 mt-1">
                                <a href="../views/user_details.php?login=<?php echo urlencode($user['login']); ?>" class="btn btn-sm btn-info">View</a>
                                <a href="../views/user_form.php?login=<?php echo urlencode($user['login']); ?>" class="btn btn-sm btn-warning">Edit</a>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="delete_user" value="<?php echo htmlspecialchars($user['login']); ?>">
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
        <?php if ($totalPages > 1): ?>
            <a href="../views/user_form.php" class="btn btn-primary bt-lg user-add-button">Add New User</a>
        <?php else: ?>
            <a href="../views/user_form.php" class="btn btn-primary bt-lg user-add-button--special">Add New User</a>
        <?php endif; ?>
        <!-- Pagination -->
        <?php if ($totalPages > 1): ?>
            <nav aria-label="Page navigation" class="pagination-block">
                <ul class="pagination justify-content-center pagination__list">
                    <!-- First page link -->
                    <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=1&sort=<?php echo $sortField; ?>&order=<?php echo $sortOrder; ?>&search=<?php echo urlencode($searchTerm); ?>" aria-label="First">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>

                    <!-- Previous page link -->
                    <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $page - 1; ?>&sort=<?php echo $sortField; ?>&order=<?php echo $sortOrder; ?>&search=<?php echo urlencode($searchTerm); ?>" aria-label="Previous">
                            <span aria-hidden="true">&lsaquo;</span>
                        </a>
                    </li>

                    <?php
                    $startPage = max(1, min($page - 2, $totalPages - 4));
                    $endPage = min($startPage + 4, $totalPages);

                    for ($i = $startPage; $i <= $endPage; $i++):
                        ?>
                        <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>&sort=<?php echo $sortField; ?>&order=<?php echo $sortOrder; ?>&search=<?php echo urlencode($searchTerm); ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>

                    <!-- Next page link -->
                    <li class="page-item <?php echo ($page >= $totalPages) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $page + 1; ?>&sort=<?php echo $sortField; ?>&order=<?php echo $sortOrder; ?>&search=<?php echo urlencode($searchTerm); ?>" aria-label="Next">
                            <span aria-hidden="true">&rsaquo;</span>
                        </a>
                    </li>

                    <!-- Last page link -->
                    <li class="page-item <?php echo ($page >= $totalPages) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $totalPages; ?>&sort=<?php echo $sortField; ?>&order=<?php echo $sortOrder; ?>&search=<?php echo urlencode($searchTerm); ?>" aria-label="Last">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        <?php endif; ?>
    </main>
</div>
</body>
</html>