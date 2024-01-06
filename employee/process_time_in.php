<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (isset($_POST['submit'])) {
    $etmsempid = $_SESSION['etmsempid'];

    // Assuming you have a table named 'time_in_records'
    $sql = "INSERT INTO tblattendance (etmsempid, time_in_datetime) VALUES (:etmsempid, NOW())";
    
    $query = $dbh->prepare($sql);
    $query->bindParam(':etmsempid', $etmsempid, PDO::PARAM_STR);

    if ($query->execute()) {
        // Time in record added successfully
        echo '<script>alert("Time in recorded successfully.");</script>';
        echo '<script>window.location.replace("dashboard.php");</script>';
    } else {
        // Error occurred while adding time in record
        echo '<script>alert("Error recording time in. Please try again.");</script>';
        echo '<script>window.location.replace("dashboard.php");</script>';
    }
} else {
    // Handle the case where the form was not submitted properly
    echo '<script>window.location.replace("dashboard.php");</script>';
}
?>
