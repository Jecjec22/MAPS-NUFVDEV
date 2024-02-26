<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (empty($_SESSION['etmsempid'])) {
    header('location:logout.php');
    exit;

} else {
    $employee_id = $_SESSION['etmsempid'];

    $eid = $_SESSION['etmsempid'];
    $selectEmployeeSql = "SELECT EmpName, EmpEmail FROM tblemployee WHERE ID = :eid";
    $selectEmployeeQuery = $dbh->prepare($selectEmployeeSql);
    $selectEmployeeQuery->bindParam(':eid', $eid, PDO::PARAM_INT);
    $selectEmployeeQuery->execute();

    // Fetch the employee's name
    $employeeData = $selectEmployeeQuery->fetch();
    $employee_name = $employeeData['EmpName']; // Assuming 'EmpName' is the column name for the employee's name

   
}


try {
    // Assuming you already have a database connection in $dbh

    // Retrieve ticket history for the logged-in employee
    $employee_name = $_SESSION['etmsempid'];
    $sql = "SELECT * FROM tickets WHERE employee_id = :employee_name AND status ='pending' ORDER BY creation_date DESC";
    $query = $dbh->prepare($sql);
    $query->bindParam(':employee_name', $employee_name, PDO::PARAM_STR);
    $query->execute();
    $ticketPending = $query->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}


?>

 
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ticket_id'])) {
  $ticket_id = $_POST['ticket_id'];

 try {
     // Delete the ticket
   $sql = "DELETE FROM tickets WHERE ticket_id = :ticket_id";
     $query = $dbh->prepare($sql);
     $query->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
     $query->execute();

        // Redirect back to the same page (refresh) after deletion
     header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
    } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
     }
    }
        ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>MANPOWER ALLOCATION AND PLANNING SYSTEM || Ticket History</title>
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
                                    <h2>Pending Tickets</h2>
                                </div>
                            </div>
                        </div>
                        <!-- ... Your existing code ... -->

<!-- Ticket History Section -->
<div class="row">
    <div class="col-md-12">
        <div class="white_shd full margin_bottom_30">
            <div class="full graph_head">
                <div class="heading1 margin_0">
                    <h2>Pending Tickets</h2>
                </div>
            </div>
            <div class="table_section padding_infor_info">
                <?php if (!empty($ticketPending)) { ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Ticket ID</th>
                                <th>Subject</th>
                                <th>Details</th>
                                <th>Category Level</th>
                                <th>Creation Date</th>
                                <th>Feedback</th>
                                <th>Status<th>
                                <th>Action<th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ticketPending as $ticket) { ?>
                                <tr>
                                    <td><?php echo $ticket['ticket_id']; ?></td>
                                    <td><?php echo $ticket['concern_title']; ?></td>
                                    <td><?php echo $ticket['concern_details']; ?></td>
                                    <td><?php echo $ticket['concern_category']; ?></td>
                                    <td><?php echo $ticket['creation_date']; ?></td>
                                    <td><?php echo $ticket['feedback']; ?></td>
                                    <td><?php echo $ticket['status']; ?> </td>
                                    
                                    <td>
                                        <form method="post" action="tickets-pending.php">
                                            <input type="hidden" name="ticket_id" value="<?php echo $ticket['ticket_id']; ?>">
                                         
                                        </form>
                                    </td>
                                   <td> <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this ticket?')">Cancel</button> </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <p>No ticket history available.</p>
                <?php } ?>
            </div>
                    



            <a href = "file-ticket.php"><button class="btn btn-primary">Back</button></a>
        </div>
    </div>
</div>

<!-- ... Your existing code ... -->

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