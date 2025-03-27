<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../views/Auth/login.php");
    exit();
}
include '../../config/config.php';
include '../../controllers/EmployeeController.php';
$employeeController = new EmployeeController();
$employees = $employeeController->ViewEmployeeDetails();
?>