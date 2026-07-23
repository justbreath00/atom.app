<?php 
require_once dirname(__DIR__) . '/utils/session.php';
session_destroy();
header("Location: ../../public/login.php");
exit();