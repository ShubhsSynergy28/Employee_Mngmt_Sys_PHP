<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../views/Auth/login.php");
    exit();
}

include '../../config/config.php';
include '../../controllers/EmployeeController.php';

$employee = null;
$notification = '';
$notificationClass = '';

if (isset($_GET['id'])) {
    $employeeId = (int)$_GET['id'];
    $employeeController = new EmployeeController();
    $employee = $employeeController->ViewEmployeeDetails($employeeId);
    
    if (!$employee) {
        $notification = "Employee not found";
        $notificationClass = "error";
    }
} else {
    header("Location: Dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Employee Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../assets/Styles/dashboard.css">
    <link rel="stylesheet" href="../../assets/Styles/ViewEmployee.css">
</head>
<body>
    <?php include '../Components/Header.php'; ?>
    
    <div class="dashboard-container">
        <?php if (!empty($notification)): ?>
            <div class="notification <?= htmlspecialchars($notificationClass) ?>">
                <?= htmlspecialchars($notification) ?>
            </div>
        <?php endif; ?>
        
        <h1>Employee Details</h1>
        
        <?php if ($employee): ?>
            <div class="employee-details-container">
                <div class="detail-row">
                    <div class="detail-label">Employee ID:</div>
                    <div class="detail-value"><?= htmlspecialchars($employee['Eid']) ?></div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Full Name:</div>
                    <div class="detail-value"><?= htmlspecialchars($employee['EName']) ?></div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Phone Number:</div>
                    <div class="detail-value"><?= htmlspecialchars($employee['Ephone']) ?></div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Birth Date:</div>
                    <div class="detail-value"><?= date('M d, Y', strtotime($employee['Ebirth_date'])) ?></div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Gender:</div>
                    <div class="detail-value"><?= htmlspecialchars($employee['Egender']) ?></div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Education:</div>
                    <div class="detail-value"><?= htmlspecialchars($employee['education'] ?? 'N/A') ?></div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Hobbies:</div>
                    <div class="detail-value"><?= htmlspecialchars($employee['hobbies'] ?? 'N/A') ?></div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Description:</div>
                    <div class="detail-value"><?= htmlspecialchars($employee['Edescription']) ?></div>
                </div>
                
                <?php if (!empty($employee['Efile_path'])): ?>
                    <div class="file-preview">
                        <div class="detail-label">Attached File:</div>
                        <?php
                        $fileExtension = strtolower(pathinfo($employee['Efile_path'], PATHINFO_EXTENSION));
                        $filePath = '../../Uploads/' . $employee['Efile_path'];
                        
                        if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])): ?>
                            <img src="<?= htmlspecialchars($filePath) ?>" alt="Employee Document">
                        <?php elseif ($fileExtension === 'pdf'): ?>
                            <embed src="<?= htmlspecialchars($filePath) ?>" type="application/pdf" width="100%" height="500px">
                        <?php else: ?>
                            <a href="<?= htmlspecialchars($filePath) ?>" download class="btn-primary">
                                Download File
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                
                <a href="Dashboard.php" class="back-btn">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>
        <?php else: ?>
            <p>No employee data found.</p>
            <a href="Dashboard.php" class="back-btn">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        <?php endif; ?>
    </div>
</body>
</html>