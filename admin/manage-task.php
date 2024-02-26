<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['etmsaid']) == 0) {
    header('location:logout.php');
} else {
    // Code for deletion
    if (isset($_GET['delid'])) {
        $rid = intval($_GET['delid']);
        $sql = "delete from tbltask where ID=:rid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':rid', $rid, PDO::PARAM_STR);
        $query->execute();
        echo "<script>alert('Data deleted');</script>";
        echo "<script>window.location.href = 'manage-task.php'</script>";
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>MANPOWER ALLOCATION AND PLANNING SYSTEM || Manage Service</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <!-- site css -->
    <link rel="stylesheet" href="style.css" />
    <!-- responsive css -->
    <link rel="stylesheet" href="css/responsive.css" />
    <!-- color css -->
    <link rel="stylesheet" href "css/colors.css" />
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

    <style>
    .green-row {
        background-color: #d4edda; /* Light green */
        color: #155724; /* Dark green text color */
    }

    .yellow-row {
        background-color: #fff3cd; /* Light yellow */
        color: #856404; /* Dark yellow text color */
    }
</style>

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
                                    <h2>List of Services</h2>
                                </div>
                            </div>
                        </div>

                        <!-- row -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="white_shd full margin_bottom_30">
                                    <div class="full graph_head">
                                        <div class="heading1 margin_0">
                                            <h2>Allocate Technician</h2>
                                        </div>
                                    </div>
                                    <div class="table_section padding_infor_info">
                                        <div class="table-responsive-sm">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th>Service Title</th>
                                                        <th>Work for</th>
                                                        <th>Assign To</th>
                                                        <th>Start Date</th>
                                                        <th>Deadline</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $sql_with_assignment = "SELECT tbltask.ID as tid, tbltask.TaskTitle, tbltask.DeptID, tbltask.AssignTaskto, tbltask.TaskEnddate, tbltask.StartDate, tbldepartment.DepartmentName, tbldepartment.ID as did, tblemployee.EmpName, tblemployee.EmpId FROM tbltask JOIN tbldepartment ON tbldepartment.ID = tbltask.DeptID JOIN tblemployee ON tblemployee.ID = tbltask.AssignTaskto WHERE tbltask.AssignTaskto IS NOT NULL ORDER BY CASE WHEN tblemployee.EmpName = 'Available(00)' THEN 1 ELSE 2 END, tblemployee.EmpName";
                                                    $query_with_assignment = $dbh->prepare($sql_with_assignment);
                                                    $query_with_assignment->execute();
                                                    $results_with_assignment = $query_with_assignment->fetchAll(PDO::FETCH_OBJ);

                                                    $cnt = 1;

                                                    // Display records with assignment
                                                    foreach ($results_with_assignment as $row) {
                                                        // Set the class based on the condition
                                                        $rowClass = ($row->EmpName == 'Available(00)' || $row->EmpId == '00') ? 'green-row' : 'yellow-row';
                                                    ?>
                                                        <tr class="<?php echo $rowClass; ?>">
                                                            <td><?php echo htmlentities($cnt); ?></td>
                                                            <td><?php echo htmlentities($row->TaskTitle); ?></td>
                                                            <td><?php echo htmlentities($row->DepartmentName); ?></td>
                                                            <td><?php echo htmlentities($row->EmpName); ?>(<?php echo htmlentities($row->EmpId); ?>)</td>
                                                            <td><?php echo htmlentities($row->StartDate); ?></td>
                                                            <td><?php echo htmlentities($row->TaskEnddate); ?></td>
                                                            <td><a href="edit-task.php?editid=<?php echo htmlentities($row->tid); ?>" class="btn btn-primary">Assign</a></td>
                                                        </tr>
                                                    <?php
                                                        $cnt++;
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
    <!-- fancy box js -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/jquery.fancybox.min.js"></script>
    <!-- custom js -->
    <script src="js/custom.js"></script>
    <!-- calendar file css -->
    <script src="js/semantic.min.js"></script>
</body>

</html>
<?php } ?>
