<?php
session_start();
include('includes/dbconnection.php');

if (strlen($_SESSION['etmsaid']) == 0) {
    header('location:logout.php');
} else {
    if (isset($_POST['updateDate'])) {
        // Code to update dates only
        $startDate = $_POST['startDate'];
        $endDate = $_POST['tedate'];
        $eid = $_GET['editid'];

        $sql = "UPDATE tbltask SET StartDate=:startDate, TaskEnddate=:endDate WHERE ID=:eid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':startDate', $startDate, PDO::PARAM_STR);
        $query->bindParam(':endDate', $endDate, PDO::PARAM_STR);
        $query->bindParam(':eid', $eid, PDO::PARAM_STR);
        $query->execute();

        echo '<script>alert("Service dates updated successfully")</script>';
    }

    if (isset($_POST['submit'])) {
        // Code to update all fields including dates
        $deptid = $_POST['deptid'];
        $emplist = $_POST['emplist'];
        $tpriority = $_POST['tpriority'];
        $ttitle = $_POST['ttitle'];
        $tdesc = $_POST['tdesc'];
        $tedate = $_POST['tedate'];
        $startDate = $_POST['startDate'];
        $eid = $_GET['editid'];

        // Retrieve leave requests for the assigned employee with 'approved' status
        $sqlLeave = "SELECT start_date, end_date FROM leave_requests WHERE employee_id = :emplist AND status = 'approved'";

        $queryLeave = $dbh->prepare($sqlLeave);
        $queryLeave->bindParam(':emplist', $emplist, PDO::PARAM_STR);
        $queryLeave->execute();
        $leaveResults = $queryLeave->fetchAll(PDO::FETCH_ASSOC);

        // Check for leave overlap
        $leaveOverlap = false;

        // Iterate through the leave requests
        foreach ($leaveResults as $leave) {
            $leaveStartDate = new DateTime($leave['start_date']);
            $leaveEndDate = new DateTime($leave['end_date']);
            $taskStartDate = new DateTime($startDate);
            $taskEndDate = new DateTime($tedate);
        
            // Check if the leave request is 'approved'
            if ($taskStartDate <= $leaveEndDate && $taskEndDate >= $leaveStartDate && $leave['status'] === 'approved') {
                // There is an overlap with an 'approved' leave request, set the flag to true
                $leaveOverlap = true;
                break;
            }
        }
        
        if ($leaveOverlap) {
            echo '<script>alert("Leave dates overlap with the task assignment dates. Please select different dates or employee.")</script>';
        } else {
            // No leave overlap, proceed with the task assignment
            $sql = "UPDATE tbltask SET DeptID=:deptid, AssignTaskto=:emplist, TaskPriority=:tpriority, TaskTitle=:ttitle, TaskDescription=:tdesc, TaskEnddate=:tedate, StartDate=:startDate WHERE ID=:eid";
            $query = $dbh->prepare($sql);
            $query->bindParam(':deptid', $deptid, PDO::PARAM_STR);
            $query->bindParam(':emplist', $emplist, PDO::PARAM_STR);
            $query->bindParam(':tpriority', $tpriority, PDO::PARAM_STR);
            $query->bindParam(':ttitle', $ttitle, PDO::PARAM_STR);
            $query->bindParam(':tdesc', $tdesc, PDO::PARAM_STR);
            $query->bindParam(':tedate', $tedate, PDO::PARAM_STR);
            $query->bindParam(':startDate', $startDate, PDO::PARAM_STR);
            $query->bindParam(':eid', $eid, PDO::PARAM_STR);
            $query->execute();
        
            echo '<script>alert("Service details updated successfully")</script>';
        }
    }
}
    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>MANPOWER ALLOCATION AND PLANNING SYSTEM || Allocate Technician</title>

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

