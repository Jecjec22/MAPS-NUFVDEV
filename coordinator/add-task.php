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
 $tpriority=$_POST['tpriority'];
 $ttitle=$_POST['ttitle'];
 $tdesc=$_POST['tdesc'];
 $tedate=$_POST['tedate'];
$sql="insert into tbltask(DeptID,TaskPriority,TaskTitle,TaskDescription,TaskEnddate)values(:deptid,:tpriority,:ttitle,:tdesc,:tedate)";
$query=$dbh->prepare($sql);
$query->bindParam(':deptid',$deptid,PDO::PARAM_STR);
$query->bindParam(':tpriority',$tpriority,PDO::PARAM_STR);
$query->bindParam(':ttitle',$ttitle,PDO::PARAM_STR);
$query->bindParam(':tdesc',$tdesc,PDO::PARAM_STR);
$query->bindParam(':tedate',$tedate,PDO::PARAM_STR);

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
      <title>MANPOWER ALLOCATION AND PLANNING SYSTEM || Add Service</title>
    
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
                                    <h2>Service Details</h2>
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
                              <label class="label_field">Role</label>
                              <select type="text" name="deptid" id="deptid" value="" class="form-control" required='true'>
                                 <option value="">Select Role</option>
                                  <?php 

$sql2 = "SELECT * from   tbldepartment ";
$query2 = $dbh -> prepare($sql2);
$query2->execute();
$result2=$query2->fetchAll(PDO::FETCH_OBJ);

foreach($result2 as $row2)
{          
    ?>  
   
<option value="<?php echo htmlentities($row2->ID);?>"><?php echo htmlentities($row2->DepartmentName
    );?></option>
 <?php } ?>
                              </select>
                           </div>
                           <br>
                           <div class="field">
                              <label class="label_field">Service Title</label>
                              <input type="text" name="ttitle" value="" class="form-control" required='true'>
                           </div>
                           <br>
                           <br>
                           <div class="field">
                              <label class="label_field">Client Name</label>
                              <input type="text" name="ttitle" value="" class="form-control" required='true'>
                           </div>
                           <br>
                           <br>
                           <div class="field">
                              <label class="label_field">Service Address</label>
                              <input type="text" name="ttitle" value="" class="form-control" required='true'>
                           </div>
                           <br>
                           <div class="field">
                              <label class="label\\_field">Service Description</label>
                              <textarea type="text" name="tdesc" value="" class="form-control" required='true'></textarea>
                           </div>
                           <br>
                          <div class="field">
                              <div class="field">
                              <label class="label_field">Services Needed</label>
                              <select type="text" name="tpriority" value="" class="form-control" required='true'>
                                 <option value="">Select Services Needed</option>
                                 <option value="Repair">Repair</option>
                                 <option value="Maintenance">Maintenztenance</option>
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
   </body>
</html><?php } ?>