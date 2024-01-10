<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (empty($_SESSION['etmsempid'])) {
    header('location:logout.php');
    exit;
}

if (isset($_POST['submit'])) {
    $concern_title = $_POST['concern_title'];
    $concern_details = $_POST['concern_details'];
    $concern_category = $_POST['concern_category'];
    $creation_date = date('Y-m-d H:i:s'); // Get current date and time
    $employee_name = $_SESSION['etmsempid'];

    try {
        // Assuming you already have a database connection in $dbh

        // Insert ticket using the retrieved employee name
        $sql = "INSERT INTO tickets (employee_id, concern_title, concern_details, concern_category, creation_date, feedback) VALUES (:employee_name, :concern_title, :concern_details, :concern_category, :creation_date, 'pending')";
        $query = $dbh->prepare($sql);
        $query->bindParam(':employee_name', $employee_name, PDO::PARAM_STR); // Bind the name to the 'employee_name' parameter
        $query->bindParam(':concern_title', $concern_title, PDO::PARAM_STR);
        $query->bindParam(':concern_details', $concern_details, PDO::PARAM_STR);
        $query->bindParam(':concern_category', $concern_category, PDO::PARAM_STR);
        $query->bindParam(':creation_date', $creation_date, PDO::PARAM_STR);

        // Execute the INSERT query
        if ($query->execute()) {
            echo '<script type="text/javascript">
                    window.onload = function() {
                        var confirmation = confirm("Ticket submitted successfully!");
                        if (confirmation) {
                            window.location = "ticket-history.php"; // Redirect to a specific page after confirmation.
                        } else {
                            // User clicked "Cancel" in the prompt.
                            // Handle this case as needed.
                        }
                    }
                  </script>';
        } else {
            echo '<script type="text/javascript">
                    alert("Error: Unable to submit ticket.");
                    window.location = "ticket-history.php"; // Redirect to an error page.
                  </script>';
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>MANPOWER ALLOCATION AND PLANNING SYSTEM || Tickets</title>
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
                                    <h2>File a Ticket</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="white_shd full margin_bottom_30">
                                    <div class="full graph_head">
                                        <div class="heading1 margin_0">
                                            <h2>File A Ticket</h2>
                                        </div>
                                    </div>
                                    <div class="table_section padding_infor_info">
                                        <form method="post">
                                            <div class="form-group">
                                                <label for="concern_title">Concern Title:</label>
                                                <input type="text" name="concern_title" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="concern_details">Concern Details:</label>
                                                <textarea name="concern_details" class="form-control" required></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="concern_category">Concern Category:</label>
                                                <select name="concern_category" class="form-control" required>
                                                    <option value="category1">1</option>
                                                    <option value="category2">2</option>
                                                
                                                </select>
                                            </div>

                                            <button type="submit" name="submit" class="btn btn-primary">Submit Ticket</button>
                                            
                                           
                                        </form>
                                       
                                    </div>
                                    <a href = "ticket-history.php"><button class="btn btn-primary">See Ticket History</button></a>
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
</html>
