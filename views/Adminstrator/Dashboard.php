<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../views/Auth/login.php");
    exit();
}
include '../../config/config.php';
include '../../controllers/EmployeeController.php';
$employeeController = new EmployeeController();
$employees = $employeeController->ViewEmployeeDetailswithPagination();
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
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    <a href="EditEmployee.php?id=<?= $employee['Eid'] ?>" class="action-btn edit-btn">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="DeleteEmployee.php?id=<?= $employee['Eid'] ?>" class="action-btn delete-btn" 
                                       onclick="return confirm('Are you sure you want to delete this employee?')">
                                        <i class="fas fa-trash"></i> Delete
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
                    <select id="recordsPerPage">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                    </select>
                    <span>entries</span>
                </div>
            </div>
            <div class="pagination-control">

                <form action="PageUp.php" method="POST">
                    <button>
                        <i class="fas fa-angle-double-left"></i>
                    </button>
                </form>
                <form action="PageDown.php">
                    <button>
                        <i class="fas fa-angle-double-right"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        // Delete confirmation
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                if (!confirm('Are you sure you want to delete this employee?')) {
                    e.preventDefault();
                }
            });
        });
        
        // Records per page change handler
        document.getElementById('recordsPerPage').addEventListener('change', function() {
            const recordsPerPage = this.value;
            // You'll need to implement the logic to reload with new page size
            // This would typically involve a page reload with a parameter
            window.location.href = `?per_page=${recordsPerPage}`;
        });
    </script>
</body>
</html>