<?php
$employee = null;
$firstname = $lastname = $phone = $birthdate = $gender = $description = $file_path = '';
$educations = $hobbies = [];


if (isset($_GET['id'])) {
    $employeeId = (int)$_GET['id'];
    $employeeController = new EmployeeController();
    $employee = $employeeController->ViewEmployeeDetails($employeeId);
    
    if ($employee) {
      
        $nameParts = explode(' ', $employee['EName'], 2);
        $firstname = $nameParts[0] ?? '';
        $lastname = $nameParts[1] ?? '';
        
        $phone = $employee['Ephone'];
        $birthdate = $employee['Ebirth_date'];
        $gender = $employee['Egender'];
        $description = $employee['Edescription'];
        $file_path = $employee['Efile_path'];
        
       
        $educations = $employeeController->getEmployeeEducations($employeeId);
        $hobbies = $employeeController->getEmployeeHobbies($employeeId);
    } else {
        $_SESSION['notification'] = "Employee not found";
        $_SESSION['notificationClass'] = "error";
        header("Location: Dashboard.php");
        exit();
    }
} else {
    header("Location: Dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_employee'])) {
    $result = $employeeController->UpdateEmployee($employeeId);
    
    if ($result) {
        $_SESSION['notification'] = "Employee updated successfully";
        $_SESSION['notificationClass'] = "success";
        header("Location: ViewEmployee.php?id=" . $employeeId);
        exit();
    }
}
?>