<?php
require_once  '../config/connect.php';

class UserModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
// used for login and verify the email if already exist
    public function getUserByEmail($email)
    {
        $query = 'SELECT * FROM users WHERE BINARY email = :email';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }

     public function register($username, $email, $password){
        $hashedpassword = password_hash($password, PASSWORD_DEFAULT);

        $query = 'SELECT COUNT(*) FROM users WHERE BINARY username = :username';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':username', $username);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if($count === 0){
            $query = 'INSERT INTO users (username, email, password)
                      VALUES( :username, :email, :password)';
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':username', $username);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':password', $hashedpassword);
            $stmt->execute();
            return true;
        }
        else{
            return false;
        }
    }



    public function getAllUsers($perPage, $currentPage)
    {
        $offset = ($currentPage - 1) * $perPage;
        $query = "SELECT * FROM user LIMIT :perPage OFFSET :offset";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $users;
    }

    public function deleteUser($userid)
    {
        $query = 'DELETE FROM user WHERE UserID = :userid';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':userid', $userid);
        $deleteuser = $stmt->execute();
        return $deleteuser;
    }

    public function editUser($userid, $username, $password, $role)
    {
        $hashedpassword = password_hash($password, PASSWORD_DEFAULT);
        $query = 'UPDATE user SET Username = :username, Password = :password, Role = :role WHERE UserID = :userid';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':userid', $userid);
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':password', $hashedpassword);
        $stmt->bindValue(':role', $role);
        $edituser = $stmt->execute();
        return $edituser;
    }

   

   

    public function getUserById($userid)
    {
        $query = 'SELECT * FROM user WHERE UserID = :userid';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':userid', $userid, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }
    

    public function getTotalUsers()
    {
        $query = "SELECT COUNT(*) as total FROM user";
        $stmt = $this->pdo->query($query);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }
}
