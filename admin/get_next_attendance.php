<?php
session_start();
include('includes/dbconnection.php');

if (strlen($_SESSION['etmsaid']) == 0) {
    header('location:logout.php');
    exit();
}

if (isset($_POST['currentIndex'])) {
    $currentIndex = intval($_POST['currentIndex']);

    // Assuming date is the column representing attendance dates
    $sql = "SELECT * FROM tblattendance ORDER BY date DESC LIMIT 1 OFFSET $currentIndex";
    $query = $dbh->prepare($sql);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    // Return the HTML for the new attendance records
    foreach ($result as $row) {
        echo '<tr>';
        echo '<td>' . $row['emp_names'] . '</td>';
        echo '<td>' . $row['day'] . '</td>';
        echo '<td>' . $row['date'] . '</td>';
        echo '<td>' . $row['time_in_datetime'] . '</td>';
        echo '<td>' . $row['time_out_datetime'] . '</td>';
        echo '<td>' . $row['num_hr'] . '</td>';
        echo '</tr>';
    }
} else {
    echo 'Invalid request';
}
?>
