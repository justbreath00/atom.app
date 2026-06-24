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

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['authenticated'] = true;

            $response = ['success' => true];
        } else {
            $response = ['success' => false, 'errors' => ['Invalid email or password.']];
        }
    } else {
        $_SESSION['errors'] = implode(' ,' , $errors);
        header('location: ../../public/login.php');
        exit;
    }

    header("Location: ../../public/dashboard.php");
    exit;
}

