<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['etmsaid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $empName = $_POST['empName'];
        $salaryFromAttendance = $_POST['salaryFromAttendance'];
        $addSalary = $_POST['addSalary'];
        $dedSalary = $_POST['dedSalary'];
        $comments = $_POST['comments'];

        // Compute the total salary
        $totalSalary = $salaryFromAttendance + $addSalary - $dedSalary;

        // Update salary_attendance table
        $sqlUpdateAttendance = "UPDATE salary_attendance SET done = :attendanceSalary WHERE employee_name = :empName";
        $stmtUpdateAttendance = $dbh->prepare($sqlUpdateAttendance);
        $stmtUpdateAttendance->bindParam(':attendanceSalary', $salaryFromAttendance);
        $stmtUpdateAttendance->bindParam(':empName', $empName);
        $stmtUpdateAttendance->execute();

        // Set attendance_salary to 0 for the employee
        $sqlSetAttendanceSalaryZero = "UPDATE salary_attendance SET attendance_salary = 0 WHERE employee_name = :empName";
        $stmtSetAttendanceSalaryZero = $dbh->prepare($sqlSetAttendanceSalaryZero);
        $stmtSetAttendanceSalaryZero->bindParam(':empName', $empName);
        $stmtSetAttendanceSalaryZero->execute();

        // Calculate deductions
        $sss = $totalSalary * 0.03; // 3% of total salary for SSS
        $pagibig = $totalSalary * 0.02; // 2% of total salary for Pag-IBIG
        $philhealth = $totalSalary * 0.025; // 2.5% of total salary for PhilHealth
        $netpay = $totalSalary - ($sss + $pagibig + $philhealth);

        // Insert salary details into tblsalary table
        $sql = "INSERT INTO tblsalary (EmployeeName, AttendanceSalary, AddedSalary, DeductedSalary, TotalSalary, SSS, Pagibig, Philhealth, Netpay, Comments, Date)
                VALUES (:empName, :salaryFromAttendance, :addSalary, :dedSalary, :totalSalary, :sss, :pagibig, :philhealth, :netpay, :comments, NOW())";
        $query = $dbh->prepare($sql);
        $query->bindParam(':empName', $empName, PDO::PARAM_STR);
        $query->bindParam(':salaryFromAttendance', $salaryFromAttendance, PDO::PARAM_STR);
        $query->bindParam(':addSalary', $addSalary, PDO::PARAM_STR);
        $query->bindParam(':dedSalary', $dedSalary, PDO::PARAM_STR);
        $query->bindParam(':totalSalary', $totalSalary, PDO::PARAM_STR);
        $query->bindParam(':sss', $sss, PDO::PARAM_STR);
        $query->bindParam(':pagibig', $pagibig, PDO::PARAM_STR);
        $query->bindParam(':philhealth', $philhealth, PDO::PARAM_STR);
        $query->bindParam(':netpay', $netpay, PDO::PARAM_STR);
        $query->bindParam(':comments', $comments, PDO::PARAM_STR);
        $query->execute();

        if ($query) {
            echo "<script>alert('Salary details added successfully');</script>";
            echo "<script>window.location.href = 'manage-salary.php';</script>";
        } else {
            echo "<script>alert('Something went wrong. Please try again');</script>";
        }
    }
}
?>
