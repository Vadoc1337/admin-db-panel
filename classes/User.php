<?php
class User {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Function which retrieves user data from the database
    public function getUser($login) {
        $query = "SELECT login, password, first_name, last_name, gender, 
          DATE_FORMAT(birth_date, '%Y-%m-%d') AS birth_date 
          FROM users WHERE login = :login";
        $stmt = $this->db->query($query, ['login' => $login]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Inserts a new user into the database.
    public function createUser($userData) {
        try {
            $query =
                "INSERT INTO users (login, password, first_name, last_name, gender, birth_date) 
                 VALUES (:login, :password, :first_name, :last_name, :gender, :birth_date)";
            $this->db->query($query, $userData);
            return true;
        } catch (PDOException $e) {
            if ($e->getCode() == '23000') {
                // Integrity constraint violation (duplicate entry)
                throw new Exception("Username already exists.");
            }
            // For other database errors, re-throw the exception
            error_log("Database error in createUser: " . $e->getMessage());
            throw new Exception("An error occurred while creating the user. Please try again later.");
        }
    }

    // Updates user data, including handling login changes and checking for duplicate logins.
    public function updateUser($oldLogin, $userData) {
        try {
            // Checking if the username has changed
            if ($oldLogin !== $userData['login']) {
                // We check if there is already a user with this username
                $checkQuery = "SELECT COUNT(*) FROM users WHERE login = :login";
                $count = $this->db->query($checkQuery, ['login' => $userData['login']])->fetchColumn();

                if ($count > 0) {
                    throw new Exception("Username already exists.");
                }

                // Updating the login
                $updateLoginQuery = "UPDATE users SET login = :newLogin WHERE login = :oldLogin";
                $this->db->query($updateLoginQuery, [
                    'newLogin' => $userData['login'],
                    'oldLogin' => $oldLogin
                ]);
            }

            // Updating the rest of the user's data
            $updateQuery = "UPDATE users SET
            password = :password,
            first_name = :first_name,
            last_name = :last_name,
            gender = :gender,
            birth_date = :birth_date
            WHERE login = :login";

            $this->db->query($updateQuery, $userData);
            return true;
        } catch (Exception $e) {
            error_log("Error in updateUser: " . $e->getMessage());
            throw new Exception("An error occurred while updating the user. Please try again later.");
        }
    }
    // Deletes a user based on the provided login.
    public function deleteUser($login) {
        $query = "DELETE FROM users WHERE login = :login";
        return $this->db->query($query, ['login' => $login]);
    }

    //  Searches for users based on search terms, sorts the results, and limits the number of returned records.
    public function searchAndSortUsers($searchTerm, $sortField, $sortOrder, $offset, $limit) {
        $offset = (int)$offset;
        $limit = (int)$limit;
        $searchTerms = explode(' ', $searchTerm);

        $allowedSortFields = ['login', 'first_name', 'last_name', 'gender', 'birth_date'];
        $sortField = in_array($sortField, $allowedSortFields) ? $sortField : 'login';
        $sortOrder = $sortOrder === 'DESC' ? 'DESC' : 'ASC';

        // Modify the SELECT part for birth_date
        $sql = "SELECT login, password, first_name, last_name, gender, 
            DATE_FORMAT(birth_date, '%d/%m/%Y') AS birth_date_formatted,
            birth_date 
            FROM users WHERE ";

        $conditions = [];
        $params = [];
        foreach ($searchTerms as $index => $term) {
            $termParam = ":term$index";
            $conditions[] = "(
            login LIKE $termParam OR 
            first_name LIKE $termParam OR 
            last_name LIKE $termParam OR 
            gender LIKE $termParam OR 
            DATE_FORMAT(birth_date, '%d/%m/%Y') LIKE $termParam OR
            CONCAT(first_name, ' ', last_name) LIKE $termParam
        )";
            $params[$termParam] = '%' . $term . '%';
        }

        $sql .= implode(' AND ', $conditions);

        // Modify the ORDER BY clause for birth_date
        if ($sortField === 'birth_date') {
            $sql .= " ORDER BY birth_date $sortOrder";
        } else {
            $sql .= " ORDER BY $sortField $sortOrder";
        }

        $sql .= " LIMIT :offset, :limit";

        $params[':offset'] = $offset;
        $params[':limit'] = $limit;

        $stmt = $this->db->query($sql, $params);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Replace birth_date with formatted version
        foreach ($results as &$row) {
            $row['birth_date'] = $row['birth_date_formatted'];
            unset($row['birth_date_formatted']);
        }

        return $results;
    }

    // Returns the total count of users matching the search terms. It is necessary for pagination.
    public function getTotalSearchUsers($searchTerm) {
        $searchTerms = explode(' ', $searchTerm);

        $sql = "SELECT COUNT(*) as total FROM users WHERE ";

        $conditions = [];
        $params = [];
        foreach ($searchTerms as $index => $term) {
            $termParam = ":term$index";
            $conditions[] = "(
            login LIKE $termParam OR 
            first_name LIKE $termParam OR 
            last_name LIKE $termParam OR 
            gender LIKE $termParam OR 
            DATE_FORMAT(birth_date, '%d/%m/%Y') LIKE $termParam OR
            CONCAT(first_name, ' ', last_name) LIKE $termParam
        )";
            $params[$termParam] = '%' . $term . '%';
        }

        $sql .= implode(' AND ', $conditions);

        $stmt = $this->db->query($sql, $params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }
}