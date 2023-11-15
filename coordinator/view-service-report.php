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
    <title>MANPOWER ALLOCATION AND PLANNING SYSTEM || View New Service</title>
    <!-- Add your CSS links here -->
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
                                    <h2>Service Report History</h2>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Service Report History Table -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="white_shd full margin_bottom_30">
                                    <div class="full graph_head">
                                        <div class="heading1 margin_0">
                                            <h2>Service Report History</h2>
                                        </div>
                                    </div>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Task ID</th>
                                                <th>Remark</th>
                                                <th>Status</th>
                                                <th>Work Completed</th>
                                                <th>Updation Date</th>
                                                <th>Service Report</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Query to fetch data from tbltasktracking
                                            $query = "SELECT * FROM tbltasktracking";
                                            $result = mysqli_query($con, $query);

                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo "<tr>";
                                                echo "<td>" . $row['ID'] . "</td>";
                                                echo "<td>" . $row['TaskID'] . "</td>";
                                                echo "<td>" . $row['Remark'] . "</td>";
                                                echo "<td>" . $row['Status'] . "</td>";
                                                echo "<td>" . $row['WorkCompleted'] . "</td>";
                                                echo "<td>" . $row['UpdationDate'] . "</td>";
                                                echo "<td>" . $row['ServiceReport'] . "</td>";
                                                echo "</tr>";
                                            }
                                            ?>
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
            <!-- end dashboard inner -->
        </div>
    </div>
    <!-- jQuery -->
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/animate.js"></script>
    <script src="js/bootstrap-select.js"></script>
    <script src="js/owl.carousel.js"></script>
    <script src="js/Chart.min.js"></script>
    <script src="js/Chart.bundle.min.js"></script>
    <script src="js/utils.js"></script>
    <script src="js/analyser.js"></script>
    <script src="js/perfect-scrollbar.min.js"></script>
    <script>
        var ps = new PerfectScrollbar('#sidebar');
    </script>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/jquery.fancybox.min.js"></script>
    <script src="js/custom.js"></script>
    <script src="js/semantic.min.js"></script>
</body>

</html>
<?php
}
?>
