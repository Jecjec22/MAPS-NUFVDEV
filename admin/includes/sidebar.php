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
                        <div class="user_img"><img class="img-responsive" src="images/layout_img/super.png" alt="#" /></div>
                        <div class="user_info">
                           <?php
$aid=$_SESSION['etmsaid'];
$sql="SELECT AdminName,Email from  tbladmin where ID=:aid";
$query = $dbh -> prepare($sql);
$query->bindParam(':aid',$aid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?>
                           <h6><?php  echo $row->AdminName;?></h6>
                           <p><span class="online_animation"></span> <?php  echo $row->Email;?></p><?php $cnt=$cnt+1;}} ?>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="sidebar_blog_2">
                  <h4>General</h4>
                  <ul class="list-unstyled components">
                    
                     <li><a href="dashboard.php"><i class="fa fa-dashboard yellow_color"></i> <span>Dashboard</span></a></li>
                     
                     <li>
                        <a href="#element" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-users purple_color"></i> <span>Manage Employee</span></a>
                        <ul class="collapse list-unstyled" id="element">
                          
                        <li><a href="view-employee.php">> <span>View Employees</span></a></li>
                           
                           </ul>
                        </li>
                        <li>
                           <a href="#apps" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-object-group blue2_color"></i> <span>Manpower Allocation</span></a>
                           <ul class="collapse list-unstyled" id="apps">
                           
                              <li><a href="manage-task.php">> <span>Allocate Technician</span></a></li>
                        
                             
                          
                           </ul>
                     </li>
                     <li>
                       <a href="#apps1" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-briefcase blue1_color"></i> <span>Manage Services</span></a>
                        <ul class="collapse list-unstyled" id="apps1">
                           <li><a href="inprogress-task.php">> <span>In progress Service</span></a></li>
                           <li><a href="completed-task.php">> <span>Completed Service</span></a></li>
                          
                        </ul>
                     </li>
                    
                    
                 <!--    <li class="active">
                        <a href="#additional_page" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-clone yellow_color"></i> <span> Pages</span></a>
                        <ul class="collapse list-unstyled" id="additional_page">
                           <li>
                              <a href="aboutus.php">> <span>About Us</span></a>
                           </li>
                           <li>
                              <a href="contactus.php">> <span>Contact Us</span></a>
                           </li>
                           
                        </ul>
                     </li>
                     <li><a href="search-employee.php"><i class="fa fa-map purple_color2"></i> <span>Search Employee</span></a></li> 
--> <li><a href="leave-request.php"><i class="fa fa-files-o orange_color"></i> <span>Manage Leave Request </span></a></li>
<li><a href="manage-ticket.php"><i class="fa fa-files-o orange_color"></i> <span>Manage  Tickets</span></a></li>   
<li><a href="emp-attendance2.php"><i class="fa fa-files-o orange_color"></i> <span>Attendance </span></a></li>
                  </ul>
               </div>
            </nav>

       