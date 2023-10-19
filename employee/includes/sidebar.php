<nav id="sidebar">
   <div class="sidebar_blog_1">
      <div class="sidebar-header">
         <div class="logo_section">
            <a href="dashboard.php"><img class="logo_icon img-responsive" src="images/logo/maps_icon.png" alt="#" /></a>
         </div>
      </div>
      <div class="sidebar_user_info">
         <div class="icon_setting"></div>
         <div class="user_profle_side">
            <div class="user_img"><img class="img-responsive" src="images/layout_img/user_img.jpg" alt="#" /></div>
            <div class="user_info">
               <?php
               $eid=$_SESSION['etmsempid'];
               $sql="SELECT EmpName,EmpEmail from  tblemployee where ID=:eid";
               $query = $dbh -> prepare($sql);
               $query->bindParam(':eid',$eid,PDO::PARAM_STR);
               $query->execute();
               $results=$query->fetchAll(PDO::FETCH_OBJ);
               $cnt=1;
               if($query->rowCount() > 0)
               {
                  foreach($results as $row)
                  { 
               ?>
               <h6><?php  echo $row->EmpName;?></h6>
               <p><span class="online_animation"></span> <?php  echo $row->EmpEmail;?></p>
               <?php $cnt=$cnt+1;}} ?>
            </div>
         </div>
      </div>
   </div>
   <div class="sidebar_blog_2">
      <h4>General</h4>
      <ul class="list-unstyled components">
         <li><a href="dashboard.php"><i class="fa fa-dashboard yellow_color"></i> <span>Dashboard</span></a></li>
         <li class="active">
            <a href="#dashboard2" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-files-o orange_color"></i> <span>View Service</span></a>
            <ul class="collapse list-unstyled" id="dashboard2">
               <li>
                  <a href="new-task.php">> <span>New Service</span></a>
               </li>
               <li>
                  <a href="inprogress-task.php">> <span>Inprogress Service</span></a>
               </li>
               <li>
                  <a href="completed-task.php">> <span>Completed Service</span></a>
               </li>
               <li>
                  <a href="all-task.php">> <span>All Services</span></a>
               </li>
            </ul>
         </li>
         <!-- Add the Service Report link here  --> 
         <li><a href="service-report.php"><i class="fa fa-file-text green_color"></i> <span>Submit Service Report</span></a></li>
         <li><a href="employee-leave.php"><i class="fa fa-dashboard yellow_color"></i> <span>File a Leave</span></a></li>
    </ul>
   </div>
</nav>
