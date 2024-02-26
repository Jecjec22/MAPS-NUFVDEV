<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['etmsempid'] == 0)) {
    header('location:logout.php');
} else {
    $employee_id = $_SESSION['etmsempid'];

    $eid = $_SESSION['etmsempid'];
    $selectEmployeeSql = "SELECT EmpName FROM tblemployee WHERE ID = :eid";
    $selectEmployeeQuery = $dbh->prepare($selectEmployeeSql);
    $selectEmployeeQuery->bindParam(':eid', $eid, PDO::PARAM_INT);
    $selectEmployeeQuery->execute();

    // Fetch the employee's name
    $employeeData = $selectEmployeeQuery->fetch();
    $employee_name = $employeeData['EmpName'];

    // Query the database to fetch the employee's salary data
    $sql = "SELECT * FROM tblsalary WHERE EmployeeName = :employee_name ORDER BY date DESC";

    $query = $dbh->prepare($sql);
    $query->bindParam(':employee_name', $employee_name, PDO::PARAM_STR);
    $query->execute();
    $salaryData = $query->fetchAll(PDO::FETCH_ASSOC);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Employee Salary Details</title>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <!-- site css -->
    <link rel="stylesheet" href="style.css"/>
    <!-- responsive css -->
    <link rel="stylesheet" href="css/responsive.css"/>
    <!-- color css -->
    <link rel="stylesheet" href="css/colors.css"/>
    <!-- select bootstrap -->
    <link rel="stylesheet" href="css/bootstrap-select.css"/>
    <!-- scrollbar css -->
    <link rel="stylesheet" href="css/perfect-scrollbar.css"/>
    <!-- custom css -->
    <link rel="stylesheet" href="css/custom.css"/>
    </head>
<body class="inner_page tables_page">
<div class="full_container">
    <div class="inner_container">
        <!-- Sidebar -->
        <?php include_once('includes/sidebar.php'); ?>
        <!-- right content -->
        <div id="content">
            <!-- topbar -->
            <?php include_once('includes/header.php'); ?>
            <!-- end topbar -->
            <!-- dashboard inner -->
            <div class="midde_cont">
                <div class="container-fluid">
                    <div class="row column_title">
                        <div class="col-md-12">
                            <div class="page_title">
                                <h2>My Salary Details</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="white_shd full margin_bottom_30">
                                <div class="full graph_head">
                                    <div class="heading1 margin_0">
                                        <h2>Salary Details</h2>
                                    </div>
                                </div>
                                <div class="table_section padding_infor_info">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Date</th>
                                            
                                            <th>View</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($salaryData as $data) { ?>
                                            <tr>
                                                <td><?= $data['date']; ?></td>
                                               
                                                <td>
                                                    <form action="forms.php" method="POST">
                                                        <!-- Add a hidden input field to pass the employee name -->
<input type="hidden" name="employeeName" value="<?= $employee_name; ?>">

                                                        <input type="hidden" name="attendanceSalary"
                                                               value="<?= $data['AttendanceSalary']; ?>">
                                                        <input type="hidden" name="addedSalary"
                                                               value="<?= $data['AddedSalary']; ?>">
                                                        <input type="hidden" name="deductedSalary"
                                                               value="<?= $data['DeductedSalary']; ?>">
                                                        <input type="hidden" name="totalSalary"
                                                               value="<?= $data['TotalSalary']; ?>">
                                                        <input type="hidden" name="note"
                                                               value="<?= $data['comments']; ?>">
                                                        <!-- Add new hidden fields for additional salary details -->
                                                        <input type="hidden" name="sss"
                                                               value="<?= $data['sss']; ?>">
                                                        <input type="hidden" name="pagibig"
                                                               value="<?= $data['pagibig']; ?>">
                                                        <input type="hidden" name="philhealth"
                                                               value="<?= $data['philhealth']; ?>">
                                                        <input type="hidden" name="netpay"
                                                               value="<?= $data['netpay']; ?>">
                                                        <button type="submit" class="btn btn-primary">View</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- footer -->
                <?php include_once('includes/footer.php'); ?>
            </div>
            <!-- end dashboard inner -->        </div>
    </div>
</div>
<!-- jQuery -->
<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<!-- wow animation -->
<script src="js/animate.js"></script>
<!-- select country -->
<script src="js/bootstrap-select.js"></script>
<!-- owl carousel -->
<script src="js/owl.carousel.js"></script>
<!-- chart js -->
<script src="js/Chart.min.js"></script>
<script src="js/chart.js"></script>
<!-- custom js -->
<script src="js/custom.js"></script>
</body>
</html>
