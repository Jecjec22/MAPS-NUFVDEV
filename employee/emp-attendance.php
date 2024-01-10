<?php
ini_set('date.timezone', 'Asia/Manila');
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (empty($_SESSION['etmsempid'])) {
    header('location:logout.php');
    exit;
}

if (isset($_POST['submitTimeIn'])) {
    // Process Time In submission
    $employee_name = $_SESSION['etmsempid'];

    try {
        // Assuming you already have a database connection in $dbh

        // Start a transaction
        $dbh->beginTransaction();

        // Retrieve employee name from the tblemployee table
        $eid = $_SESSION['etmsempid'];
        $selectEmployeeSql = "SELECT EmpName, EmpEmail FROM tblemployee WHERE ID = :eid";
        $selectEmployeeQuery = $dbh->prepare($selectEmployeeSql);
        $selectEmployeeQuery->bindParam(':eid', $eid, PDO::PARAM_INT);
        $selectEmployeeQuery->execute();

        // Fetch the employee's name
        $employeeData = $selectEmployeeQuery->fetch();
        $employee_name = $employeeData['EmpName']; // Assuming 'EmpName' is the column name for the employee's name

        // Check if the user has already submitted a time-in entry for today
        $today = date("Y-m-d");
        $sql = "SELECT COUNT(*) FROM tblattendance WHERE emp_names = :employee_name AND date = :today";
        $query = $dbh->prepare($sql);
        $query->bindParam(':employee_name', $employee_name, PDO::PARAM_STR);
        $query->bindParam(':today', $today, PDO::PARAM_STR);
        $query->execute();
        $count = $query->fetchColumn();

        if ($count > 0) {
            echo '<script type="text/javascript">
               alert("You have already submitted a time-in entry for today.");
             </script>';
        } else {
            // Check if an image file was uploaded
            if (isset($_FILES['selfie']) && $_FILES['selfie']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['selfie'];
                $filename = $file['name'];
                $tmp_path = $file['tmp_name'];

                // Specify the upload directory and move the uploaded file
                $upload_dir = 'C:/xampp/htdocs/MAPS-NUFVDEV/admin/images/';
                $destination = $upload_dir . $filename;
                move_uploaded_file($tmp_path, $destination);

                // Insert leave request using the retrieved employee name and uploaded filename
                $sql = "INSERT INTO tblattendance (emp_names, time_in_datetime, day, date, selfie)
                    VALUES (:employee_name, CURRENT_TIMESTAMP, DATE_FORMAT(CURRENT_TIMESTAMP, '%a'), DATE(CURRENT_TIMESTAMP), :filename)";
                $query = $dbh->prepare($sql);
                $query->bindParam(':employee_name', $employee_name, PDO::PARAM_STR); // Bind the name to the 'employee_name' parameter
                $query->bindParam(':filename', $filename, PDO::PARAM_STR); // Bind the filename to the 'filename' parameter

                // Execute the INSERT query
                $query->execute();

                // Commit the transaction
                $dbh->commit();

                echo '<script type="text/javascript">
                 alert("Time In submitted successfully!");
                 window.location = "emp-attendance.php"; // Redirect to a specific page after confirmation.
               </script>';
            } else {
                echo '<script type="text/javascript">
                   alert("Please upload a selfie before submitting Time In.");
                 </script>';
            }
        }
    } catch (PDOException $e) {
        // Rollback the transaction
        $dbh->rollback();

        echo '<script type="text/javascript">
           alert("Error: Unable to submit Time In.");
           window.location = "emp-attendance.php"; // Redirect to an error page.
         </script>';
    }
}

