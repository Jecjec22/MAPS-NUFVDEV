<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['etmsaid'] == 0)) {
    header('location:logout.php');
} else {
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>MANPOWER ALLOCATION AND PLANNING SYSTEM || Manage Technician Salary</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="css/responsive.css" />
    <link rel="stylesheet" href="css/colors.css" />
    <link rel="stylesheet" href="css/bootstrap-select.css" />
    <link rel="stylesheet" href="css/perfect-scrollbar.css" />
    <link rel="stylesheet" href="css/custom.css" />
    <link rel="stylesheet" href="js/semantic.min.css" />
    <link rel="stylesheet" href="css/jquery.fancybox.css" />
    <style>
    .technician-box {
        border: 1px solid #ccc;
        padding: 10px;
        margin-bottom: 10px;
    }

    .technician-box.green {
        background-color: #d3f0d3; /* Light green */
    }

    .technician-box.red {
        background-color: #f7d9d9; /* Light red */
    }

    .row-boxes {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .box {
        width: calc(33.33% - 20px);
        margin-right: 20px;
        margin-bottom: 20px;
        float: left;
    }
</style>


</head>

<body class="inner_page tables_page">
    <div class="full_container">
        <div class="inner_container">
            <?php include_once('includes/sidebar.php'); ?>
            <div id="content">
                <?php include_once('includes/header.php'); ?>
                <div class="midde_cont">
                    <div class="container-fluid">
                        <div class="row column_title">
                            <div class="col-md-12">
                                <div class="page_title">
                                    <h2>Manage Technician Salary</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="white_shd full margin_bottom_30">
                                    <div class="full graph_head">
                                        <div class="heading1 margin_0">
                                            <h2>Manage Technician Salary</h2>
                                        </div>
                                    </div>
                                    <div class="table_section padding_infor_info">
                                        <div class="table-responsive-sm">
                                            <?php
                                            $sql = "SELECT tbldepartment.ID as did, tbldepartment.DepartmentName, tblemployee.ID as eid, tblemployee.DepartmentID, tblemployee.EmpName, tblemployee.EmpContactNumber, sa.attendance_salary
                                                    FROM tblemployee
                                                    JOIN tbldepartment ON tbldepartment.ID = tblemployee.DepartmentID
                                                    LEFT JOIN salary_attendance sa ON sa.employee_name = tblemployee.EmpName
                                                    WHERE tbldepartment.DepartmentName = 'Technician'";
                                            $query = $dbh->prepare($sql);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);

                                            if ($query->rowCount() > 0) {
                                                foreach ($results as $row) {
                                                    // Skip rendering the box if Employee Name is 'Available'
                                                    if ($row->EmpName == 'Available') {
                                                        continue;
                                                    }
                                                    // Determine the class based on 'Salary From Attendance' value
                                                    $salaryClass = ($row->attendance_salary == '0.00') ? 'red' : 'green';
                                            ?>
                                                    <div class="box">
                                                        <div class="technician-box <?php echo $salaryClass; ?>">
                                                            <p><strong>Role:</strong> <?php echo htmlentities($row->DepartmentName); ?></p>
                                                            <p><strong>Employee Name:</strong> <?php echo htmlentities($row->EmpName); ?></p>
                                                            <p><strong>Contact Number:</strong> <?php echo htmlentities($row->EmpContactNumber); ?></p>
                                                            <p><strong>Salary From Attendance:</strong> <?php echo htmlentities($row->attendance_salary); ?></p>
                                                            <button class="manage-btn" data-toggle="modal" data-target="#manageModal" data-empname="<?php echo htmlentities($row->EmpName); ?>" data-role="<?php echo htmlentities($row->DepartmentName); ?>" data-salaryfromattendance="<?php echo htmlentities($row->attendance_salary); ?>">Manage</button>
                                                        </div>
                                                    </div>
                                            <?php
                                                }
                                            } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include('includes/footer.php'); ?>
            </div>
        </div>
    </div>
    <div class="modal fade" id="manageModal" tabindex="-1" role="dialog" aria-labelledby="manageModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="manageModalLabel">Manage Employee Salary</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="manage-employee-salary-action.php">
                        <div class="form-group">
                            <label for="empName">Employee Name:</label>
                            <input type="text" class="form-control" id="empName" name="empName" readonly>
                        </div>
                        <div class="form-group">
                            <label for="salaryFromAttendance">Salary From Attendance:</label>
                            <input type="text" class="form-control" id="salaryFromAttendance" name="salaryFromAttendance" readonly>
                        </div>
                        <div class="form-group">
                            <label for="addSalary">Add Salary:</label>
                            <input type="text" class="form-control" id="addSalary" name="addSalary" required>
                        </div>
                        <div class="form-group">
                            <label for="dedSalary">Salary Deductions:</label>
                            <input type="text" class="form-control" id="dedSalary" name="dedSalary" required>
                        </div>
                        <div class="form-group">
                            <label for="totalSalary">Total Salary:</label>
                            <input type="text" class="form-control" id="totalSalary" name="totalSalary" readonly>
                        </div>
                        <div class="form-group">
                            <label for="comments">Comments:</label>
                            <textarea class="form-control" id="comments" name="comments"></textarea>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary" id="submitBtn">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/select-bootstrap.js"></script>
    <script src="js/semantic.min.js"></script>
    <script src="js/perfect-scrollbar.min.js"></script>
    <script src="js/custom.js"></script>
    <script src="js/jquery.fancybox.js"></script>
    <script>
        $('#manageModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var empName = button.data('empname');
            var role = button.data('role');
            var salaryFromAttendance = button.data('salaryfromattendance'); // Get the salary from attendance data
            var modal = $(this);
            modal.find('#empName').val(empName);
            modal.find('#salaryFromAttendance').val(salaryFromAttendance); // Set the salary from attendance value in the form
            modal.find('#role').val(role);
        });

        // Function to compute the total salary
        function computeTotalSalary() {
            var salaryFromAttendance = parseFloat(document.getElementById('salaryFromAttendance').value);
            var addSalary = parseFloat(document.getElementById('addSalary').value);
            var dedSalary = parseFloat(document.getElementById('dedSalary').value);
            var totalSalary = salaryFromAttendance + addSalary - dedSalary;

            if (!isNaN(totalSalary)) {
                document.getElementById('totalSalary').value = totalSalary.toFixed(2);
            }
        }

        // Call the computeTotalSalary function whenever the input values change
        document.getElementById('salaryFromAttendance').addEventListener('input', computeTotalSalary);
        document.getElementById('addSalary').addEventListener('input', computeTotalSalary);
        document.getElementById('dedSalary').addEventListener('input', computeTotalSalary);

        // Call computeTotalSalary function on page load
        computeTotalSalary();

        // Add an event listener to the submit button
        document.getElementById('submitBtn').addEventListener('click', function(event) {
            // Get today's date
            var today = new Date();
            var dayOfMonth = today.getDate();

            // Check if today is the 14th, 29th, or 30th of the month
            if (dayOfMonth !== 14 && dayOfMonth !== 29 && dayOfMonth !== 30) {
                // If not, display a confirmation message
                var confirmSubmit = confirm("Today is not payday. Are you sure you want to proceed?");

                // If the user clicks Cancel, prevent the form from submitting
                if (!confirmSubmit) {
                    event.preventDefault();
                }
            }
        });
    </script>
</body>

</html>
<?php } ?>
