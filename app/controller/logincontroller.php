<?php
require_once "../app/model/authmodel.php";
require_once  "../app/utils/session.php";

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
        $authModel = new AuthModel($pdo);
        $user = $authModel->getUserByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            
            $id = $user['id'];
            $ip = $_SERVER['REMOTE_ADDR'];
            $agent = $_SERVER['HTTP_USER_AGENT'];

            $authModel->setLastLogin($id, $ip, $agent);
            $_SESSION['success_login'] = "Welcome back! You successfully loged in.";

            $user = $authModel->getUserProfile($email);

            
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['profile'] = $user['username'][0]; 
            $_SESSION['course_code'] = $user['course_code'];
            $_SESSION['course_name'] = $user['course_name'];
            
            $_SESSION['authenticated'] = true;

            

            $response = ['success' => true];
            header("Location: dashboard.php");
            exit;
        } else {
            $response = ['success' => false, 'errors' => ['Invalid email or password.']];
            header('location: login.php');
            exit;

        }
    } else {
        $_SESSION['errors'] = implode(' ,' , $errors);
        header('location: login.php');
        exit;
    }

    
}