if (isset($_POST['submitTimeOut'])) {
    // Process Time Out submission
    $employee_name = $_SESSION['etmsempid'];

    try {
        // Assuming you already have a database connection in $dbh

        // Start a transaction
        $dbh->beginTransaction();

        // Retrieve employee name from the tblemployee table
        $eid = $_SESSION['etmsempid'];
        $selectEmployeeSql = "SELECT EmpName, EmpEmail FROM tblemployee WHERE ID = :eid";
        $selectEmployeeQuery = $dbh->prepare($selectEmployeeSql);
        $selectEmployeeQuery->bindParam(':eid', $eid, PDO::PARAM_INT);
        $selectEmployeeQuery->execute();

        // Fetch the employee's name
        $employeeData = $selectEmployeeQuery->fetch();
        $employee_name = $employeeData['EmpName']; // Assuming 'EmpName' is the column name for the employee's name

        // Get the time in datetime for the current employee
        $selectTimeInSql = "SELECT time_in_datetime FROM tblattendance WHERE emp_names = :employee_name ORDER BY ID DESC LIMIT 1";
        $selectTimeInQuery = $dbh->prepare($selectTimeInSql);
        $selectTimeInQuery->bindParam(':employee_name', $employee_name, PDO::PARAM_STR);
        $selectTimeInQuery->execute();

        // Fetch the time in datetime
        $timeInDatetime = $selectTimeInQuery->fetchColumn();

        // Update the time out datetime for the current employee
        $sqlUpdateTimeOut = "UPDATE tblattendance SET time_out_datetime = CURRENT_TIMESTAMP WHERE emp_names = :employee_name AND time_in_datetime = :time_in_datetime";
        $queryUpdateTimeOut = $dbh->prepare($sqlUpdateTimeOut);
        $queryUpdateTimeOut->bindParam(':employee_name', $employee_name, PDO::PARAM_STR);
        $queryUpdateTimeOut->bindParam(':time_in_datetime', $timeInDatetime, PDO::PARAM_STR);

        // Execute the UPDATE query
        $queryUpdateTimeOut->execute();

        // Commit the transaction
        $dbh->commit();

        // Calculate the time difference between Time In and Time Out
$timeInDateTime = new DateTime($timeInDatetime);
$timeOutDateTime = new DateTime();  // Assuming 'time_out_datetime' is the current timestamp
$timeDifference = $timeOutDateTime->diff($timeInDateTime);

// Extract hours, minutes, and seconds from the time difference
$numHrs = $timeDifference->h;
$numMin = $timeDifference->i;
$numSec = $timeDifference->s;

// Total time in hours, including minutes and seconds
$totalHours = $numHrs + ($numMin / 60) + ($numSec / 3600);

// Update the 'num_hr' column in the tblattendance table using prepared statement
$sqlUpdateNumHrs = "UPDATE tblattendance SET num_hr = :numHrs WHERE emp_names = :employee_name AND time_in_datetime = :time_in_datetime";
$queryUpdateNumHrs = $dbh->prepare($sqlUpdateNumHrs);
$queryUpdateNumHrs->bindParam(':numHrs', $totalHours, PDO::PARAM_STR);
$queryUpdateNumHrs->bindParam(':employee_name', $employee_name, PDO::PARAM_STR);
$queryUpdateNumHrs->bindParam(':time_in_datetime', $timeInDatetime, PDO::PARAM_STR);
$queryUpdateNumHrs->execute();

        echo '<script type="text/javascript">
     alert("Time Out submitted successfully!");
     window.location = "emp-attendance.php"; // Redirect to a specific page after confirmation.
   </script>';

    } catch (PDOException $e) {
        // Rollback the transaction
        $dbh->rollback();

        echo '<script type="text/javascript">
         alert("Error: Unable to submit Time Out.");
         window.location = "emp-attendance.php"; // Redirect to an error page.
       </script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>MANPOWER ALLOCATION AND PLANNING SYSTEM || Leave</title>
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
    <!-- calendar file css -->
    <link rel="stylesheet" href="js/semantic.min.css"/>
    <!-- fancy box js -->
    <link rel="stylesheet" href="css/jquery.fancybox.css"/>
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
                                <h2>Attendance Form</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="white_shd full margin_bottom_30">
                                <div class="full graph_head">
                                    <div class="heading1 margin_0">
                                        <h2>Attendance</h2>
                                    </div>
                                </div>
                                <div class="table_section padding_infor_info">
                               <!-- Time In Form -->
<form method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label for="time_in_datetime">Time in:</label>
    <input type="text" name="time_in_datetime" id="time_in_datetime" class="form-control" readonly>
  </div>
  <div class="form-group">
    <label for="selfie">Selfie:</label>
    <input type="file" name="selfie" class="form-control" required>
  </div>
  <button type="submit" name="submitTimeIn" class="btn btn-primary">Submit Time In</button>
</form>

<!-- Time Out Form -->
<form method="post">
  <div class="form-group">
    <label for="time_out_datetime">Time out:</label>
    <input type="text" name="time_out_datetime" id="time_out_datetime" class="form-control" readonly>
  </div>
  <button type="submit" name="submitTimeOut" class="btn btn-primary">Submit Time Out</button>
</form>

<script>
  function updateTime() {
    var currentTime = new Date().toISOString().slice(0, 19).replace('T', ' ');
    document.getElementById("time_in_datetime").value = currentTime;
    document.getElementById("time_out_datetime").value = currentTime;
  }

  // Call updateTime every second to update the time
  setInterval(updateTime, 1000);
</script>
                </div>
                <!-- footer -->
                <?php include_once('includes/footer.php'); ?>
            </div>
            <!-- end dashboard inner -->
        </div>
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
<script src="js/Chart.bundle.min.js"></script>
<script src="js/utils.js"></script>
<script src="js/analyser.js"></script>
<!-- nice scrollbar -->
<script src="js/perfect-scrollbar.min.js"></script>
<script>
    var ps = new PerfectScrollbar('#sidebar');
</script>
<!-- custom js -->
<script src="js/custom.js"></script>
<script src="js/chart_custom_style1.js"></script>
</body>
</html>
