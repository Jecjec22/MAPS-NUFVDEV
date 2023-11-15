<?php
session_start();
//error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['etmsaid']==0)) {
  header('location:logout.php');
  } else{
    if(isset($_POST['submit']))
  {

 $deptid=$_POST['deptid'];
 $emplist=$_POST['emplist'];
 
 $tpriority=$_POST['tpriority'];
 $ttitle=$_POST['ttitle'];
 $tdesc=$_POST['tdesc'];
 $tedate=$_POST['tedate'];
 $clientName=$_POST['clientName'];
 $clientAddress=$_POST['clientAddress'];
 $startDate=$_POST['startDate'];
$sql="insert into tbltask(DeptID,AssignTaskto,TaskPriority,TaskTitle,TaskDescription,TaskEnddate, ClientName, ClientAddress, StartDate)values(:deptid,:emplist,:tpriority,:ttitle,:tdesc,:tedate,:clientName, :clientAddress, :startDate)";
$query=$dbh->prepare($sql);
$query->bindParam(':deptid',$deptid,PDO::PARAM_STR);
$query->bindParam(':emplist',$emplist,PDO::PARAM_STR);

$query->bindParam(':tpriority',$tpriority,PDO::PARAM_STR);
$query->bindParam(':ttitle',$ttitle,PDO::PARAM_STR);
$query->bindParam(':tdesc',$tdesc,PDO::PARAM_STR);
$query->bindParam(':tedate',$tedate,PDO::PARAM_STR);
$query->bindParam(':clientName', $_POST['clientName'], PDO::PARAM_STR);
$query->bindParam(':clientAddress', $_POST['clientAddress'], PDO::PARAM_STR);
$query->bindParam(':startDate', $_POST['startDate'], PDO::PARAM_STR);

 $query->execute();

   $LastInsertId=$dbh->lastInsertId();
   if ($LastInsertId>0) {
    echo '<script>alert("Task has been added.")</script>';
echo "<script>window.location.href ='add-task.php'</script>";
  }
  else
    {
         echo '<script>alert("Something Went Wrong. Please try again")</script>';
    }

  
}

?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Manpower Allocation and Planning System || Add Service</title>
    
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
     <script type="text/javascript">
function getemp(val) {
$.ajax({
type: "POST",
url: "get_emp.php",
data:'deptid='+val,
success: function(data){
$("#emplist").html(data);
}
});
}
</script>

     </script>
   </head>
   <body class="inner_page general_elements">
      <div class="full_container">
         <div class="inner_container">
            <!-- Sidebar  -->
           <?php include_once('includes/sidebar.php');?>
            <!-- end sidebar -->
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
                              <h2>Add Service</h2>
                           </div>
                        </div>
                     </div>
                     <!-- row -->
                     <div class="row column8 graph">
                      
                        <div class="col-md-12">
                           <div class="white_shd full margin_bottom_30">
                              <div class="full graph_head">
                                 <div class="heading1 margin_0">
                                    <h2>Add Service</h2>
                                 </div>
                              </div>
                              <div class="full progress_bar_inner">
                                 <div class="row">
                                    <div class="col-md-12">
                                       <div class="full">
                                          <div class="padding_infor_info">
                                             <div class="alert alert-primary" role="alert">
                                                <form method="post">
                        <fieldset>


                        <div class="field">
                              <label class="label_field">Service Title</label>
                              <input type="text" name="ttitle" value="" class="form-control" required='true'>
                           </div>

  <br>
                           <div class="field">
                                            <label class="label_field">Client Name</label>
                                            <select name="clientName" class="form-control" required="true">

                                                <option value="">Select Client Name</option>
                                                <?php
                                                // Connect to the database
                                                $conn = new PDO("mysql:host=localhost;dbname=etmsdb", "root", "");

                                                // Fetch client names from tblclient
                                                $sql = "SELECT clientName FROM tblclient";
                                                $stmt = $conn->query($sql);

                                                // Loop through results and populate the dropdown
                                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                    echo "<option value='{$row['clientName']}'>{$row['clientName']}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                           <br>
                           <br>
                           <div class="field">
                              <label class="label_field">Service Address</label>
                              <select name="clientAddress" class="form-control" required="true">
                              <option value="">Select Client Address</option>
                                                <?php
                                    $conn = new PDO("mysql:host=localhost;dbname=etmsdb", "root", "");
                                    $sql = "SELECT clientAddress FROM tblclient";
                                    $stmt = $conn->query($sql);
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                       echo "<option value='{$row['clientAddress']}'>{$row['clientAddress']}</option>";
                                   }
                                   ?>
                               </select>
                           </div>
                           <br>


                           <br>
                           <div class="field">
                              <label class="label_field">Service Description</label>
                              <textarea type="text" name="tdesc" value="" class="form-control" required='true'></textarea>
                           </div>
                           <br>
                           
                           <div class="field">
  <label class="label_field">Service for</label>
  <select type="text" name="deptid" id="deptid" onChange="getemp(this.value); getemp2(this.value);" value="" class="form-control" required='true'>
    <option value="">Select Employee</option>
    <?php 
    $sql2 = "SELECT * from tbldepartment";
    $query2 = $dbh->prepare($sql2);
    $query2->execute();
    $result2 = $query2->fetchAll(PDO::FETCH_OBJ);
    foreach ($result2 as $row2) {          
    ?>  
    <option value="<?php echo htmlentities($row2->ID);?>"><?php echo htmlentities($row2->DepartmentName);?></option>
    <?php } ?>
  </select>
</div>

                           <br>
                           <div class="field">
                              <div class="field">
                              <label class="label_field">Employee</label>
                              <select type="text" name="emplist" id="emplist" value="" class="form-control" required='true'>

                              </select>
                              </div>
                           <br>
                         <!--  <div class="field">
                              <div class="field">
                              <label class="label_field">Employee List2</label>
                              <select type="text" name="emplist2" id="emplist2" value="" class="form-control" required='true'>
    -->
                              </select>
                           </div>
                           </div>
                           <br>
                          <div class="field">
                              <div class="field">
                              <label class="label_field">Services Needed</label>
                              <select type="text" name="tpriority" value="" class="form-control" required='true'>
                                 <option value="">Select Services Needed</option>
                                 <option value="Repair">Repair</option>
                                 <option value="Maintenance">Maintenance</option>
                                 <option value="Installation">Installation</option>
                                 <option value="Repair and Maintenance">Repair and Maintenance</option>
                                 <option value="Repair and Installation">Repair and Installation</option>
                                 <option value="Maintenance and Installation">Maintenance and Installation</option>
                                 <option value="Repair, Maintenance, and Installation">Repair, Maintenance, and Installation</option>
                                
                              </select>
                           </div>
                           </div>
<br>

<div class="field">
  <label class="label_field">Service Start Date</label>
  <input type="date" name="startDate" value="" class="form-control" required='true'>
</div>
<br>

<div class="field">
                              <label class="label_field">Service Deadline</label>
                              <input type="date" name="tedate" value="" class="form-control" required='true'>
                           </div>
                           <br>
                           
                           <div class="field margin_0">
                              <label class="label_field hidden">hidden label</label>
                              <button class="main_bt" type="submit" name="submit" id="submit">Add</button>
                           </div>
                        </fieldset>
                     </form></div>
                                            
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- funcation section -->
                     
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
      <script src="https://code.jquery.com/jquery-3.1.1.min.js">
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
      <!-- calendar file css -->    
      <script src="js/semantic.min.js"></script>
   </body>
</html><?php } ?>