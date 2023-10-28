<?php
include('includes/dbconnection.php');

if (isset($_POST['clientName'])) {
    $clientName = $_POST['clientName'];
    
    // Query the database to retrieve the address for the selected client name
    $sql = "SELECT clientAddress FROM tblclient WHERE clientName = :clientName";
    $query = $conn->prepare($sql);
    $query->bindParam(':clientName', $clientName, PDO::PARAM_STR);
    $query->execute();
    
    // Fetch and return the address
    $row = $query->fetch(PDO::FETCH_ASSOC);
    echo $row['clientAddress'];
}
