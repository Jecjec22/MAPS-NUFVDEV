<?php
session_start();
include('includes/dbconnection.php');

if (strlen($_SESSION['etmsaid']) == 0) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        // Existing code for updating other fields...

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

        echo '<script>alert("You successfully allocated the service")</script>';
    }

    if (isset($_POST['updateDate'])) {
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
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Head section code... -->
</head>
<body class="inner_page general_elements">
    <div class="full_container">
        <!-- Rest of the code... -->
        <div id="content">
            <!-- Rest of the code... -->
            <div class="midde_cont">
                <div class="container-fluid">
                    <!-- Rest of the code... -->
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
                                                        <form method="post" onsubmit="return validateDates();">
                                                            <!-- Existing form fields... -->

                                                            <div class="field margin_0">
                                                                <label class="label_field hidden">hidden label</label>
                                                                <button class="main_bt" type="submit" name="submit" id="submit">Update</button>
                                                                <button class="main_bt" type="submit" name="updateDate" id="updateDate">Update Date</button>
                                                            </div>
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
                    <!-- Rest of the code... -->
                </div>
            </div>
        </div>
        <!-- Rest of the code... -->
    </div>

    <!-- JavaScript code... -->
</body>
</html>
