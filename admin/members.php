<?php
/*
=============================================
== Manage Employee Page
== You Can Add | Edit | Delete Employees From Here
*/

ob_start();  // Output Buffering Start
session_start();
$pageTitle='Employees Page';
include 'init.php';

    if (isset($_SESSION['Username'])){
        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

        // Start Manage Page

        if ($do == 'Manage'){ // Manage Members Page

            $query = '';
            if(isset($_GET['page']) && $_GET['page'] == 'Pending'){
                $query = 'AND RegStatus = 0';
            }

            // Select All Users Except Admin
            $stmt = $con->prepare("SELECT user.*, depart.departName FROM user INNER JOIN depart ON depart.departID = user.departID  WHERE 
            GroupID != 1 $query ORDER BY UserID DESC");

            //Excute The Statment 

            $stmt->execute();
                        //Assign To Variable
			
            $rows = $stmt->fetchAll();
            if(! empty($rows)){
			
			 if(isset($_POST['records-limit'])){
				  $_SESSION['records-limit'] = $_POST['records-limit'];
			  }
			  
			  $limit = isset($_SESSION['records-limit']) ? $_SESSION['records-limit'] : 5;
			  $page = (isset($_GET['page']) && is_numeric($_GET['page']) ) ? $_GET['page'] : 1;
			  $paginationStart = ($page - 1) * $limit;
			  $rows = $con->query("SELECT user.*, depart.departName FROM user INNER JOIN depart ON depart.departID = user.departID  WHERE 
              GroupID != 1 $query ORDER BY UserID DESC LIMIT $paginationStart, $limit")->fetchAll();

			  // Get total records
			  $sql = $con->query("SELECT count(UserID) AS UserID FROM user")->fetchAll();
			  $allRecrods = $sql[0]['UserID'];
			  
			  // Calculate total pages
			  $totoalPages = ceil($allRecrods / $limit);

			  // Prev + Next
			  $prev = $page - 1;
			  $next = $page + 1;
		
				
            ?>
            
	<div class="container">
		
		
		<div class="newtable">
		<h1 class="text-left"><b>Employees Details</b></h1>

			<div class="table-responsive">
				<div class="table-wrapper">	
					<form name='frmSearch' action='' method='post'>				
						<div class="table-title">
							<div class="row">
								<div class="col-xs-4">
									<div class="show-entries">
										<div class="d-flex flex-row-reverse bd-highlight mb-3">
											<form action="members.php" method="post">
												<select name="records-limit" id="records-limit" class="custom-select">
													<option disabled selected>Records Limit</option>
													<?php foreach([5,7,10,12] as $limit) : ?>
													<option
														<?php if(isset($_SESSION['records-limit']) && $_SESSION['records-limit'] == $limit) echo 'selected'; ?>
														value="<?= $limit; ?>">
														<?= $limit; ?>
													</option>
													<?php endforeach; ?>
												</select>
											</form>
										</div>
									</div>						
								</div>
								<div class="col-xs-4">
								</div>
								<div class="col-xs-4">
									
								</div>
							</div>
						</div>
						<table class="table table-hover manage-members text-center" id="myTable">
							<thead>
								<tr>
									<th>#ID</th>
                                    <th>Emp id</th>
                                    <th>Emp Name</th>
									<th>Department</th>
									<th>Status</th>
									<th>Registerd Date</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
							<?php
								foreach($rows as $row){
									echo "<tr>";
										echo "<td>" . $row['UserID'] . "</td>";
										echo "<td>" . $row['Username'] . "</td>";
										echo "<td>" . $row['Fullname'] . "</td>";
                                        echo "<td>" . $row['departName'] . "</td>";
                                        echo "<td>";
                                            if($row['RegStatus'] == 1){
                                                echo "<div><a href='members.php?do=NotActivate&userid=" . $row['UserID'] . "' class='nactive NotActivate'>Active</a></div>";
                                            }
                                            if($row['RegStatus'] == 0){
                                                echo "<div><a href='members.php?do=Activate&userid=" . $row['UserID'] . "' class='activi activate'>Not Active</a></div>";
                                            }
                                        echo"</td>";
										echo "<td>" . $row['Regdate'] . "</td>";
										echo "<td>
											<a href='members.php?do=Edit&userid=" . $row['UserID'] . "' class='edit' title='Edit' data-toggle='tooltip'><i class='fa fa-pencil'></i> </a> &nbsp
											<a href='members.php?do=Delete&userid=" . $row['UserID'] . "' class='delete confirm' title='Delete' data-toggle='tooltip'> <i class='fa fa-close'></i>  </a>";
										
									echo "</td>";
								echo "</tr>";
								}
							?>
							</tbody>
						</table>
						 <!-- Pagination -->
						<nav aria-label="Page navigation example mt-5">
							<ul class="pagination justify-content-center">
								<li class="page-item <?php if($page <= 1){ echo 'disabled'; } ?>">
									<a class="page-link"
										href="<?php if($page <= 1){ echo '#'; } else { echo "?page=" . $prev; } ?>">Previous</a>
								</li>

								<?php for($i = 1; $i <= $totoalPages; $i++ ): ?>
								<li class="page-item <?php if($page == $i) {echo 'active'; } ?>">
									<a class="page-link" href="members.php?page=<?= $i; ?>"> <?= $i; ?> </a>
								</li>
								<?php endfor; ?>

								<li class="page-item <?php if($page >= $totoalPages) { echo 'disabled'; } ?>">
									<a class="page-link"
										href="<?php if($page >= $totoalPages){ echo '#'; } else {echo "?page=". $next; } ?>">Next</a>
								</li>
							</ul>
						</nav>
						
					</div>
				</form>
			</div>        
		</div>
			
			
            
            </div>
            <?php }else{
                echo '<div class="container">';
                echo '<div class="msg nice-message">There\'s No Employees To Show</div><br>';
                    echo '<a href="members.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Employee</a>';
                echo '</div>';
            } ?>
        <?php } elseif($do == 'Add'){ //Add Members Pages ?>

            
                
                <div class="container-fluid updated" style="margin: 50px auto">
                <h1 class="text-left"><b style="margin-left:20px">Add Employee</b></h1> 
				<div class="addcat update" style="width: 1100px;">
                    <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
                        <!-- Start User Name Field -->
                            <div class="group col-md-6">
                                <input type="text" pattern="[A-Za-z-ا-ى].{2,}" title="Name should be in characters only and greater than 2 characters" name="username" class="form-control" autocomplete="off" required="required">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>User Name</label>
                            </div>
                              <!-- End User Name Field -->
                            <!-- Start  Gender Field -->
                            <div class="grou col-md-3">
                                <select class="form-control" name="gender" style="margin-bottom: 10px">
                                    <option value="0">Gender..</option>
                                    <?php 
                                    $allGenders = getAllFrom("*", "gender", "", "", "genderid");

                                    foreach($allGenders as $gender){
                                        echo "<option value='" . $gender['genderid'] . "'>" . $gender['genderName'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <!-- End Gender Field -->
                            <!-- Start  Birthdate Field -->
                            <div class="group col-md-3">
                                <input type="date" name="birth" class="form-control" required="required">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Birthdate</label>
                            </div>
                            <!-- End Birthdate Field -->
                            <!-- Start Full Name Field -->
                            <div class="group col-md-6">
                                <input type="text" pattern="[A-Za-z-ا-ى].{4,}" title="Full Name should be in characters only and greater than 4 characters"  name="full" class="form-control" required="required">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Full Name</label>
                            </div>
                            <!-- End Full Name Field -->
                            <!-- Start Department Field -->
                            <div class="grou col-md-3">
                                <select class="form-control" name="depart" style="margin-bottom: 10px">
                                    <option value="0">Department..</option>
                                    <?php 
                                    $allDeparts = getAllFrom("*", "depart", "", "", "departID");

                                    foreach($allDeparts as $depart){
                                        echo "<option value='" . $depart['departID'] . "'>" . $depart['departName'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <!-- End Department Field -->
                            <!-- Start  Country Field -->
                            <div class="group col-md-3">
                                <input type="text" pattern="[A-Za-z-ا-ى].{4,}" title="Country should be in characters only and greater than 4 characters"  name="Country" class="form-control" required="required">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label> Country</label>
                            </div>
                            <!-- End Country Field -->
                            <!-- Start Email Field -->
                            <div class="group col-md-6">
                                <input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" name="email" class="form-control" required="required" autocomplete="off">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label> Email</label>
                            </div>
                            <!-- End Email Field -->
                            <!-- Start  City Field -->
                            <div class="group col-md-3">
                                <input type="text" pattern="[A-Za-z-ا-ى].{4,}" title="City should be in characters only and greater than 4 characters"  name="City" class="form-control" required="required">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label> City/Town</label>
                            </div>
                            <!-- End City Field -->
                            <!-- Start  Address Field -->
                            <div class="group col-md-3">
                                <input type="text" pattern="[A-Za-z-ا-ى].{4,}" title="Address should be in characters only and greater than 4 characters"  name="address" class="form-control" required="required">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label> Address</label>
                            </div>
                            <!-- End Address Field -->
                            <!-- Start Password Field -->
                            <div class="group col-md-6">               
                                <input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" autocomplete="off" name="password" class="password form-control" autocomplete="new-password" required />
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label> Password</label>
                            </div>
                            <!-- End Password Field -->
                            <!-- Start Phone Field -->
                            <div class="group col-md-6"> 
                                <input type="number" name="phone" class="form-control" required="required" >
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label> Mobile Number</label>
                            </div>
                            <!-- End Phone Field -->
                            <!-- Start button Field -->
                            <div class="form-group form-group-lg">
                                <div class="col-sm-offset-3 col-sm-10">
                                    <input type="submit" value="Add" class="btn btn-primary btn-lg">
                                </div>
                            </div>
                            <!-- End button Field -->
                        </form>
                    </div>
				</div>
             <?php 

              }elseif ($do == 'Insert') {

            // Insert Member Page
            
            if($_SERVER['REQUEST_METHOD']== 'POST'){
                echo "<h1 class='text-center'>Insert <b> Employee</b></h1>";
                echo "<div class='container'>";

                // Get Variables From The Form
                $user   = $_POST['username'];
                $pass    = $_POST['password'];
                $email  = $_POST['email'];                
                $name   = $_POST['full'];                
                $depart   = $_POST['depart'];
                $phone   = $_POST['phone']; 
                $gender   = $_POST['gender'];                
                $city   = $_POST['City'];
                $birth   = $_POST['birth'];
                $country   = $_POST['Country'];
                $address   = $_POST['address'];

                $hashPass = sha1($_POST['password']);

                // Validate The Form

                $formError = array();

                if(strlen($user) < 3) {
                    $formError[] = '<div class="msg danger-message">Username Can\'t Be Less Than <strong>3 Characters</strong></div>';
                }
                if(strlen($user) > 20) {
                    $formError[] = '<div class="msg danger-message">Username Can\'t Be More Than <strong>20 Characters</strong></div>';
                }
                if(empty($user)){
                    $formError[] = '<div class="msg danger-message">Username Can\'t Be <strong>Empty</strong></div>';
                }
                if(empty($pass)){
                    $formError[] = '<div class="msg danger-message">Password Can\'t Be <strong>Empty</strong></div>';
                }
                if(empty($email)){
                    $formError[] = '<div class="msg danger-message">Email Can\'t Be <strong>Empty</strong></div>';
                }
				if(strlen($name) < 5) {
                    $formError[] = '<div class="msg danger-message">Full Name Can\'t Be Less Than <strong>5 Characters</strong></div>';
                }
				
                if(empty($name)){
                    $formError[] = '<div class="msg danger-message">Name Can\'t Be <strong>Empty</strong></div>';
                }
                if(strlen($country) < 3) {
                    $formError[] = '<div class="msg danger-message">country Can\'t Be Less Than <strong>3 Characters</strong></div>';
                }
                if(empty($country)) {
                    $formError[] = '<div class="msg danger-message">country Can\'t Be <strong>Empty</strong></div>';
                }
                if(strlen($city) < 3) {
                    $formError[] = '<div class="msg danger-message">city Can\'t Be Less Than <strong>3 Characters</strong></div>';
                }
                if(empty($city)) {
                    $formError[] = '<div class="msg danger-message">city Can\'t Be <strong>Empty</strong></div>';
                }
                if(empty($address)) {
                    $formError[] = '<div class="msg danger-message">address Can\'t Be <strong>Empty</strong></div>';
                }

                //Loop Into Error Array And Echo It

                foreach($formError as $error){
                    echo '<div class="msg danger-message">' . $error . '</div>';
                }

                // Check If No Error Proced The Update Operation

                if(empty($formError)){

                    // Check If User Exit In Database

                    $check = checkItem("Username", "user", $user);
                    if($check == 1){
                        $theMsg = '<div class="msg danger-message">Sorry This User ' . '<strong> "' . $user . '" </strong>' . ' Is Exist</div>';
                        redirectHome($theMsg, 'back');
                    }else{

                     // Insert User Info In Database
                    $stmt = $con->prepare("INSERT INTO
                                                      user(Username, Pasword, Email, FullName, departID, Phone, genderid, city, Birth, Country, address, Regdate, RegStatus) 
                                           VALUES
                                                      (:zuser, :zpass, :zmail, :zname, :zdepartID, :zPhone, :zgenderID, :zcity, :zBirth, :zcountry, :zaddress, now(), 1) ");
                    $stmt->execute(array(
                        'zuser' => $user,
                        'zpass' => $hashPass,
                        'zmail' => $email,
                        'zname' => $name,
						'zdepartID' => $depart,
                        'zPhone' => $phone,
                        'zgenderID' => $gender,
                        'zcity' => $city,
						'zBirth' => $birth,
                        'zcountry' => $country,
                        'zaddress' => $address
                    ));
                    
                    // Echo Success Message

                    echo "<div class='container'>";
                    $theMsg = "<div class='msg nice-message'>" . $stmt->rowCount() . ' ' . 'Recorde Inserted</div>';
                    redirectHome($theMsg,'back');
                    echo "</div>";
                }
            }
               
                }else{

                $theMsg = "<div class='msg danger-message'>Sorry You Can\'t Browse this Page Directly</div>";
                redirectHome($theMsg);
            }
            echo "</div>";
            
            
         }elseif ($do == 'Edit') { // Edit Page

            // check If Get Reques userid Is Numeric & Get The Integer Value Of It
            
            $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
            
            // Select All Data Depend On This ID

            $stmt = $con->prepare("SELECT * FROM user WHERE UserID = ? LIMIT 1");
            
            // Execute Query
            
            $stmt->execute(array($userid));

            // Fetch The Data

            $row = $stmt->fetch();

            // The Row Count

            $count = $stmt->rowCount();

        // If There's No Such ID

        if ($count > 0){  ?>

            <div class="container-fluid " style="margin: 50px auto">
            <h1 class="text-left emp"><b style="margin-left:10px">Update Employee</b></h1> 
			<div class="addcat update empd" style="width: 1100px;">
            <h1 class="text-left"><span style="margin-left:20px">Update Employee Details</span></h1>
                <form class="form-horizontal" action="?do=Update" method="POST">
                <input type="hidden" name="userid" value="<?php echo $userid ?>">
                <!-- Start User Name Field -->
                    <div class="group col-md-6">
                        <input type="text" pattern="[A-Za-z-ا-ى].{2,}" title="Name should be in characters only and greater than 2 characters" name="username" class="form-control" value="<?php echo $row['Username'] ?>" autocomplete="off" required="required" >
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>User Name</label>
                    </div>
                    <!-- End User Name Field -->
                    <!-- Start  Gender Field -->
                    <div class="grou col-md-3">
                        <select class="form-control" name="gender" style="margin-bottom: 10px">
                             <option value="0">...</option>
                                <?php 
                                $allgenders = getAllFrom("*", "gender", "", "", "genderid");
                                foreach($allgenders as $gender){
                                    echo "<option value='" . $gender['genderid'] . "'";
                                    if($row['genderid'] == $gender['genderid']){ echo 'selected';}
                                    echo ">" . $gender['genderName'] . "</option>";
                                }
                                ?>
                        </select>
                    </div>
                    <!-- End Gender Field -->
                    <!-- Start  Birthdate Field -->
                    <div class="group col-md-3">
                        <input type="date" name="birth" value="<?php echo $row['Birth'] ?>" class="form-control" required="required" placeholder="Birthdate Appear In Profile Page">
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>Birthdate</label>
                    </div>
                    <!-- End Birthdate Field -->
                    <!-- Start Full Name Field -->
                    <div class="group col-md-6">
                        <input type="text" value="<?php echo $row['Fullname'] ?>" pattern="[A-Za-z-ا-ى].{4,}" title="Full Name should be in characters only and greater than 4 characters"  name="full" class="form-control" required="required" placeholder="Full Name Appear In Profile Page">
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>Full Name</label>
                    </div>
                    <!-- End Full Name Field -->
                    <!-- Start Department Field -->
                    <div class="grou col-md-3">
                        <select class="form-control" name="depart" style="margin-bottom: 10px">
                            <option value="0">...</option>
                            <?php 
                            $allDeparts = getAllFrom("*", "depart", "", "", "departID");
                            foreach($allDeparts as $depart){
                                echo "<option value='" . $depart['departID'] . "'";
                                    if($depart['departID'] == $depart['departID']){ echo 'selected';}
                                    echo ">" . $depart['departName'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <!-- End Department Field -->
                    <!-- Start  Country Field -->
                    <div class="group col-md-3">
                    <input type="text" value="<?php echo $row['Country'] ?>" pattern="[A-Za-z-ا-ى].{4,}" title="Country should be in characters only and greater than 4 characters"  name="Country" class="form-control" required="required" placeholder="Country Appear In Profile Page">
                    <span class="highlight"></span>
                        <span class="bar"></span>
                        <label> Country</label>
                    </div>
                    <!-- End Country Field -->
                    <!-- Start Email Field -->
                    <div class="group col-md-6">
                        <input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" name="email" class="form-control" value="<?php echo $row['Email'] ?>" required="required">
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label> Email</label>
                    </div>
                    <!-- End Email Field -->
                    <!-- Start  City Field -->
                    <div class="group col-md-3">
                    <input type="text" value="<?php echo $row['city'] ?>" pattern="[A-Za-z-ا-ى].{4,}" title="City should be in characters only and greater than 4 characters"  name="City" class="form-control" required="required" placeholder="City Appear In Profile Page">
                    <span class="highlight"></span>
                        <span class="bar"></span>
                        <label> City/Town</label>
                    </div>
                    <!-- End City Field -->
                    <!-- Start  Address Field -->
                    <div class="group col-md-3">
                    <input type="text" value="<?php echo $row['address'] ?>" pattern="[A-Za-z-ا-ى].{4,}" title="Address should be in characters only and greater than 4 characters"  name="address" class="form-control" required="required" placeholder="Address Appear In Profile Page">
                    <span class="highlight"></span>
                        <span class="bar"></span>
                        <label> Address</label>
                    </div>
                    <!-- End Address Field -->
                    
                    <!-- Start Phone Field -->
                    <div class="group col-md-6"> 
                    <input type="number" value="<?php echo $row['Phone'] ?>" name="phone" class="form-control" required="required" placeholder="Phone Appear In Profile Page">
                    <span class="highlight"></span>
                        <span class="bar"></span>
                        <label> Mobile Number</label>
                    </div>
                    <!-- End Phone Field -->
                     <!-- Start Password Field -->
                     <div class="group col-md-6">
                        <input type="hidden" name="oldpassword" Value="<?php echo $row['Pasword'] ?>">
                        <input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"  autocomplete="off" name="newpassword" class="form-control password" autocomplete="new-password" placeholder="Leave lank If You Dont Need To Change">
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>Enter New Password</label>
                    </div>
                    <!-- End Password Field -->
                    <!-- Start button Field -->
                    <div class="form-group form-group-lg">
                        <div class="col-md-3">
                            <input type="submit" style="margin-top:18px" value="UPDATE" class="btn btn-primary btn-lg">
                        </div>
                    </div>
                    <!-- End button Field -->
                </form>
            </div>
		</div>

            <?php }else{
               
               // If There's No Such ID Show Error Message

                echo "<div class='container'>";
                $theMsg = '<div class="msg danger-message">there no such ID</div>';
                redirectHome($theMsg);
                echo "</div>";
            }

            }elseif($do == 'Update') {   // Update Page
              
                if($_SERVER['REQUEST_METHOD']== 'POST'){
                    echo "<h1 class='text-center'>Update <b>User</b></h1>";
                    echo "<div class='container'>";
		
                    // Get Variables From The Form
					 
                    $id     = $_POST['userid'];
                    $user   = $_POST['username'];
                    $email  = $_POST['email'];					
                    $name   = $_POST['full'];
					$depart   = $_POST['depart'];
                    $phone   = $_POST['phone']; 
                    $gender   = $_POST['gender'];                
                    $city   = $_POST['City'];
                    $birth   = $_POST['birth'];
                    $country   = $_POST['Country'];
                    $address   = $_POST['address'];

                    // Password Trick
                    $pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);
 
                    // Validate The Form

                    $formError = array();

                    if(strlen($user) < 4) {
                        $formError[] = '<div class="msg danger-message">Username Can\'t Be Less Than <strong>4 Characters</strong></div>';
                    }
                    if(strlen($user) > 20) {
                        $formError[] = '<div class="msg danger-message">Username Can\'t Be More Than <strong>20 Characters</strong></div>';
                    }
                    if(empty($user)){
                        $formError[] = '<div class="msg danger-message">Username Can\'t Be <strong>Empty</strong></div>';
                    }
                    if(empty($gender)){
                        $formError[] = '<div class="msg danger-message">Gender Can\'t Be <strong>Empty</strong></div>';
                    }
                    if(empty($email)){
                        $formError[] = '<div class="msg danger-message">Email Can\'t Be <strong>Empty</strong></div>';
                    }
                    if(empty($name)){
                        $formError[] = '<div class="msg danger-message">FullName Can\'t Be <strong>Empty</strong></div>';
                    }
					 if(empty($depart)){
                        $formError[] = '<div class="msg danger-message">department Can\'t Be <strong>Empty</strong></div>';
                    }
                    if(empty($country)){
                        $formError[] = '<div class="msg danger-message">Ncountryame Can\'t Be <strong>Empty</strong></div>';
                    }
                    if(empty($city)){
                        $formError[] = '<div class="msg danger-message">city Can\'t Be <strong>Empty</strong></div>';
                    }
                    if(empty($address)){
                        $formError[] = '<div class="msg danger-message">address Can\'t Be <strong>Empty</strong></div>';
                    }
                    //Loop Into Error Array And Echo It

                    foreach($formError as $error){
                        echo $error;
                    }

                    // Check If No Error Proced The Update Operation

                    if(empty($formError)){

						// Check If User Exit In Database

                        $stmt2 = $con->prepare("SELECT * From user WHERE Username = ? AND UserID != ?");
                        $stmt2->execute(array($user, $id));
                        $count = $stmt2->rowCount();
                        if($count == 1){
                            $theMsg ='<div class="msg danger-message">sorry This User Is Exist</div>';
                            redirectHome($theMsg, 'back');
                        }else{
                                // Update The Database With This Info

                                $stmt = $con->prepare("UPDATE
                                                            user 
                                                    SET 
                                                            Username=?, Pasword=?, Email=?, Fullname=?, departID=?, Phone=?, genderid=?, city=?, Birth=?, Country=?, address=?
                                                    WHERE 
                                                            UserID=?");
                                $stmt->execute(array($user, $pass, $email, $name, $depart, $phone, $gender, $city, $birth, $country, $address, $id));
                                // Echo Success Message
                                $theMsg = "<div class='msg nice-message'>" . $stmt->rowCount() . ' ' . 'Recorde Updated</div>';
                                redirectHome($theMsg, 'back');
                            }
                        }
                   
                    }else{
                    $theMsg = "<div class='msg danger-message'>Sorry You Can't Browse this Page Directly</div>";
                    redirectHome($theMsg);
                }
                echo "</div>";
            } elseif($do == 'Delete'){ // Delete Member Page 
                
                echo "<h1 class='text-center'>Delete <b>Employee</b></h1>";
                echo "<div class='container'>";
              
                // check If Get Reques userid Is Numeric & Get The Integer Value Of It
            
                $useridd = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
                
                // Select All Data Depend On This ID
                
                $check = checkItem('userid', 'user', $useridd);


            // If There's  Such ID Show The Form

            if ($check > 0){ 
                $stmt = $con->prepare("DELETE  FROM user WHERE UserID = :userid");
                $stmt->bindParam(":userid", $useridd);
                $stmt->execute();
                $theMsg = "<div class='msg nice-message'>" . $stmt->rowCount() . ' ' . 'Recorde Deleted</div>';
                redirectHome($theMsg);
            }else{
                $theMsg = '<div class="msg danger-message">This Id IS NOT Exist</div>';
                redirectHome($theMsg);
            }
            echo '</div>';
            }elseif($do == 'Activate'){ // Activate Member Page 
                    
                echo "<h1 class='text-center'>Activate Member</h1>";
                echo "<div class='container'>";
            
                // check If Get Reques userid Is Numeric & Get The Integer Value Of It
            
                $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
                
                // Select All Data Depend On This ID
                
                $check = checkItem('userid', 'user', $userid);


            // If There's  Such ID Show The Form
            
            if ($check > 0){ 
                $stmt = $con->prepare("UPDATE user SET RegStatus = 1 WHERE UserID = ?");
                $stmt->execute(array($userid));
                $theMsg = "<div class='msg nice-message'>" . $stmt->rowCount() . ' ' . 'Recorde Activated</div>';
                redirectHome($theMsg, 'back');
            }
            echo '</div>';

        
		 }elseif($do == 'NotActivate'){ // NotActivate Member Page 
                    
                echo "<h1 class='text-center'>Stop Activate Member</h1>";
                echo "<div class='container'>";
            
                // check If Get Reques userid Is Numeric & Get The Integer Value Of It
            
                $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
                
                // Select All Data Depend On This ID
                
                $check = checkItem('userid', 'user', $userid);


            // If There's  Such ID Show The Form
            
            if ($check > 0){ 
                $stmt = $con->prepare("UPDATE user SET RegStatus = 0 WHERE UserID = ?");
                $stmt->execute(array($userid));
                $theMsg = "<div class='msg nice-message'>" . $stmt->rowCount() . ' ' . 'Recorde Stop Activated</div>';
                redirectHome($theMsg, 'back');
            }
            echo '</div>';

        }

        include $tpl . "footer.php";
    }else{
        header('Location: index.php');
        exit();
    }
    ob_end_flush();
?>