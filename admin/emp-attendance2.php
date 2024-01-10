<?php
session_start();
include('includes/dbconnection.php');

if (strlen($_SESSION['etmsaid']) == 0) {
    header('location:logout.php');
} else {
    $date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

    
    $sql = "SELECT emp_names AS 'Employee Name',
                TIME_FORMAT(time_in_datetime, '%h:%i %p') AS 'Time In',
                TIME_FORMAT(time_out_datetime, '%h:%i %p') AS 'Time Out',
                CONCAT(
                    FLOOR(num_hr),
                    ' hours ',
                    FLOOR((num_hr - FLOOR(num_hr)) * 60),
                    ' mins'
                ) AS 'Time Spent',
                selfie AS 'Selfie'
            FROM tblattendance
            WHERE date = :date
            ORDER BY id";

    $query = $dbh->prepare($sql);
    $query->bindParam(':date', $date, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>MANPOWER ALLOCATION AND PLANNING SYSTEM || List of Attendance</title>
    <!-- CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="css/responsive.css" />
    <link rel="stylesheet" href="css/colors.css" />
    <link rel="stylesheet" href="css/bootstrap-select.css" />
    <link rel="stylesheet" href="css/perfect-scrollbar.css" />
    <link rel="stylesheet" href="css/custom.css" />
    <link rel="stylesheet" href="css/semantic.min.css" />
    
    <style>
        .thumbnail {
            width: 100px; /* Set your desired width */
            height: auto; /* Maintain aspect ratio */
            cursor: pointer;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            padding-top: 60px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.9);
        }

        .modal-content {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 800px;
        }

        .modal-content img {
            width: 100%;
            height: auto;
        }
    </style>
</head>
<body class="inner_page general_elements">
    <div class="full_container">
        <div class="inner_container">
            <!-- Sidebar -->
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
                                    <h2>Attendance</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row column8 graph">
                            <div class="col-md-12">
                                <div class="white_shd full margin_bottom_30">
                                    <div class="full graph_head">
                                        <div class="heading1 margin_0">
                                            <h2>Today's Attendance</h2>
                                        </div>
                                    </div>
                                   <div class="full progress_bar_inner">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="full">
                                                    <div class="padding_infor_info">
                                                        <form method="get">
                                                            <label for="date">Select Date:</label>
                                                            <input type="date" id="date" name="date" value="<?php echo $date; ?>">
                                                            <button type="submit">View</button>
                                                        </form>
                                                        <br>
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>Employee Name</th>
                                                                    <th>Time In</th>
                                                                    <th>Time Out</th>
                                                                    <th>Time Spent</th>
                                                                    <th>Selfie</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php foreach ($result as $row) { ?>
    <tr>
        <td><?php echo $row['Employee Name']; ?></td>
        <td><?php echo $row['Time In']; ?></td>
        <td><?php echo $row['Time Out']; ?></td>
        <td>
            <?php echo $row['Time Spent']; ?>
        </td>
        <td>
            <?php if (!empty($row['Selfie'])) { ?>
                <img class="thumbnail" src="images/<?php echo $row['Selfie']; ?>" alt="Selfie" onclick="showImage(this)">
            <?php } else { ?>
                No selfie available
            <?php } ?>
        </td>
    </tr>
<?php } ?>
                                                            </tbody>
                                                        </table>
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
                <!-- end dashboard inner -->
            </div>
            <!-- end right content -->
        </div>
    </div>
    <!-- JS -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/perfect-scrollbar.jquery.min.js"></script>
    <script src="js/semantic.min.js"></script>
    <script src="js/custom.js"></script>
    <script>
        function showImage(element) {
            var modal = document.createElement('div');
            modal.className = 'modal';
            modal.onclick = function() {
                modal.style.display = 'none';
            };

            var modalContent = document.createElement('img');
            modalContent.src = element.src;
            modalContent.onclick = function(event) {
                event.stopPropagation();
            };

            modal.appendChild(modalContent);
            document.body.appendChild(modal);
            modal.style.display = 'block';
        }
    </script>
</body>
</html>