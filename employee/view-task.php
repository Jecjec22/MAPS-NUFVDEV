<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['etmsempid']) == 0) {
    header('location: logout.php');
    exit; // Stop further execution
} else {
    if (isset($_POST['submit'])) {
        $vid = $_GET['viewid'];
        $status = $_POST['status'];
        $remark = $_POST['remark'];
        $workcom = $_POST['workcom'];
        $picss = $_FILES["pics"]["name"];
        $tempFile = $_FILES["pics"]["tmp_name"];
        $targetDirectory = "C:/xampp3/htdocs/MAPS-NUFVDEV/coordinator/images/";

        // Handle file upload
        if (move_uploaded_file($tempFile, $targetDirectory . $picss)) {
            // File successfully moved to the directory

            // Insert data into the database
            $sql = "INSERT INTO tbltasktracking (TaskID, Remark, Status, WorkCompleted, ServiceReport) VALUES (:vid, :remark, :status, :workcom, :pics)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':vid', $vid, PDO::PARAM_STR);
            $query->bindParam(':remark', $remark, PDO::PARAM_STR);
            $query->bindParam(':status', $status, PDO::PARAM_STR);
            $query->bindParam(':workcom', $workcom, PDO::PARAM_STR);
            $query->bindParam(':pics', $picss, PDO::PARAM_STR);
            $query->execute();

            // Update other fields in the tbltask and tbltasktracking tables
            $sql = "UPDATE tbltask SET Status = :status, Remark = :remark, WorkCompleted = :workcom WHERE ID = :vid";
            $query = $dbh->prepare($sql);
            $query->bindParam(':status', $status, PDO::PARAM_STR);
            $query->bindParam(':remark', $remark, PDO::PARAM_STR);
            $query->bindParam(':workcom', $workcom, PDO::PARAM_STR);
            $query->bindParam(':vid', $vid, PDO::PARAM_STR);
            $query->execute();

            echo '<script>alert("Remark has been updated")</script>';
            echo "<script>window.location.href ='all-task.php'</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      
      <title>MANPOWER ALLOCATION AND PLANNING SYSTEM || View New Service</title>
   
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
            <!-- Sidebar  -->
          <?php include_once('includes/sidebar.php');?>
            <!-- right content -->
            <div id="content">
               <!-- topbar -->
              <?php include_once('includes/header.php');?>
               <!-- end topbar -->
               <!-- dashboard inner -->
               <div class="midde_cont">
                  <div class="container-fluid">
                     <div class="row column_title">
                        <div class="col-md-12">
                           <div class="page_title">
                              <h2> Service Details</h2>
                           </div>
                        </div>
                     </div>
                     <!-- row -->
                     <div class="row">
                     
                      
                        <div class="col-md-12">
                           <div class="white_shd full margin_bottom_30">
                              <div class="full graph_head">
                                 <div class="heading1 margin_0">
                                    <h2>View Service Details</h2>
                                 </div>
                              </div>
                              <div class="table_section padding_infor_info">
                                 <div class="table-responsive-sm">
                                    <?php
                                           $vid=$_GET['viewid'];
$sql="SELECT tbltask.ID as tid,tbltask.TaskTitle,tbltask.TaskDescription,tbltask.TaskPriority,tbltask.ClientName,tbltask.ClientAddress,tbltask.TaskEnddate,tbltask.Status,tbltask.WorkCompleted,tbltask.Remark,tbltask.UpdationDate,tbltask.DeptID,tbltask.AssignTaskto,tbltask.TaskEnddate,tbltask.StartDate,tblrole.EmployeeRole,tblrole.ID as did,tblemployee.EmpName,tblemployee.EmpId from tbltask join tblrole on tblrole.ID=tbltask.DeptID join tblemployee on tblemployee.ID=tbltask.AssignTaskto where tbltask.ID=:vid";
$query = $dbh -> prepare($sql);
$query-> bindParam(':vid', $vid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?> 
                                   <table class="table table-bordered" style="color:#000">
                                    <tr>
    <th colspan="6" style="color: orange;font-weight: bold;font-size: 20px;text-align: center;">Service Details </th>
  </tr>
  <tr>
    <th>Service Title</th>
    <td><?php  echo $row->TaskTitle;?></td>
     <th>Services Needed</th>
    <td><?php  echo $row->TaskPriority;?></td>
  </tr>
  <tr>
    <th>Client Name</th>
    <td colspan="3"><?php  echo $row->ClientName;?></td>
 </tr>
 <tr>
    <th>Client Address</th>
    <td colspan="3"><?php  echo $row->ClientAddress;?></td>
 </tr>
 <tr>
    <th>Service Description</th>
    <td colspan="3"><?php  echo $row->TaskDescription;?></td>
 </tr>
 <tr>
     <th>Service Start Date</th>
    <td colspan="3"><?php  echo $row->StartDate;?></td>
  </tr>

 <tr>
     <th>Service Deadline</th>
    <td colspan="3"><?php  echo $row->TaskEnddate;?></td>
  </tr>

  <tr>
     
         <th>Employee Final Remark</th>
    <?php if($row->Status==""){ ?>

                     <td  colspan="4"><?php echo "Not Updated Yet"; ?></td>
<?php } else { ?>                  
  <td colspan="4"><?php  echo htmlentities($row->Remark);?>
                  </td>
  </tr>

  <tr>
   
    <th>Service Final Status</th>
   <td colspan="3"> <?php  $status=$row->Status;
    
if($row->Status=="Inprogress")
{
  echo "In Progress";
}

if($row->Status=="Completed")
{
 echo "Completed";
}


if($row->Status=="")
{
  echo "Not Response Yet";
}


     ;?></td>

                  <?php } ?>  

  </tr>

  <?php $cnt=$cnt+1;}} ?>
</table>

<?php
$vid = $_GET['viewid'];
if ($status != "") {
    $ret = "SELECT tbltasktracking.Remark, tbltasktracking.Status, tbltasktracking.UpdationDate, tbltasktracking.WorkCompleted, tbltasktracking.ServiceReport
            FROM tbltasktracking
            WHERE tbltasktracking.TaskID = :vid";
    $query = $dbh->prepare($ret);
    $query->bindParam(':vid', $vid, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    $cnt = 1;
?>
    <!-- Add a new section for displaying the Service Report history -->
    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="color: #000; border-collapse: collapse; border-spacing: 0; width: 100%;">
        <tr align="center">
            <th colspan="5">Service Report History</th>
        </tr>
        <tr>
            <th>#</th>
            <th>Remark</th>
            <th>Status</th>
            <th>Service Progress</th>
            <th>Time</th>
           
        </tr>
        <?php
        foreach ($results as $row) {
        ?>
            <tr>
                <td><?php echo $cnt; ?></td>
                <td><?php echo $row->Remark; ?></td>
                <td><?php echo $row->Status; ?></td>
                <td>
                    <span class="skill" style="width: 90%;">Service Progress<span class="info_valume"><?php echo $row->WorkCompleted; ?>%</span></span>
                    <div class="progress skill-bar">
                        <div class="progress-bar progress-bar-animated progress-bar-striped" role="progressbar" aria-valuenow="<?php echo $row->WorkCompleted; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $row->WorkCompleted; ?>%;"></div>
                    </div>
                </td>
                <td><?php echo $row->UpdationDate; ?></td>
                <!-- Display Service Report as a clickable link -->
                <td>
                <?php

?>




                </td>
            </tr>
        <?php
            $cnt = $cnt + 1;
        }
        ?>
    </table>
<?php  }  
?>

<?php 

if ($status=="" || $status=="Inprogress"){
?> 
<p align="center"  style="padding-top: 20px">                            
 <button class="btn btn-primary waves-effect waves-light w-lg" data-toggle="modal" data-target="#myModal">Update</button></p>  
 <div class="modal-footer">
    
    
</div>
<?php } ?>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
     <div class="modal-content" style="width:150%">
      <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Update</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                <table class="table table-bordered table-hover data-tables">
                                                <form method="post" name="submit" enctype="multipart/form-data">

     <tr>
    <th width="300">Remark :</th>
    <td>
    <textarea name="remark" placeholder="Remark" rows="12" cols="14" class="form-control wd-650" required="true"></textarea></td>
  </tr> 
  
   <tr>
    <th>Work Completion(in percentage) :</th>
    <td>
    <input name="workcom" placeholder="Work Completion in percentage (Eg: 20)" pattern="[0-9]+" title="only numbers" rows="12" cols="14" class="form-control wd-450" required="true"></td>
  </tr> 
  <tr>
    <th>Status :</th>
    <td>
   <select name="status" class="form-control wd-450" required="true" >
     <option value="Inprogress" selected="true">Inprogress</option>
     <option value="Completed">Completed</option>
   </select></td>
  </tr>
   <tr><tr>
  <label for="pics">Upload Service Report:</label>
  <input type="file" name="pics" class="form-control-file" id="pics" required="true">
  </td>
</tr>
                                             
</table>
</div>
<div class="modal-footer">
 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
 <button type="submit" name="submit" class="btn btn-primary">Update</button>
  </form>
</div>
</div>
</div>
</div> 
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- footer -->
                 <?php include_once('includes/footer.php');?>
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
      <script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelector('form[name="submit"]').addEventListener('submit', function(event) {
        const fileInput = document.querySelector('input[name="pics"]');
        const filePath = fileInput.value;
        const allowedExtensions = /(\.png|\.jpg|\.jpeg|\.pdf)$/i;

        if (!allowedExtensions.exec(filePath)) {
            alert('Please upload files having extensions PNG, JPG, JPEG, or PDF only.');
            event.preventDefault();
            return false;
        }
    });
});
</script>
</body>
</html><?php  ?>