<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../views/Auth/login.php");
    exit();
}
// Display notification if exists
if (isset($_SESSION['notification'])) {
    $notification = $_SESSION['notification'];
    $notificationClass = $_SESSION['notificationClass'];
    unset($_SESSION['notification']);
    unset($_SESSION['notificationClass']);
}
include '../Components/Notification.php';
include '../../config/config.php';
include '../../controllers/EmployeeController.php';$currentPage = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$recordsPerPage = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 5;
$multiplier = $currentPage - 1; // Page 1 has multiplier 0, Page 2 has 1, etc.

$employeeController = new EmployeeController();
$employees = $employeeController->ViewEmployeeDetailswithPagination($recordsPerPage, $multiplier);
$totalRecords = $conn->query("SELECT COUNT(*) FROM employees")->fetch_row()[0];
$totalPages = ceil($totalRecords / $recordsPerPage);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../assets/Styles/dashboard.css">
   
</head>
<body>
    <?php include '../Components/Header.php'; ?>
    <?php include '../Components/Notification.php'; ?>
    <div class="dashboard-container">
        <!-- User Info Section -->
        <div class="user-info">
            <div>
                <span><i class="fas fa-user"></i> Welcome, <?= htmlspecialchars($_SESSION['username'] ?? 'User') ?></span>
                <span style="margin-left: 15px;"><i class="fas fa-id-card"></i> User ID: <?= htmlspecialchars($_SESSION['user_id'] ?? 'N/A') ?></span>
            </div>
            <a href="AddEmp.php" class="btn-primary">
                <i class="fas fa-plus"></i> Add New Employee
            </a>
        </div>
        
        <h1>Employee Dashboard</h1>
        
    
        <div class="table-responsive">
            <table class="employee-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Birth Date</th>
                        <th>Gender</th>
                        <th>Education</th>
                        <th>Hobbies</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($employees)): ?>
                        <?php foreach ($employees as $employee): ?>
                        <tr>
                            <td><?= htmlspecialchars($employee['Eid']) ?></td>
                            <td><?= htmlspecialchars($employee['EName']) ?></td>
                            <td><?= htmlspecialchars($employee['Ephone']) ?></td>
                            <td><?= date('M d, Y', strtotime($employee['Ebirth_date'])) ?></td>
                            <td><?= htmlspecialchars($employee['Egender']) ?></td>
                            <td><?= htmlspecialchars($employee['education']) ?></td>
                            <td><?= htmlspecialchars($employee['hobbies']) ?></td>
                            <td>
                                <div style="display: flex; gap: 5px;">
                                    <a href="ViewEmployee.php?id=<?= $employee['Eid'] ?>" class="action-btn view-btn">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="EditEmployee.php?id=<?= $employee['Eid'] ?>" class="action-btn edit-btn">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="../../utils/DeleteEmployee.php?id=<?= $employee['Eid'] ?>" class="action-btn delete-btn" >
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" style="text-align: center;">No employees found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="pagination">
            <div class="table-controls">
                <div class="records-per-page">
                    <span>Show</span>
                    <select id="recordsPerPage" onchange="updateRecordsPerPage(this.value)">
                <option value="5" <?= $recordsPerPage == 5 ? 'selected' : '' ?>>5</option>
                <option value="10" <?= $recordsPerPage == 10 ? 'selected' : '' ?>>10</option>
                <option value="15" <?= $recordsPerPage == 15 ? 'selected' : '' ?>>15</option>
                <option value="20" <?= $recordsPerPage == 20 ? 'selected' : '' ?>>20</option>
            </select>
                    <span>entries</span>
                </div>
            </div>
            <div class="pagination-control">

            <?php if ($currentPage > 1): ?>
            <a href="?page=1&per_page=<?= $recordsPerPage ?>"><i class="fas fa-angle-double-left"></i></a>
            <a href="?page=<?= $currentPage-1 ?>&per_page=<?= $recordsPerPage ?>"><i class="fas fa-angle-left"></i></a>
        <?php endif; ?>
        
        <?php 
        // Show page numbers
        $startPage = max(1, $currentPage - 2);
        $endPage = min($totalPages, $currentPage + 2);
        
        for ($i = $startPage; $i <= $endPage; $i++): ?>
            <a href="?page=<?= $i ?>&per_page=<?= $recordsPerPage ?>" 
               class="<?= $i == $currentPage ? 'active' : '' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>
        
        <?php if ($currentPage < $totalPages): ?>
            <a href="?page=<?= $currentPage+1 ?>&per_page=<?= $recordsPerPage ?>"><i class="fas fa-angle-right"></i></a>
            <a href="?page=<?= $totalPages ?>&per_page=<?= $recordsPerPage ?>"><i class="fas fa-angle-double-right"></i></a>
        <?php endif; ?>

            </div>
        </div>
    </div>
    
    <script src="../../assets/Scripts/Dashboard.js"></script>      
    </script>
</body>
</html>