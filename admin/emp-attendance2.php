<?php
session_start();
include('includes/dbconnection.php');

if (strlen($_SESSION['etmsaid']) == 0) {
    header('location:logout.php');
} else {
    $searchClient = isset($_POST['searchClient']) ? '%' . strtolower($_POST['searchClient']) . '%' : '%';
    $searchStatus = isset($_POST['searchStatus']) ? '%' . strtolower($_POST['searchStatus']) . '%' : '%';

    if (isset($_POST['showAll'])) {
        $searchClient = '%';
        $searchStatus = '%';
    }
    
    $sql = "SELECT tt.TaskID, t.ClientName AS Client, t.TaskTitle AS `Service Title`, tt.Status AS Status, tt.WorkCompleted, tt.UpdationDate, e.EmpName AS `Submitted by`, tt.ServiceReport
    FROM tbltasktracking tt
    JOIN tbltask t ON tt.TaskID = t.ID
    JOIN tblemployee e ON t.AssignTaskTo = e.EmpID
    WHERE LOWER(t.ClientName) LIKE :client AND LOWER(tt.Status) LIKE :status";

            
    $query = $dbh->prepare($sql);
    $query->bindParam(':client', $searchClient, PDO::PARAM_STR);
    $query->bindParam(':status', $searchStatus, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>MANPOWER ALLOCATION AND PLANNING SYSTEM || List of Service Reports</title>
    <!-- CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="css/responsive.css" />
    <link rel="stylesheet" href="css/colors.css" />
    <link rel="stylesheet" href="css/bootstrap-select.css" />
    <link rel="stylesheet" href="css/perfect-scrollbar.css" />
    <link rel="stylesheet" href="css/custom.css" />
    <link rel="stylesheet" href="css/semantic.min.css" />
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
                                    <h2>List of Service Reports</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row column8 graph">
                            <div class="col-md-12">
                                <div class="white_shd full margin_bottom_30">
                                    <div class="full graph_head">
                                        <div class="heading1 margin_0">
                                            <h2>List of Service Reports</h2>
                                        </div>
                                    </div>
                                   <div class="full progress_bar_inner">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="full">
                                                    <div class="padding_infor_info">
                                                        <form method="POST" action="">
                                                            <div class="form-group">
                                                                <label for="searchClient">Search Client (Case-insensitive):</label>
                                                                <input type="text" name="searchClient" id="searchClient" class="form-control" placeholder="Enter client name">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="searchStatus">Search Status (Case-insensitive):</label>
                                                                <input type="text" name="searchStatus" id="searchStatus" class="form-control" placeholder="Enter status">
                                                            </div>
                                                            <button type="submit" class="btn btn-primary">Search</button>
                                                            <button type="submit" class="btn btn-primary" name="showAll">Show All</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="full">
                                                    <div class="padding_infor_info">
                                                        <form id="filterForm">
                                                            <div class="form-group">
                                                                <label for="sortField">Sort By:</label>
                                                                <select id="sortField" name="sortField" class="form-control">
                                                                    <option value="TaskID">Service ID</option>
                                                                    <option value="Client">Client</option>
                                                                    <option value="Service Title">Service Title</option>
                                                                    <option value="Status">Status</option>
                                                                    <option value="UpdationDate">Updation Date</option>
                                                                </select>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary">Apply Filter</button>
                                                        </form>
                                                        <table class="table table-bordered">
    <thead>
        <tr>
            <th>Service ID</th>
            <th>Client</th>
            <th>Service Title</th>
            <th>Status</th>
            <th>Submitted by</th>
            <th>WorkCompleted</th>
            <th>UpdationDate</th>
            <th>Service Report</th> <!-- New column for Service Report -->
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($result as $row) {
            echo '<tr>';
            echo '<td>' . $row['TaskID'] . '</td>';
            echo '<td>' . $row['Client'] . '</td>';
            echo '<td>' . $row['Service Title'] . '</td>';
            echo '<td>' . $row['Status'] . '</td>';
            echo '<td>' . $row['Submitted by'] . '</td>';
            echo '<td>' . $row['WorkCompleted'] . '</td>';
            echo '<td>' . $row['UpdationDate'] . '</td>';
            echo '<td>';
            echo '<a href="images/' . $row['ServiceReport'] . '" target="_blank">';
            echo '<img src="images/' . $row['ServiceReport'] . '" alt="Service Report Image" style="max-width: 100px; max-height: 100px;">';
            echo '</a>';
            echo '</td>';
            echo '</tr>';
        }
        ?>
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
                    <!-- footer -->
                    <?php include_once('includes/footer.php'); ?>
                </div>
                <!-- end dashboard inner -->
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/animate.js"></script>
    <script src="js/bootstrap-select.js"></script>
    <script src="js/owl.carousel.js"></script>
    <script src="js/Chart.min.js"></script>
    <script src="js/utils.js"></script>
    <script src="js/analyser.js"></script>
    <script src="js/perfect-scrollbar.min.js"></script>
    <script>
        var ps = new PerfectScrollbar('#sidebar');
    </script>
    <script src="js/custom.js"></script>
    <script src="js/semantic.min.js"></script>
    
    <script>
    // Add JavaScript for handling sorting
    document.getElementById('filterForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const sortField = document.getElementById('sortField').value;
        const sortedResult = [...<?php echo json_encode($result); ?>].sort((a, b) => {
            if (a[sortField] < b[sortField]) return -1;
            if (a[sortField] > b[sortField]) return 1;
            return 0;
        });
        displaySortedResult(sortedResult);
    });

    function displaySortedResult(sortedResult) {
        const tableBody = document.querySelector('table tbody');
        tableBody.innerHTML = '';
        sortedResult.forEach(row => {
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>${row.TaskID}</td>
                <td>${row.Client}</td>
                <td>${row['Service Title']}</td>
                <td>${row.Status}</td>
                <td>${row['Submitted by']}</td>
                <td>${row.WorkCompleted}</td>
                <td>${row.UpdationDate}</td>
                <td><img src="${row.ServiceReport}" alt="Service Report Image" style="max-width: 100px; max-height: 100px;"></td>
            `;
            tableBody.appendChild(newRow);
        });
    }
</script>
</body>
</html>