</head>
<body class="inner_page general_elements">
<div class="full_container">
    <div class="inner_container">
        <!-- Sidebar  -->
        <?php include_once('includes/sidebar.php'); ?>
        <!-- end sidebar -->
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
                                <h2>Allocate Technician</h2>
                            </div>
                        </div>
                    </div>
                    <!-- row -->
                    <div class="row column8 graph">

                        <div class="col-md-12">
                            <div class="white_shd full margin_bottom_30">
                                <div class="full graph_head">
                                    <div class="heading1 margin_0">
                                    <h2>Allocate Technician</h2>
                                    </div>
                                </div>
                                <div class="full progress_bar_inner">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="full">
                                                <div class="padding_infor_info">
                                                    <div class="alert alert-primary" role="alert">
                                                    <form method="post" onsubmit="return validateForm();">


                                                        <?php
                                                        $eid = $_GET['editid'];
                                                        $sql = "SELECT tbltask.ID as tid, tbltask.TaskTitle, tbltask.DeptID, tbltask.TaskPriority, tbltask.TaskPriority, tbltask.StartDate, tbltask.AssignTaskto, tbltask.TaskDescription, tbltask.TaskEnddate, tbltask.TaskAssigndate, tbltask.TaskTitle, tblrole.EmployeeRole, tblrole.ID as did, tblemployee.EmpName, tblemployee.EmpId FROM tbltask LEFT JOIN tblrole ON tblrole.ID = tbltask.DeptID LEFT JOIN tblemployee ON tblemployee.ID = tbltask.AssignTaskto WHERE tbltask.ID = :eid";
                                                        $query = $dbh->prepare($sql);
                                                        $query->bindParam(':eid', $eid, PDO::PARAM_STR);
                                                        $query->execute();
                                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                        $cnt = 1;
                                                        if ($query->rowCount() > 0) {
                                                            foreach ($results as $row) {
                                                                ?>
                                                                <fieldset>
                                    <div class="field">
                                        <label class="label_field">Work for</label>
                                        <select type="text" id="deptid" name="deptid" class="form-control" required='true'>
                                            <option value="<?php echo htmlentities($row->DeptID); ?>"><?php echo htmlentities($row->EmployeeRole); ?></option>
                                            <?php
                                            $sql2 = "SELECT * from tblrole ";
                                            $query2 = $dbh->prepare($sql2);
                                            $query2->execute();
                                            $result2 = $query2->fetchAll(PDO::FETCH_OBJ);
                                            foreach ($result2 as $row2) {
                                                ?>
                                                <option value="<?php echo htmlentities($row2->ID); ?>"><?php echo htmlentities($row2->EmployeeRole); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <br>
                                    <div class="field">
                                        <label class="label_field">Assigned to</label>
                                        <select type="text" id="emplist" name="emplist" class="form-control" required='true'>
                                            <option value="<?php echo htmlentities($row->AssignTaskto); ?>">
                                                <?php echo htmlentities($row->EmpName); ?>(<?php echo htmlentities($row->EmpId); ?>)
                                            </option>
                                            <?php
                                            // Fetch a list of available employees
                                            $start_date = $row->StartDate;
                                            $end_date = $row->TaskEnddate;

                                            $sql2 = "SELECT tblemployee.ID, tblemployee.EmpName, tblemployee.EmpId
                                                    FROM tblemployee
                                                    WHERE tblemployee.ID NOT IN (
                                                        SELECT AssignTaskto
                                                        FROM tbltask
                                                        WHERE (:start_date BETWEEN StartDate AND TaskEnddate
                                                            OR :end_date BETWEEN StartDate AND TaskEnddate)
                                                    )";

                                            $query2 = $dbh->prepare($sql2);
                                            $query2->bindParam(':start_date', $row->StartDate, PDO::PARAM_STR);
                                            $query2->bindParam(':end_date', $row->TaskEnddate, PDO::PARAM_STR);
                                            $query2->execute();
                                            $result2 = $query2->fetchAll(PDO::FETCH_OBJ);

                                            foreach ($result2 as $row3) {
                                                ?>
                                                <option value="<?php echo htmlentities($row3->ID); ?>">
                                                    <?php echo htmlentities($row3->EmpName); ?>(<?php echo htmlentities($row3->EmpId); ?>)
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>


                                




                                        </div>
                                        <br>
                                        <div class="field">
                                            <div class="field">
                                                <label class="label_field">Services Needed</label>
                                                <select type="text" id="tpriority" name="tpriority" class="form-control" required='true'>
                                                    <option value="<?php echo htmlentities($row->TaskPriority); ?>"><?php echo htmlentities($row->TaskPriority); ?></option>
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
                                            <label class="label_field">Service Title</label>
                                            <input type="text" id="ttitle" name="ttitle" value="<?php echo htmlentities($row->TaskTitle); ?>" class="form-control" required='true'>
                                        </div>
                                        <br>
                                        <div class="field">
                                            <label class="label_field">Service Description</label>
                                            <textarea id="tdesc" name="tdesc" class="form-control" required='true'><?php echo htmlentities($row->TaskDescription); ?></textarea>
                                        </div>
                                        <br>
                                        <div class="field">
                                            <label class="label_field">Service Start Date</label>
                                            <input type="date" id="startDate" name="startDate" value="<?php echo htmlentities($row->StartDate); ?>" class="form-control" required='true'>
                                        </div>
                                        <br>
                                        <div class="field">
                                            <label class="label_field">Service Deadline</label>
                                            <input type="date" id="endDate" name="tedate" value="<?php echo htmlentities($row->TaskEnddate); ?>" class="form-control" required='true'>
                                        </div>
                                        <br>
        

                                        <br>
                                        <br>
                                        
                                        <div class="field margin_0">
        <label class="label_field hidden">hidden label</label>
     <br>
        <button class="main_bt" type="submit" name="updateDate" id="updateDate">Update Date</button> 
        
                                   
        <button class="main_bt" type="submit" name="submit" id="submit">Allocate</button>
    </div>
                                    </fieldset>
                                </form>

                                
                            </div>
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
<?php include_once('includes/footer.php'); ?>
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
<!-- custom js -->
<script src="js/custom.js"></script>
<!-- calendar file css -->
<script src="js/semantic.min.js"></script>
<!-- Start Date and End Date validation -->
<script>
   function validateForm() {
    var startDate = new Date(document.getElementById("startDate").value);
    var endDate = new Date(document.getElementById("tedate").value);
    var updateDateButton = document.getElementById("updateDate");
    var submitButton = document.getElementById("submit");

    if (document.activeElement === updateDateButton) {
        // "Update Date" button was clicked, allow the form to be submitted without date validation
        return true;
    } else if (document.activeElement === submitButton) {
        // "Allocate" button was clicked, apply date validation
        if (startDate > endDate) {
            alert("Start Date can't be later than End Date");
            return false;
        }

        // Check for leave overlap here
        // (You have already implemented this part)

        // If there is a leave overlap, show an alert and prevent form submission
        if (leaveOverlap) {
            alert("Leave dates overlap with the task assignment dates. Please select different dates or employee.");
            return false;
        }
    }
    return true;
    }
</script>



</script>
</body>
</html>
<?php
}
                                                            }
?>