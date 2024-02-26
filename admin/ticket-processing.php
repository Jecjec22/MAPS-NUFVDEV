<?php
// Start session and include necessary files
session_start();
error_reporting(0);
include('includes/dbconnection.php');

// Function to sort ticket history by concern category
function sortTicketsByCategory($ticketHistory) {
    usort($ticketHistory, function($a, $b) {
        $categories = ['Critical', 'High', 'Normal'];
        $categoryA = array_search($a['concern_category'], $categories);
        $categoryB = array_search($b['concern_category'], $categories);
        return $categoryA <=> $categoryB;
    });
    return $ticketHistory;
}

// Function to filter ticket history by selected concern category
function filterTicketsByCategory($ticketHistory, $selectedCategory) {
    if ($selectedCategory != 'All') {
        $filteredHistory = array_filter($ticketHistory, function($ticket) use ($selectedCategory) {
            return $ticket['concern_category'] == $selectedCategory;
        });
        return $filteredHistory;
    } else {
        return $ticketHistory;
    }
}

// Check if supervisor is logged in, handle authentication and authorization as needed

try {
    // Assuming you already have a database connection in $dbh

    // Retrieve ticket history with pending status along with employee name for each ticket
    $sql = "SELECT t.*, e.EmpName AS EmployeeName FROM tickets t
            INNER JOIN tblemployee e ON t.employee_id = e.ID
            WHERE t.status = 'Processing'";
    $query = $dbh->prepare($sql);
    $query->execute();
    $ticketHistory = $query->fetchAll(PDO::FETCH_ASSOC);

    // Sort ticket history by concern category
    $ticketHistory = sortTicketsByCategory($ticketHistory);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Handle form submissions for updating status, category, and providing feedback

// Filter tickets based on selected category if form submitted
if (isset($_POST['filter_category'])) {
    $selectedCategory = $_POST['category'];
    $ticketHistory = filterTicketsByCategory($ticketHistory, $selectedCategory);
}
?>



<?php
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



if (isset($_POST['submit_feedback'])) {
    $ticket_id = $_POST['ticket_id'];
    $user_feedback = $_POST['user_feedback'];

    try {
        // Update the ticket with the provided feedback
        $sql = "UPDATE tickets SET feedback = :user_feedback WHERE ticket_id = :ticket_id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':user_feedback', $user_feedback, PDO::PARAM_STR);
        $query->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
        $query->execute();

        // Redirect back to the same page after updating the feedback
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } catch (PDOException $e) {
        echo "Error updating feedback: " . $e->getMessage();
    }
}



if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['ticket_id'])) {
    $ticket_id = $_GET['ticket_id'];
    
    try {
        // Delete the ticket
        $sql = "DELETE FROM tickets WHERE ticket_id = :ticket_id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
        $query->execute();

        // Redirect back to the same page after deleting the ticket
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } catch (PDOException $e) {
        echo "Error deleting ticket: " . $e->getMessage();
    }
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

      <style>
        table {
            color: black;
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
                                    <h2>Supervisor Dashboard</h2>
                                </div>
                            </div>
                        </div>

                        <!-- Display Ticket History from Technician's Code -->
  <!-- Display Ticket History from Technician's Code -->
<div class="row">
    <div class="col-md-12">
        <div class="white_shd full margin_bottom_30">
            <div class="full graph_head">
                <div class="heading1 margin_0">
                    <h2>Processing Tickets</h2>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <!-- Filtering Dropdown -->
                        <form method="post" action="">
                            <div class="form-group">
                                <label for="category">Select Category:</label>
                                <select name="category" class="form-control">
                                    <option value="All">All</option>
                                    <option value="Critical">Critical</option>
                                    <option value="High">High</option>
                                    <option value="Normal">Normal</option>
                                </select>
                            </div>
                            <button type="submit" name="filter_category" class="btn btn-primary">Filter</button>
                        </form>
                    </div>
                </div>
           
            <div class="table_section padding_infor_info">
                <div class="table-responsive">
                    <?php if (!empty($ticketHistory)) { ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Ticket ID</th>
                                    <th>Creation Date</th>
                                    <th>Technician</th>
                                    <th>Subject</th>
                                    <th>Details</th>
                                    <th>Category Level</th>
                                    <th>Feedback</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($ticketHistory as $ticket) { ?>
                                    <tr>
                                        <td><?php echo $ticket['ticket_id']; ?></td>
                                        <td><?php echo $ticket['creation_date']; ?></td>
                                        <td><?php echo $ticket['EmployeeName']; ?></td>
                                        <td><?php echo $ticket['concern_title']; ?></td>
                                        <td><?php echo $ticket['concern_details']; ?></td>
                                        <td>
                                            <form method="post" action="">
                                            <?php echo $ticket['concern_category']; ?>
                                                <input type="hidden" name="ticket_id" value="<?php echo $ticket['ticket_id']; ?>">
                                                <div class="form-group">
                                                    <select name="concern_category" class="form-control">
                                                        <option value="Critical" <?php if ($ticket['concern_category'] == 'Critical') echo 'selected'; ?>>Critical</option>
                                                        <option value="High" <?php if ($ticket['concern_category'] == 'High') echo 'selected'; ?>>High</option>
                                                        <option value="Normal" <?php if ($ticket['concern_category'] == 'Normal') echo 'selected'; ?>>Normal</option>
                                                    </select>
                                                </div>
                                                <button type="submit" name="update_category" class="btn btn-primary">Update Category</button>
                                            </form>
                                        </td>
                                        <td>
                                            <?php echo $ticket['feedback']; ?>
                                            <form method="post" action="">
                                                <input type="hidden" name="ticket_id" value="<?php echo $ticket['ticket_id']; ?>">
                                                <div class="form-group">
                                                    <input type="text" name="user_feedback" class="form-control" placeholder="Enter your feedback">
                                                </div>
                                                <button type="submit" name="submit_feedback" class="btn btn-primary">Give Feedback</button>
                                           
                                            </form>
                                        </td>
                                        <td>
                                            <?php echo $ticket['status']; ?>
                                            <form method="post" action="">
                                                <input type="hidden" name="ticket_id" value="<?php echo $ticket['ticket_id']; ?>">
                                                <div class="form-group">
                                                    <select name="status" class="form-control">
                                                        <option value="Pending" <?php if ($ticket['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                                                        <option value="Processing" <?php if ($ticket['status'] == 'Processing') echo 'selected'; ?>>Processing</option>
                                                        <option value="Resolved" <?php if ($ticket['status'] == 'Resolved') echo 'selected'; ?>>Resolved</option>
                                                    </select>
                                                </div>
                                                <button type="submit" name="update_status" class="btn btn-primary">Update Status</button>
                                            </form>
                                        </td>
                                    </tr>
                               
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } else { ?>
                        <p>No ticket history available.</p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Display Ticket History from Technician's Code -->


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

 