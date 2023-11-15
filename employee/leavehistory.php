<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['etmsempid'] == 0)) {
    header('location:logout.php');
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

    // Query the database to fetch the technician's leave requests
    $sql = "SELECT * FROM leave_requests WHERE employee_id = :employee_id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':employee_id', $employee_name, PDO::PARAM_STR);
    $query->execute();
    $leaveRequests = $query->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Technician Leave Requests</title>
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
                              <h2>My Leave Requests</h2>
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
                                          <th>Reason</th>
                                          <th>Start Date</th>
                                          <th>End Date</th>
                                          <th>Status</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <?php foreach ($leaveRequests as $request) : ?>
                                       <tr>
                                          <td><?= $request['reason']; ?></td>
                                          <td><?= $request['start_date']; ?></td>
                                          <td><?= $request['end_date']; ?></td>
                                          <td><?= $request['status']; ?></td>
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
      <script src="js/bootstrap.min.js"></script>
      <!-- custom js -->
      <script src="js/custom.js"></script>
   </body>
</html>
