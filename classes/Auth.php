<?php
require_once __DIR__ . '/Database.php';

class Auth
{
    private static $instance = null;
    private $isLoggedIn = false;
    private $db;

// Initializes a new Auth instance
    private function __construct()
    {
        session_start();
        $this->db = Database::getInstance();
        $this->checkLogin();
    }

// Method that returns an instance of the Auth class.
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /*
    Method takes a username and password, queries the database to fetch the admin details,
    verifies the password, sets the user session if login is successful, and updates the isLoggedIn status.
    */
    public function login($username, $password)
    {
        $query = "SELECT * FROM admins WHERE admin_username = :username";
        $stmt = $this->db->query($query, ['username' => $username]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($password, $admin['admin_password'])) {
            $_SESSION['user'] = $username;
            $this->isLoggedIn = true;
            return true;
        }
        return false;
    }

    // Method logs out the user by unsetting the user session, updating the isLoggedIn status, and destroying the session.
    public function logout()
    {
        unset($_SESSION['user']);
        $this->isLoggedIn = false;
        session_destroy();
    }

    // Method returns the current login status of the user.

    public function isLoggedIn()
    {
        return $this->isLoggedIn;
    }

    // Method that checks if the user is already logged in by checking the session variable.
    private function checkLogin()
    {
        if (isset($_SESSION['user'])) {
            $this->isLoggedIn = true;
        }
    }
}