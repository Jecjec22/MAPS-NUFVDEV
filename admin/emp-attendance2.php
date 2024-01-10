<?php
session_start();
include('includes/dbconnection.php');

if (strlen($_SESSION['etmsaid']) == 0) {
    header('location:logout.php');
} else {
    $date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

    $sql = "SELECT emp_names AS 'Employee Name',
                TIME_FORMAT(time_in_datetime, '%h:%i %p') AS 'Time In',
                TIME_FORMAT(time_out_datetime, '%h:%i %p') AS 'Time Out',
                CONCAT(
                    FLOOR(num_hr),
                    ' hours ',
                    FLOOR((num_hr - FLOOR(num_hr)) * 60),
                    ' mins'
                ) AS 'Time Spent'
            FROM tblattendance
            WHERE date = :date
            ORDER BY id";

    $query = $dbh->prepare($sql);
    $query->bindParam(':date', $date, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>MANPOWER ALLOCATION AND PLANNING SYSTEM || List of Attendance</title>
    <!-- CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="css/responsive.css" />
    <link rel="stylesheet" href="css/colors.css" />
    <link rel="stylesheet" href="css/bootstrap-select.css" />
    <link rel="stylesheet" href="css/perfect-scrollbar.css" />
    <link rel="stylesheet" href="css/custom.css" />
    <link rel="stylesheet" href="css/semantic.min.css" />
</head>
<body class="inner_page general_elements">
    <div class="full_container">
        <div class="inner_container">
            <!-- Sidebar -->
            <?php include_once('includes/sidebar.php'); ?>
            <!-- end sidebar -->
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
                                    <h2>Attendance</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row column8 graph">
                            <div class="col-md-12">
                                <div class="white_shd full margin_bottom_30">
                                    <div class="full graph_head">
                                        <div class="heading1 margin_0">
                                            <h2>Today's Attendance</h2>
                                        </div>
                                    </div>
                                   <div class="full progress_bar_inner">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="full">
                                                    <div class="padding_infor_info">
                                                        <form method="get">
                                                            <label for="date">Select Date:</label>
                                                            <input type="date" id="date" name="date" value="<?php echo $date; ?>">
                                                            <button type="submit">View</button>
                                                        </form>
                                                        <br>
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>Employee Name</th>
                                                                    <th>Time In</th>
                                                                    <th>Time Out</th>
                                                                    <th>Time Spent</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($result as $row) { ?>
                                                                    <tr>
                                                                        <td><?php echo $row['Employee Name']; ?></td>
                                                                        <td><?php echo $row['Time In']; ?></td>
                                                                        <td><?php echo $row['Time Out']; ?></td>
                                                                        <td><?php echo $row['Time Spent']; ?></td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- footer -->
                    <?php include_once('includes/footer.php'); ?>
                </div>
                <!-- end dashboard inner -->
            </div>
        </div>
    </div>


    <!-- JavaScript -->
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>