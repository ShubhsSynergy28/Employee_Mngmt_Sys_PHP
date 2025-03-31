# Employee Management System (PHP)

## Overview
The **Employee Management System** is a web-based application built using **PHP, MySQL, HTML, CSS, and JavaScript**. It helps organizations efficiently manage employee records, including personal details, job roles, attendance, and payroll.

## Features
- **Employee Registration & Management**: Add, edit, and delete employee records.
- **Role-Based Authentication**: Admin and Employee login with different access levels.
- **Attendance Tracking**: Record and monitor employee attendance.
- **Payroll System**: Calculate salaries based on work hours and deductions.
- **Department & Designation Management**: Categorize employees based on departments.
- **Reports & Analytics**: Generate reports on employee performance and attendance.

## Technologies Used
- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP (Core PHP or Laravel)
- **Database**: MySQL
- **Libraries**: jQuery, Bootstrap

## Installation
### Prerequisites
Ensure you have the following installed:
- **XAMPP/WAMP** (for running PHP and MySQL)
- **PHP 7+**
- **MySQL Database**
- **Composer** (if using Laravel framework)

### Setup Steps
1. **Clone the repository**
   ```sh
   git clone https://github.com/ShubhsSynergy28/Employee_Mngmt_Sys_PHP.git
   ```
2. **Move to project directory**
   ```sh
   cd Employee_Mngmt_Sys_PHP
   ```
3. **Import the database**
   - Locate the `employee_mgmt.sql` file (if available) in the repository.
   - Open **phpMyAdmin** and create a new database (e.g., `employee_mgmt`).
   - Import the `employee_mgmt.sql` file into the newly created database.
4. **Configure database connection**
   - Open `config.php` and update the database credentials:
     ```php
     $servername = "localhost";
     $username = "root";  // Change if necessary
     $password = "";      // Change if necessary
     $dbname = "employee_mgmt";
     ```
5. **Start the server**
   - Open XAMPP/WAMP and start **Apache** & **MySQL**.
   - Navigate to `http://localhost/Employee_Mngmt_Sys_PHP/views/Auth/login.php` in your browser.

## Usage
1. **Admin Login**:
   - Use default admin credentials (if provided in `config.php`).
   - Manage employees, attendance, and payroll from the admin panel.
2. **Employee Login**:
   - Employees can log in to view their attendance and salary details.
3. **Generate Reports**:
   - View attendance and payroll reports for different periods.

## Contributing
1. Fork the repository.
2. Create a new branch (`feature-branch`).
3. Make necessary changes and commit.
4. Push to your fork and create a pull request.

## License
This project is licensed under the **MIT License**.

## Contact
For any issues or suggestions, feel free to reach out:
- **GitHub**: [ShubhsSynergy28](https://github.com/ShubhsSynergy28)
- **Email**: [shubham.nakashe@stspl.com] 

