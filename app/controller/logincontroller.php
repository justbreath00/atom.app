<?php
require_once dirname(__DIR__) . '/models/authmodel.php';
require dirname(__DIR__) . '/utils/session.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $errors = [];

    if (empty($email)) {
        $errors[] = "Email cannot be empty.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (empty($password)) {
        $errors[] = "Password cannot be empty.";
    }
    if (strlen($password) < 8) {
        $errors[] = "Password cannot be less than 8 characters.";
    }

    if (empty($errors)) {
        $authModel = new UserModel($pdo);
        $user = $authModel->getUserByEmail($email);

        if ($user && password_verify($password, $user['Password'])) {
            $_SESSION['user_id'] = $user['UserID'];
            $_SESSION['role'] = $user['Role'];
            $_SESSION['authenticated'] = true;

            $response = ['success' => true];
        } else {
            $response = ['success' => false, 'errors' => ['Invalid email or password.']];
        }
    } else {
        $response = ['success' => false, 'errors' => $errors];
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
require_once dirname(__DIR__) . '/views/user/login.php';
