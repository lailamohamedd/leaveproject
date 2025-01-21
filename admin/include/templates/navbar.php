 <!-- Developed by Laila Mohamed: Laila.arkanorg.com -->

<div class="page">
  <div class="sidebar">
    <div class="logo-area text-center">
      <img class="avatar" style="width:90px; border-radius:50%; margin-bottom:20px;" src="layout/img/avatar.png" alt="user avatar"/>
      <br>
      <?php  echo $sessionUser ; ?>
    </div>
    <ul class="links-area list-unstyled">
      <li class="parent"><a class="active" href="dashboard.php"><i class='fa fa-th'></i>&nbsp Dashboard</a></li>
      <li class="parent"><a class="active" href="changepassword.php"><i class='fa fa-key'></i>&nbsp Change Password</a></li>
      <li class="parent"><a class="active" href="department.php"><i class='fa fa-table'></i>&nbsp Department</a></li>
      <li class="parent"><a class="toggle-submenu" href="#"><i class='fa fa-users'></i>&nbsp Employees<i class="fa fa-angle-right"></i></a>
        <ul class="child-links list-unstyled">
          <li><a href="members.php?do=Add">Add Employee</a></li>
          <li><a href="members.php">Manage Employee</a></li>
        </ul>
      </li>
      <li class="parent"><a class="toggle-submenu" href="#"><i class='fa fa-laptop'></i>&nbsp Leave Management<i class="fa fa-angle-right"></i></a>
        <ul class="child-links list-unstyled">
          <li><a href="leave.php">Leave History</a></li>
        </ul>
      </li>
      <li class="parent"><a href="logout.php"><i class='fa fa-sign-out'></i>&nbsp Log Out</a></li>
    </ul>
  </div>
  <div class="content-area">
    <div class="header text-center">
    
      <i class="fa fa-reorder fa-lg toggle-sidebar"></i>
      <span>Employee Leave Management System</span>
    </div>

    
