<?php
require_once dirname(__DIR__) . '/models/authmodel.php';
require dirname(__DIR__) . '/utils/session.php';



   
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $errors = [];

            $usermodel = new UserModel($pdo);

            $existingUser = $usermodel->getUserByemail($email);

            if ($existingUser) {
                $errors[] = "Email already exists";
            } 
            if (empty($username)) {
                $errors[] = "Username cannot be empty";
            } 
            if (empty($password)) {
                $errors[] = "Password cannot be empty";
            } 
            if (empty($role)) {
                $errors[] = "Role cannot be empty";
            } 
            if (!preg_match('/^[a-zA-Z][a-zA-Z0-9_]*$/', $username)) {
                $errors[] = "Username must start with an alphabet, and must only contain alphanumeric characters and underscores.";
            }
            if (strlen($password) < 8) {
                $errors[] = "Password must be 8 characters or more";
            }
            

            if (empty($errors)) {
                $usermodel = new UserModel($pdo);

                $adduser = $usermodel->register($username, $email, $password);

                if ($adduser) {
                    $_SESSION['success'] = "Welcome! Your account has been created successfully.";
                } else {
                    $_SESSION['errors'] = "Failed to add user.";
                }
            } else {
                $_SESSION['errors'] = implode(' ,' , $errors);
                header('location: ../../public/register.php');
                exit;
            }

            header("Location: ../../public/dashboard.php");
            exit;
        }

       
   

