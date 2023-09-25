<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if(isset($_POST['login'])) 
  {
    $empid=$_POST['empid'];
    $password=md5($_POST['password']);
    $sql ="SELECT ID,EmpId FROM tblemployee WHERE EmpId=:empid and Password=:password";
    $query=$dbh->prepare($sql);
    $query-> bindParam(':empid', $empid, PDO::PARAM_STR);
$query-> bindParam(':password', $password, PDO::PARAM_STR);
    $query-> execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
    if($query->rowCount() > 0)
{
foreach ($results as $result) {
$_SESSION['etmsempid']=$result->ID;
$_SESSION['empid']=$result->EmpId;

}

 
$_SESSION['login']=$_POST['empid'];
echo "<script type='text/javascript'> document.location ='dashboard.php'; </script>";
} else{
echo "<script>alert('Invalid Details');</script>";
}
}

?>
<!DOCTYPE html>
<html lang="en">
   <head>

      <title>MANPOWER ALLOCATION AND PLANNING SYSTEM || Login Page</title>
     
      <link rel="stylesheet" href="css/bootstrap.min.css" />
      <!-- site css -->
      <link rel="stylesheet" href="style.css" />
      <!-- responsive css -->
      <link rel="stylesheet" href="css/responsive.css" />
      <!-- color css -->
      <link rel="stylesheet" href="css/colors.css" />
      <!-- select bootstrap -->
      <link rel="stylesheet" href="css/bootstrap-select.css" />
      <!-- scrollbar css -->
      <link rel="stylesheet" href="css/perfect-scrollbar.css" />
      <!-- custom css -->
      <link rel="stylesheet" href="css/custom.css" />
      <!-- calendar file css -->
      <link rel="stylesheet" href="js/semantic.min.css" />
   

   </head>

   <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
      <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
        <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
        <span class="fs-4"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14" height="14" width="14"><g id="map-fold--navigation-map-maps-gps-travel-fold"><path id="Subtract" fill="#000" fill-rule="evenodd" d="m8.875 0.865 -3.75 -0.75 0 13.02 3.75 0.75 0 -13.02Zm1.25 12.994 3.496 -0.874A0.5 0.5 0 0 0 14 12.5V0.5a0.5 0.5 0 0 0 -0.621 -0.485l-3.254 0.813 0 13.031ZM0.379 1.015 3.875 0.14l0 13.03 -3.254 0.814A0.5 0.5 0 0 1 0 13.5v-12a0.5 0.5 0 0 1 0.379 -0.485Z" clip-rule="evenodd" stroke-width="1"></path></g></svg>
        <a id ="maps" href="../index.php"> MAPS</a></span>
      </a>

      <!-- <ul class="nav nav-pills">
        <li class="nav-item"><a href="/home" class="nav-link active" aria-current="page"></a></li>	
        <li class="nav-item"><a href="#" class="nav-link"></a></li>
      </ul> -->
	
    </header>
 
   <body class="inner_page login">


      <div class="full_container">
         <div class="container">
            <div class="center verticle_center full_height">
               <div class="login_section">
                  <div class="logo_login">
                     <div class="center">
                        <h3 style="color: white;">MANPOWER ALLOCATION AND PLANNING SYSTEM</h3>
                     </div>
                  </div>
                  <div class="login_form">
                     <form method="post" name="login">
                        <fieldset>
                           <div class="field">
                              <label class="label_field">Employee Id</label>
                              <input type="text" class="form-control" placeholder="enter your employee id" required="true" name="empid">
                           </div>
                           <div class="field">
                              <label class="label_field">Password</label>
                              <input type="password" class="form-control" placeholder="enter your password" name="password" required="true">
                           </div>
                          <a class="forgot" href="forgot-password.php">Forgotten Password?</a>
                           <div class="field margin_0">
                              <label class="label_field hidden">hidden label</label>
                              <button class="main_bt" name="login" type="submit">Login</button>
                           </div>
                        </fieldset>
                        <a class="forgot" href="../index.php">Home</a>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>


 
      <!-- jQuery -->
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      <!-- wow animation -->
      <script src="js/animate.js"></script>
      <!-- select country -->
      <script src="js/bootstrap-select.js"></script>
      <!-- nice scrollbar -->
      <script src="js/perfect-scrollbar.min.js"></script>
      <script>
         var ps = new PerfectScrollbar('#sidebar');
      </script>
      <!-- custom js -->
      <script src="js/custom.js"></script>
     
   </body>
   </div>
  <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
    <p class="col-md-4 mb-0 text-body-secondary">© 2023 NUFVDEV Maps</p>

    <a href="/" class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
      <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
    </a>

    <ul class="nav col-md-4 justify-content-end">
      <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary"> About</a></li>
      <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary"></a></li>
      <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary"></a></li>
      <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary"></a></li>
      <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary"></a></li>
    </ul>
  </footer>
</div>
   
</html>
