<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if(isset($_POST['login'])) 
  {
    $username=$_POST['username'];
    $password=md5($_POST['password']);
    $sql ="SELECT ID FROM tbladmin WHERE UserName=:username and Password=:password";
    $query=$dbh->prepare($sql);
    $query-> bindParam(':username', $username, PDO::PARAM_STR);
$query-> bindParam(':password', $password, PDO::PARAM_STR);
    $query-> execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
    if($query->rowCount() > 0)
{
foreach ($results as $result) {
$_SESSION['etmsaid']=$result->ID;
}

  if(!empty($_POST["remember"])) {
//COOKIES for username
setcookie ("user_login",$_POST["username"],time()+ (10 * 365 * 24 * 60 * 60));
//COOKIES for password
setcookie ("userpassword",$_POST["password"],time()+ (10 * 365 * 24 * 60 * 60));
} else {
if(isset($_COOKIE["user_login"])) {
setcookie ("user_login","");
if(isset($_COOKIE["userpassword"])) {
setcookie ("userpassword","");
        }
      }
}
$_SESSION['login']=$_POST['username'];
echo "<script type='text/javascript'> document.location ='dashboard.php'; </script>";
} else{
echo "<script>alert('Invalid Details');</script>";
}
}

?>
<!DOCTYPE html>
<html lang="en">
   <head>
    
      <title>MANPOWER ALLOCATION AND PLANNING SYSTEM|| Login Page</title>
     
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
        <span class="fs-4">   <a id ="maps" href="../index.php"> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 50 50" height="50" width="50"><g id="map-fold--navigation-map-maps-gps-travel-fold"><path id="Subtract" fill="#000" fill-rule="evenodd" d="m31.696428571428573 3.0892857142857144 -13.392857142857144 -2.678571428571429 0 46.5 13.392857142857144 2.678571428571429 0 -46.5Zm4.464285714285714 46.40714285714286 12.485714285714286 -3.1214285714285714A1.7857142857142858 1.7857142857142858 0 0 0 50 44.642857142857146V1.7857142857142858a1.7857142857142858 1.7857142857142858 0 0 0 -2.217857142857143 -1.7321428571428572l-11.621428571428572 2.9035714285714285 0 46.53928571428572ZM1.3535714285714286 3.625 13.839285714285715 0.5000000000000001l0 46.535714285714285 -11.621428571428572 2.907142857142857A1.7857142857142858 1.7857142857142858 0 0 1 0 48.214285714285715v-42.85714285714286a1.7857142857142858 1.7857142857142858 0 0 1 1.3535714285714286 -1.7321428571428572Z" clip-rule="evenodd" stroke-width="3.5714285714285716"></path></g></svg>
       </a></span>
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
                        <h3 style="color: white;">Sign in to Maps</h3>
                     </div>
                  </div>
                  <div class="login_form">
                     <form method="post" name="login">
                        <fieldset>
                           <div class="field">
                              <label class="label_field">User Name</label>
                              <input type="text" class="form-control" placeholder="enter your username" required="true" name="username" value="<?php if(isset($_COOKIE["user_login"])) { echo $_COOKIE["user_login"]; } ?>" >
                           </div>
                           <div class="field">
                              <label class="label_field">Password</label>
                              <input type="password" class="form-control" placeholder="enter your password" name="password" required="true" value="<?php if(isset($_COOKIE["userpassword"])) { echo $_COOKIE["userpassword"]; } ?>">
                           </div>
                           <div class="field">
                              <label class="label_field hidden">hidden label</label>
                              <label class="form-check-label"><input class="form-check-input" id="remember" name="remember" <?php if(isset($_COOKIE["user_login"])) { ?> checked <?php } ?> type="checkbox"/> Remember Me</label>
                              <a class="forgot" href="forgot-password.php">Forgot Password?</a>
                           </div>
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
</html>