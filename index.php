<?php
session_start();
error_reporting(0);

include('includes/dbconnection.php');
?>
<!DOCTYPE html>
<html>

<head>


	<title>MAPS</title>
	<!--/tags -->
	
	<script type="application/x-javascript">
		addEventListener("load", function () {
			setTimeout(hideURLbar, 0);
		}, false);

		function hideURLbar() {
			window.scrollTo(0, 1);
		}
	</script>

	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
	<link rel="stylesheet"  type="text/css" href="./css/landingpage.css" >	

</head>
<body>


<div>
<section class = "gradient-background">
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
      <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
        <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
        <span class="fs-4"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 50 50" height="50" width="50"><g id="map-fold--navigation-map-maps-gps-travel-fold"><path id="Subtract" fill="#000" fill-rule="evenodd" d="m31.696428571428573 3.0892857142857144 -13.392857142857144 -2.678571428571429 0 46.5 13.392857142857144 2.678571428571429 0 -46.5Zm4.464285714285714 46.40714285714286 12.485714285714286 -3.1214285714285714A1.7857142857142858 1.7857142857142858 0 0 0 50 44.642857142857146V1.7857142857142858a1.7857142857142858 1.7857142857142858 0 0 0 -2.217857142857143 -1.7321428571428572l-11.621428571428572 2.9035714285714285 0 46.53928571428572ZM1.3535714285714286 3.625 13.839285714285715 0.5000000000000001l0 46.535714285714285 -11.621428571428572 2.907142857142857A1.7857142857142858 1.7857142857142858 0 0 1 0 48.214285714285715v-42.85714285714286a1.7857142857142858 1.7857142857142858 0 0 1 1.3535714285714286 -1.7321428571428572Z" clip-rule="evenodd" stroke-width="3.5714285714285716"></path></g></svg>
		MAPS</span>
      </a>

      <!-- <ul class="nav nav-pills">
        <li class="nav-item"><a href="/home" class="nav-link active" aria-current="page"></a></li>	
        <li class="nav-item"><a href="#" class="nav-link"></a></li>
      </ul> -->
	
    </header>



  <div class="container">
  <div class="card" style="border-radius: 10px; box-shadow: 0 4px 20px 1px rgb(0 0 0 / 6%), 0 1px 4px rgb(0 0 0 / 8%);">
    <div class="row g-0">
      <div class="col-md-6 col-lg-5 d-none d-md-block">
        <img src="https://images.unsplash.com/photo-1586076100131-32505c71d0d2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1887&q=80" alt="login form" class="img-fluid" style="border-radius: 10px 0 0 10px; background-repeat: no-repeat; background-attachment: fixed; background-size: cover;">
      </div>
      <div class="col-md-6 col-lg-7 d-flex align-items-center">
        <div class="card-body p-4 p-lg-5 text-black">
          <div class="container">
            <section class="white-background">
              <div class="container">
                <div class="px-4 py-5 my-5 text-center">
                  <h1 class="text-body-emphasis">Manpower Allocation and Planning System</h1>
                  <p class="col-lg-8 mx-auto fs-5 text-muted">Traves Maintenance and Services Incorporated</p>
                  <h4 class="display-10 fw-bold text-body-emphasis">Sign in as:</h4>
                  <div class="col-lg-6 mx-auto">
                    <p class="lead mb-4"></p>
                    <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                      <button type="button" class="btn btn-light btn-lg px-4 me-md-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" height="24" width="24">
                          <g id="user-single-neutral-male--close-geometric-human-person-single-up-user-male">
                            <path id="Union" fill="#000" fill-rule="evenodd" d="M18 1.5H6v5a6 6 0 1 0 12 0v-5Zm-6 13c-3.608 0-7.007 0.911-9.976 2.516L1.5 17.3v5.2h21v-5.2l-0.524 -0.284A20.911 20.911 0 0 0 12 14.5Z" clip-rule="evenodd" stroke-width="1"></path>
                          </g>
                        </svg>
                        <a href="admin/login.php" class="effect-3">Supervisor</a>
                      </button>
                      <button type="button" class="btn btn-light btn-lg px-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" height="24" width="24">
                          <g id="user-single-neutral-male--close-geometric-human-person-single-up-user-male">
                            <path id="Union" fill="#000" fill-rule="evenodd" d="M18 1.5H6v5a6 6 0 1 0 12 0v-5Zm-6 13c-3.608 0-7.007 0.911-9.976 2.516L1.5 17.3v5.2h21v-5.2l-0.524 -0.284A20.911 20.911 0 0 0 12 14.5Z" clip-rule="evenodd" stroke-width="1"></path>
                          </g>
                        </svg>
                        <a href="employee/login.php" class="effect-3">Technician</a>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </section>
          </div>
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
</div>

</section>
</div>




  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>
