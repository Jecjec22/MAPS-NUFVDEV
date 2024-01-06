<?php
session_start();
include('includes/dbconnection.php');

if (strlen($_SESSION['etmsempid']) == 0) {
    header('location:logout.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>MANPOWER ALLOCATION AND PLANNING SYSTEM || View Service Reports</title>
    <!-- Include your CSS and JavaScript files here -->
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
                                <h2>View Service Reports</h2>
                            </div>
                        </div>
                    </div>
                    <!-- Display the list of uploaded service reports here -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="white_shd full margin_bottom_30">
                                <div class="full graph_head">
                                    <div class="heading1 margin_0">
                                        <h2>Service Reports List</h2>
                                    </div>
                                </div>
                                <div class="table_section padding_infor_info">
                                    <div class="table-responsive-sm">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Service Report</th>
                                                    <!-- Add more columns if needed -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql = "SELECT * FROM tblreport";
                                                $query = $dbh->prepare($sql);
                                                $query->execute();
                                                $results = $query->fetchAll(PDO::FETCH_OBJ);

                                                $cnt = 1;
                                                if ($query->rowCount() > 0) {
                                                    foreach ($results as $row) {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo htmlentities($cnt); ?></td>
                                                            <td>
                                                                <a href="employee/images/<?php echo htmlentities($row->ServiceReport); ?>" target="_blank">
                                                                    <?php echo htmlentities($row->ServiceReport); ?>
                                                                </a>
                                                            </td>
                                                            <!-- Add more columns if needed -->
                                                        </tr>
                                                        <?php
                                                        $cnt = $cnt + 1;
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
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
</html><?php  ?>
