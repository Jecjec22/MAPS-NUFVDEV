<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['etmsaid'] == 0)) {
    header('location:logout.php');
} else {
    // Check if the supervisor is logged in and has the necessary privileges
    // Add your code here based on your specific authentication and authorization logic

    try {
        // Assuming you already have a database connection in $dbh

        if (isset($_POST['submit_feedback'])) {
            $ticket_id = $_POST['ticket_id'];
            $user_feedback = $_POST['user_feedback'];

            // Update the ticket with the user's feedback
            $sql = "UPDATE tickets SET feedback = :user_feedback WHERE ticket_id = :ticket_id";
            $query = $dbh->prepare($sql);
            $query->bindParam(':user_feedback', $user_feedback, PDO::PARAM_STR);
            $query->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
            $query->execute();

            // Redirect back to the same page (refresh)
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit();
        }

        // ... Your existing code ...

        if (isset($_GET['action']) && isset($_GET['ticket_id'])) {
            $action = $_GET['action'];
            $ticketID = $_GET['ticket_id'];

            if ($action == 'delete') {
                // Delete the ticket
                $sql = "DELETE FROM tickets WHERE ticket_id = :ticket_id";
                $query = $dbh->prepare($sql);
                $query->bindParam(':ticket_id', $ticketID, PDO::PARAM_INT);

                if ($query->execute()) {
                    echo '<script type="text/javascript">
                            window.onload = function() {
                                var confirmation = confirm("Ticket deleted successfully!");
                                if (confirmation) {
                                    window.location = "manage-ticket.php"; // Redirect to a specific page after confirmation.
                                } else {
                                    // User clicked "Cancel" in the prompt.
                                    // Handle this case as needed.
                                }
                            }
                        </script>';
                } else {
                    echo '<script type="text/javascript">
                            alert("Error: Unable to delete ticket.");
                            window.location = "manage-ticket.php"; // Redirect to an error page.
                        </script>';
                }

                // No need to proceed further after deleting
                exit;
            }

          

        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


if (isset($_POST['update_status'])) {
    $ticket_id = $_POST['ticket_id'];
    $status = $_POST['status'];
    
    try {
        // Update the ticket with the new status
        $sql = "UPDATE tickets SET status = :status WHERE ticket_id = :ticket_id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
        $query->execute();
        
        // Redirect back to the same page after updating the status
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } catch (PDOException $e) {
        echo "Error updating status: " . $e->getMessage();
    }
}


if (isset($_POST['update_category'])) {
    $ticket_id = $_POST['ticket_id'];
    $concern_category = $_POST['concern_category'];

    try {
        // Update the ticket with the new concern category
        $sql = "UPDATE tickets SET concern_category = :concern_category WHERE ticket_id = :ticket_id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':concern_category', $concern_category, PDO::PARAM_STR);
        $query->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
        $query->execute();

        // Redirect back to the same page after updating the concern category
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } catch (PDOException $e) {
        echo "Error updating concern category: " . $e->getMessage();
    }
}


try {
    // Assuming you already have a database connection in $dbh

    // Retrieve ticket history along with employee name for each ticket
    $sql = "SELECT t.*, e.EmpName AS EmployeeName FROM tickets t
            INNER JOIN tblemployee e ON t.employee_id = e.ID";
    $query = $dbh->prepare($sql);
    $query->execute();
    $ticketHistory = $query->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

        
<!DOCTYPE html>
<html lang="en">

<head>
    <title>MANPOWER ALLOCATION AND PLANNING SYSTEM || Supervisor Dashboard</title>
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
                                    <h2>Manage Tickets</h2>
                                </div>
                            </div>
                            <div class="row">
                            <div class="col-md-12">
                                <div class="white_shd full margin_bottom_30">
                                    <div class="full graph_head">
                                        <div class="heading1 margin_0">
                                            <h2>Ticket Overview</h2>
                                        </div>
                                    </div>
                                <div class="table_section padding_infor_info">
                                    <div>
                                        <a href = "./ticket-pending.php"><button class="btn btn-primary">Pending</button></a>
                                        <a href = "./ticket-processing.php"><button class="btn btn-primary">Processing</button></a>
                                        <a href = "./ticket-resolved.php"><button class="btn btn-primary">Resolved</button></a>
                                        <a href = "./manage-ticket.php"><button class="btn btn-primary">See All</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                        <!-- Display Ticket History from Technician's Code -->


<script>
    function confirmDelete(ticketId) {
        var confirmation = confirm('Are you sure you want to delete this ticket?');
        if (confirmation) {
            window.location.href = '?action=delete&ticket_id=' + ticketId;
        }
    }
</script>
<!-- End Display Ticket History from Technician's Code -->
                        <!-- End Display Ticket History from Technician's Code -->

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

 