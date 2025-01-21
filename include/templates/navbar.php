    <div class="page">
      <div class="sidebar">
        <div class="logo-area text-center">
          <img class="avatar" style="width:90px; border-radius:50%; margin-bottom:20px;" src="layout/img/avatar.jpg" alt="user avatar"/>
         <br>
          <?php  echo $sessionUser ; ?>
        </div>
        <ul class="links-area list-unstyled">
        <?php $infoo = $_SESSION['uid']; 
        echo "</i><li><a class='active' href='updateuser.php?userid=$infoo'><i class='fa fa-user'></i>&nbsp My Profile</a></li>";
        // echo "</i><li><a class='active' href='changepassword.php?userid=$infoo'><i class='fa fa-key'></i>&nbsp Change Password</a></li>";
?>
		      <li><a class="toggle-submenu" href="#"><i class='fa fa-th'></i>&nbsp Leave Management<i class="fa fa-angle-right"></i></a>
            <ul class="child-links list-unstyled">
              <li><a href="leave.php">Leave History</a></li>
              <li><a href="leave.php?do=Add">Apply Leave</a></li>
            </ul>
          </li>
		      <li><a href="logout.php"><i class='fa fa-sign-out'></i>&nbsp Log Out</a></li>
        </ul>
      </div>
      <div class="content-area">
        <div class="header text-center">
        
          <i class="fa fa-reorder fa-lg toggle-sidebar"></i>
          <span>Employee Leave Management System</span>
        </div>

    
