<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['etmsaid'] == 0)) {
    header('location:logout.php');
} else {

    // Check if the supervisor is logged in and has the necessary privileges

    // Check if the supervisor is logged in and has the necessary privileges

    if (isset($_GET['action']) && isset($_GET['id'])) {
        $action = $_GET['action'];
        $leaveRequestID = $_GET['id'];

        if ($action == 'approve') {
            $status = 'approved';
        } elseif ($action == 'reject') {
            $status = 'rejected';
        } elseif ($action == 'delete') {
            // Delete the leave request
            $sql = "DELETE FROM leave_requests WHERE id = :id";
            $query = $dbh->prepare($sql);
            $query->bindParam(':id', $leaveRequestID, PDO::PARAM_INT);

            if ($query->execute()) {
                echo '<script type="text/javascript">
                     window.onload = function() {
                         var confirmation = confirm("Leave request deleted successfully!");
                         if (confirmation) {
                             window.location = "leave-request.php"; // Redirect to a specific page after confirmation.
                         } else {
                             // User clicked "Cancel" in the prompt.
                             // Handle this case as needed.
                         }
                     }
                   </script>';
            } else {
                echo '<script type="text/javascript">
                     alert("Error: Unable to submit leave request.");
                     window.location = "leave-requeest.php"; // Redirect to an error page.
                   </script>';
            }

            // No need to proceed further after deleting
            exit;
        }

        // Execute a query to update the status in the leave_requests table based on the action
        $sql = "UPDATE leave_requests SET status = :status WHERE id = :id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->bindParam(':id', $leaveRequestID, PDO::PARAM_INT);

        if ($query->execute()) {
            // Leave request approved or rejected successfully
            echo "Leave request " . ucfirst($action) . "ed!";
        } else {
            echo "Error: Unable to " . $action . " leave request.";
        }
    }

    // Query the database to fetch leave requests sorted by start date
    $sql = "SELECT * FROM leave_requests ORDER BY start_date DESC";
    $query = $dbh->prepare($sql);
    $query->execute();
    $leaveRequests = $query->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>MANPOWER ALLOCATION AND PLANNING SYSTEM || View All Service</title>
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
    <style>
        /* CSS for conditional row styling */
        tr.status-approved { background-color: #C8E6C9; } /* Green */
        tr.status-rejected { background-color: #FFCDD2; } /* Red */
        tr.status-pending { background-color: #FFF9C4; } /* Yellow */
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
                                <h2>Supervisor Leave Requests</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="white_shd full margin_bottom_30">
                                <div class="full graph_head">
                                    <div class="heading1 margin_0">
                                        <h2>Leave Requests</h2>
                                    </div>
                                </div>
                                <div class="table_section padding_infor_info">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Employee Name</th>
                                            <th>Reason</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($leaveRequests as $request) : ?>
                                            <?php
                                            // Determine the CSS class based on the status
                                            $statusClass = '';
                                            switch ($request['status']) {
                                                case 'approved':
                                                    $statusClass = 'status-approved';
                                                    break;
                                                case 'rejected':
                                                    $statusClass = 'status-rejected';
                                                    break;
                                                case 'pending':
                                                    $statusClass = 'status-pending';
                                                    break;
                                                default:
                                                    $statusClass = '';
                                                    break;
                                            }
                                            ?>
                                            <tr class="<?= $statusClass ?>">
                                                <td><?= $request['employee_id']; ?></td>
                                                <td><?= $request['reason']; ?></td>
                                                <td><?= $request['start_date']; ?></td>
                                                <td><?= $request['end_date']; ?></td>
                                                <td><?= $request['status']; ?></td>
                                                <td>
                                                    <a href="?action=approve&id=<?= $request['id']; ?>"
                                                       class="btn btn-success"
                                                       onclick="return confirm('Are you sure you want to approve this leave request?')">Approve</a>
                                                    <a href="?action=reject&id=<?= $request['id']; ?>"
                                                       class="btn btn-danger"
                                                       onclick="return confirm('Are you sure you want to reject this leave request?')">Reject</a>
                                                    <a href="?action=delete&id=<?= $request['id']; ?>"
                                                       class="btn btn-warning"
                                                       onclick="return confirm('Are you sure you want to delete this leave request?')">Delete</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
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
    var ps = a PerfectScrollbar('#sidebar');
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
<?php  ?>
