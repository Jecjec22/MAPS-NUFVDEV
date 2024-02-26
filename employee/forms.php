<?php
// Retrieve the salary information from the submitted form
$attendanceSalary = $_POST['attendanceSalary'];
$addedSalary = $_POST['addedSalary'];
$deductedSalary = $_POST['deductedSalary'];
$totalSalary = $_POST['totalSalary'];
$note = $_POST['note'];

// Retrieve additional salary details
$sss = $_POST['sss'];
$pagibig = $_POST['pagibig'];
$philhealth = $_POST['philhealth'];
$netpay = $_POST['netpay'];


// Retrieve employee name
$employeeName = $_POST['employeeName'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Salary Details Form</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        table {
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
        }

        /* CSS for hiding the print button when printing */
        @media print {
            button {
                display: none;
            }
        }
    </style>
    <script>
        function printForm() {
            window.print();
        }
    </script>
</head>

<body>
    <?php
    // Retrieve the salary information from the submitted form
    $attendanceSalary = $_POST['attendanceSalary'];
    $addedSalary = $_POST['addedSalary'];
    $deductedSalary = $_POST['deductedSalary'];
    $totalSalary = $_POST['totalSalary'];
    $note = $_POST['note'];

    // Retrieve additional salary details
    $sss = $_POST['sss'];
    $pagibig = $_POST['pagibig'];
    $philhealth = $_POST['philhealth'];
    $netpay = $_POST['netpay'];
    ?>
    <!-- Display the additional salary information -->
    
    <h1>Traves Maintenance and Services Inc.</h1>
    
    <h2>Payslip for <?= $employeeName; ?></h2> <!-- Displaying employee name here -->

    <table>
        <tr>
            <th>Field</th>
            <th>Value</th>
        </tr>
        <tr>
            <td>Attendance Salary</td>
            <td><?= $attendanceSalary; ?></td>
        </tr>
        <tr>
            <td>Additional Salary</td>
            <td><?= $addedSalary; ?></td>
        </tr>
        <tr>
            <td>Deductions</td>
            <td><?= $deductedSalary; ?></td>
        </tr>
        <tr>
            <td>Total Salary</td>
            <td><?= $totalSalary; ?></td>
        </tr>
        <tr>
            <td>Other Deductions</td>
            <td></td>
        </tr>
        <tr>
            <td>SSS</td>
            <td><?= $sss; ?></td>
        </tr>
        <tr>
            <td>Pagibig</td>
            <td><?= $pagibig; ?></td>
        </tr>
        <tr>
            <td>Philhealth</td>
            <td><?= $philhealth; ?></td>
        </tr>
        <tr>
            <td>Net Salary</td>
            <td><?= $netpay; ?></td>
        </tr>
        <tr>
            <td>Note</td>
            <td><?= $note; ?></td>
        </tr>
    </table>

    <!-- Add a button to print the form -->
    <button onclick="printForm()">Print Form</button>

</body>

</html>
