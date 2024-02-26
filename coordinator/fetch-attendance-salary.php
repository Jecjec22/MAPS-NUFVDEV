<?php
include('includes/dbconnection.php');

if(isset($_POST['empName'])){
    $empName = $_POST['empName'];
    $sql = "SELECT attendance_salary FROM salary_attendance WHERE employee_name = ?";
    $query = $dbh->prepare($sql);
    $query->execute([$empName]);
    $result = $query->fetch(PDO::FETCH_ASSOC);
    if($result){
        echo $result['attendance_salary'];
    } else {
        echo "0"; // Default value if not found
    }
}
?>
