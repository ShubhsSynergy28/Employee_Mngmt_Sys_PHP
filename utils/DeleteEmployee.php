<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../views/Auth/login.php");
    exit();
}

include '../config/config.php';
include '../controllers/EmployeeController.php';
include '../views/Components/Notification.php';

if (isset($_GET['id'])) {
    $employeeId = (int)$_GET['id'];
    $employeeController = new EmployeeController();
    $result = $employeeController->DeleteEmployee($employeeId);
    
    $_SESSION['notification'] = $notification ?? '';
    $_SESSION['notificationClass'] = $notificationClass ?? '';
    header("Location: ../views/Adminstrator/Dashboard.php");
    exit();
} else {
    header("Location: ../views/Adminstrator/Dashboard.php");
    exit();
}
?>