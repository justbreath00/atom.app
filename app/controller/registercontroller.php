<?php
require_once "../app/model/authmodel.php";
require_once  "../app/utils/session.php";

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header('location: register.php');
    exit();
}

   
        
            $username = $_POST['username'];
            $email = $_POST['email'];
            $course_code = $_POST['course'];
            $password = $_POST['password'];
            $confirm = $_POST['confirm_password'];
            $authmodel = new AuthModel($pdo);
            $errors = [];



            if (empty($email)) {
                $errors[] = "email cannot be empty";
            } 
            $existingUser = $authmodel->getUserByEmail($email);
            if ($existingUser) {
                $errors[] = "Email already exists";
            } 
            if (empty($username)) {
                $errors[] = "Username cannot be empty";
            } 
            if (empty($password)) {
                $errors[] = "Password cannot be empty";
            } 
            if (empty($course_code)) {
                $errors[] = "Course cannot be empty";
            } 
            $course = $authmodel->getCourseByCourseCode($course_code);
            if (!$course) {
                $errors[] = "Course Does not exists";
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
                $course = $authmodel->getCourseByCourseCode($course_code);
                $course_id = $course['id'];
                $success = $authmodel->register($username, $email, $course_id, $password);

                

                if ($success) {
                    $user = $authmodel->getUserProfile($email);
                    

                    if ($user) {
                        $_SESSION['userid'] = $user['id'];
                        $_SESSION['username'] = $user['username'];
                         $_SESSION['profile'] = $user['username'][0]; 
                         $_SESSION['course_code'] = $user['course_code'];
                         $_SESSION['course_name'] = $user['course_name'];
                         
                        $_SESSION['authenticated'] = true;

                        $_SESSION['success'] = "Welcome! Your account has been created successfully.";
                        
                        
                        header("Location: dashboard.php");
                        exit;
                        }
                } else {
                    $_SESSION['errors'] = "Failed to register.";
                    header('location: register.php');
                exit;
                }

            }
            

            

            
      

       
  