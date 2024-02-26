<?php
include('includes/dbconnection.php');

if (isset($_POST['empName'])) {
    $empName = $_POST['empName'];
    
    // Query the database to get the attendance salary based on employee name
    $sql = "SELECT attendance_salary FROM salary_attendance WHERE employee_name = :empName";
    $query = $dbh->prepare($sql);
    $query->bindParam(':empName', $empName, PDO::PARAM_STR);
    $query->execute();
    
    // Fetch the result
    $result = $query->fetch(PDO::FETCH_ASSOC);
    
    // Output the attendance salary
    if ($result) {
        echo $result['attendance_salary'];
    } else {
        echo "No data found";
    }
}
?>
