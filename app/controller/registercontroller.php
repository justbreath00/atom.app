<?php
require_once "../app/model/authmodel.php";
require_once  "../app/utils/session.php";

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header('location: register.php');
    exit();
}

   
        
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirm = $_POST['confirm_password'];

            $errors = [];

            $usermodel = new UserModel($pdo);

            $existingUser = $usermodel->getUserByEmail($email);

            if ($existingUser) {
                $errors[] = "Email already exists";
            } 
            if (empty($username)) {
                $errors[] = "Username cannot be empty";
            } 
            if (empty($password)) {
                $errors[] = "Password cannot be empty";
            } 
            if (!preg_match('/^[a-zA-Z][a-zA-Z0-9_]*$/', $username)) {
                $errors[] = "Username must start with an alphabet, and must only contain alphanumeric characters and underscores.";
            }
            if (strlen($password) < 8) {
                $errors[] = "Password must be 8 characters or more";
            }
            if ($password !== $confirm) {
                $errors[] = "Password do not match";
            }
            if(!empty($errors)){
                $_SESSION['msg'] = implode(' ,', $errors);
                header('location: register.php');
                exit;

            }else{
                $usermodel = new UserModel($pdo);

                $success = $usermodel->register($username, $email, $password);

                if ($success) {
                    $authModel = new UserModel($pdo);
                    $user = $authModel->getUserByEmail($email);

                    if ($user) {
                        $_SESSION['userid'] = $user['id'];
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['authenticated'] = true;

                        $_SESSION['success'] = "Welcome! Your account has been created successfully.";
                        
                        
                        header("Location: dashboard.php");
                        exit;
                        }
                } else {
                    $_SESSION['errors'] = "Failed to add user.";
                    header('location: register.php');
                exit;
                }

            }
            

            

            
      

       
  