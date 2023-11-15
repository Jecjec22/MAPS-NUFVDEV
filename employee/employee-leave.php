<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (empty($_SESSION['etmsempid'])) {
  header('location:logout.php');
  exit;
}

if (isset($_POST['submit'])) {
    $reason = $_POST['reason'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $employee_name = $_SESSION['etmsempid'];


    try {
      // Assuming you already have a database connection in $dbh
  
      // Retrieve employee name from the tblemployee table
      $eid = $_SESSION['etmsempid'];
      $selectEmployeeSql = "SELECT EmpName, EmpEmail FROM tblemployee WHERE ID = :eid";
      $selectEmployeeQuery = $dbh->prepare($selectEmployeeSql);
      $selectEmployeeQuery->bindParam(':eid', $eid, PDO::PARAM_INT);
      $selectEmployeeQuery->execute();
  
      // Fetch the employee's name
      $employeeData = $selectEmployeeQuery->fetch();
      $employee_name = $employeeData['EmpName']; // Assuming 'EmpName' is the column name for the employee's name
  
      // Insert leave request using the retrieved employee name
      $sql = "INSERT INTO leave_requests (employee_id, reason, start_date, end_date, status) VALUES (:employee_name, :reason, :start_date, :end_date, 'pending')";
      $query = $dbh->prepare($sql);
      $query->bindParam(':employee_name', $employee_name, PDO::PARAM_STR); // Bind the name to the 'employee_name' parameter
      $query->bindParam(':reason', $reason, PDO::PARAM_STR);
      $query->bindParam(':start_date', $start_date, PDO::PARAM_STR);
      $query->bindParam(':end_date', $end_date, PDO::PARAM_STR);
  
      // Execute the INSERT query
      if ($query->execute()) {
          echo '<script type="text/javascript">
                  window.onload = function() {
                      var confirmation = confirm("Leave request submitted successfully!");
                      if (confirmation) {
                          window.location = "employee-leave.php"; // Redirect to a specific page after confirmation.
                      } else {
                          // User clicked "Cancel" in the prompt.
                          // Handle this case as needed.
                      }
                  }
                </script>';
      } else {
          echo '<script type="text/javascript">
                  alert("Error: Unable to submit leave request.");
                  window.location = "employee-leave.php"; // Redirect to an error page.
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
      <title>MANPOWER ALLOCATION AND PLANNING SYSTEM || Leave</title>
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
                              <h2>Leave Request Form</h2>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-12">
                           <div class="white_shd full margin_bottom_30">
                              <div class="full graph_head">
                                 <div class="heading1 margin_0">
                                    <h2>Leave Request</h2>
                                 </div>
                              </div>
                              <div class="table_section padding_infor_info">
                                 <form method="post">
                                    <div class="form-group">
                                       <label for="reason">Reason for Leave:</label>
                                       <input type="text" name="reason" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                       <label for="start_date">Start Date:</label>
                                       <input type="date" name="start_date" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                       <label for="end_date">End Date:</label>
                                       <input type="date" name="end_date" class="form-control" required>
                                    </div>
                                    <button type="submit" name="submit" class="btn btn-primary">Submit Leave Request</button>
                                 </form>
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
      <!-- Your JavaScript code goes here -->
   </body>
</html>
