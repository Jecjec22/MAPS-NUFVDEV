<?php
session_start();
include('includes/dbconnection.php');

if (strlen($_SESSION['etmsempid']) == 0) {
    header('location:logout.php');
    exit();
}

$msg = $error = '';

if (isset($_POST['uploadReport'])) {
    $reportImage = $_FILES['reportImage']['name'];
    $tempReportImage = $_FILES['reportImage']['tmp_name'];
    $targetDirectory = "C:/xampp3/htdocs/MAPS-NUFVDEV/coordinator/images/";

    if (!empty($reportImage)) {
        if (move_uploaded_file($tempReportImage, $targetDirectory . $reportImage)) {
            // File successfully moved to the specified directory
            $sql = "INSERT INTO tblreport (ServiceReport) VALUES (:reportImage)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':reportImage', $reportImage, PDO::PARAM_STR);

            if ($query->execute()) {
                $msg = "Service Report uploaded successfully.";
            } else {
                $error = "Error inserting data into the database.";
            }
        } else {
            $error = "Failed to move the file to the specified directory.";
        }
    } else {
        $error = "Please select a report image to upload.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>MANPOWER ALLOCATION AND PLANNING SYSTEM || Service Report</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <!-- site css -->
    <link rel="stylesheet" href="style.css" />
    <!-- responsive css -->
    <link rel="stylesheet" href="css/responsive.css" />
    <!-- color css -->
    <link rel="stylesheet" href="css/colors.css" />
    <!-- select bootstrap -->
    <link rel="stylesheet" href="css/bootstrap-select.css" />
    <!-- scrollbar css -->
    <link rel="stylesheet" href="css/perfect-scrollbar.css" />
    <!-- custom css -->
    <link rel="stylesheet" href="css/custom.css" />
    <!-- calendar file css -->
    <link rel="stylesheet" href="js/semantic.min.css" />
    <!-- fancy box js -->
    <link rel="stylesheet" href="css/jquery.fancybox.css" />
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
                                <h2>Service Report</h2>
                            </div>
                        </div>
                    </div>
                    <!-- Upload Service Report Form -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="white_shd full margin_bottom_30">
                                <div class="full graph_head">
                                    <div class="heading1 margin_0">
                                        <h2>Upload My Daily Service Report</h2>
                                    </div>
                                </div>
                                <div class="padding_infor_info">
                                    <form method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="reportImage">Select Report Image:</label>
                                            <input type="file" class="form-control" id="reportImage" name="reportImage" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary" name="uploadReport">Upload Report</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Display success or error message -->
                    <?php
                    if (!empty($msg)) {
                        echo '<div class="alert alert-success" role="alert">' . $msg . '</div>';
                    }
                    if (!empty($error)) {
                        echo '<div class="alert alert-danger" role="alert">' . $error . '</div>';
                    }
                    ?>
                </div>
                <!-- footer -->
                <?php include_once('includes/footer.php'); ?>
            </div>
            <!-- end dashboard inner -->
        </div>
    </div>
    <!-- model popup -->
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
<!-- fancy box js -->
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/jquery.fancybox.min.js"></script>
<!-- custom js -->
<script src="js/custom.js"></script>
<!-- calendar file css -->
<script src="js/semantic.min.js"></script>
</body>
</html>
