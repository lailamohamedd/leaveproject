<?php
// Developed by Laila Mohamed: Laila.arkanorg.com
/////////////////////////////////////////////////

    ob_start();  // Output Buffering Start
    session_start();
    $pageTitle = 'Edit Profile';
    include 'init.php';
    if(isset($_SESSION['user'])){
        
		// check If Get Reques userid Is Numeric & Get The Integer Value Of It
		
		$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

        if($userid = $_SESSION['uid']){

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
            
            <div class="container-fluid updated">
            <h1 class="text-left">Update Employee Details</h1>
                <div class="addcat update" style="width: 1100px;">
                    <div class="row">
                        <form class="form-horizontal" action="?do=Update" method="POST">
                            <input type="hidden" name="userid" value="<?php echo $userid ?>">
                                <!-- Start User Name Field -->
                                <div class="group col-md-6">
                                    <input type="text"  pattern="[A-Za-z-ا-ى].{2,}" title="Name should be in characters only and greater than 2 characters" name="username" class="form-control" value="<?php echo $row['Username'] ?>" autocomplete="off" required="required" disabled />
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                </div>
                                <!-- End User Name Field -->
                                 <!-- Start  Gender Field -->
                                 <div class="grou col-md-3">
                                    <select class="form-control text-right" name="gender" style="margin-bottom: 10px">
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
                                                if($row['departID'] == $depart['departID']){ echo 'selected';}
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
                                    <label>Country</label>
                                </div>
                                <!-- End Country Field -->
                                 <!-- Start Email Field -->
                                 <div class="group col-md-6">
                                    <input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" name="email" class="form-control" value="<?php echo $row['Email'] ?>" required="required">
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                    <label>Email</label>
                                </div>
                                <!-- End Email Field -->
                                <!-- Start  Country Field -->
                                <div class="group col-md-3">
                                    <input type="text" value="<?php echo $row['city'] ?>" pattern="[A-Za-z-ا-ى].{4,}" title="City should be in characters only and greater than 4 characters"  name="City" class="form-control" required="required" placeholder="City Appear In Profile Page">
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                    <label>City</label>
                                </div>
                                <!-- End Country Field -->
                                <!-- Start Phone Field -->
                                <div class="group col-md-6">
                                    <input type="number" value="<?php echo $row['Phone'] ?>" name="phone" class="form-control" required="required" placeholder="Phone Appear In Profile Page">
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                    <label>Phone</label>
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
                            <div class="form-group form-group-lg text-center col-md-12">
                                <div class="row group">
                                    <div class="col-sm-offset-2 col-sm-3">
                                        <input type="submit" value="Update" class="btn btn-primary btn-block btn-lg">
                                    </div>
                                </div>
                            </div>
                            <!-- End button Field -->
                        </form>
                        </div>
                    </div>
                </div>
    <?php }
        if($_SERVER['REQUEST_METHOD']== 'POST'){

            echo "<div class='container'>";

            // Get Variables From The Form
                
            $id     = $_POST['userid'];
            $email  = $_POST['email'];					
            $name   = $_POST['full'];
            $depart   = $_POST['depart'];
            $phone   = $_POST['phone']; 
            $gender   = $_POST['gender'];                
            $city   = $_POST['City'];
            $birth   = $_POST['birth'];
            $country   = $_POST['Country'];

            // Password Trick
            $pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);

            // Validate The Form
            $formError = array();

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
                $formError[] = '<div class="msg danger-message">Country Can\'t Be <strong>Empty</strong></div>';
            }
            if(empty($city)){
                $formError[] = '<div class="msg danger-message">city Can\'t Be <strong>Empty</strong></div>';
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
                                            Pasword=?, Email=?, Fullname=?, departID=?, Phone=?, genderid=?, city=?, Birth=?, Country=?
                                    WHERE 
                                            UserID=?");
                $stmt->execute(array( $pass, $email, $name, $depart, $phone, $gender, $city, $birth, $country, $id));
                // Echo Success Message
                $theMsg = "<div class='msg nice-message'>" . $stmt->rowCount() . ' ' . 'Recorde Updated</div>';
                redirectHome($theMsg);
            }
        }
    }
echo "</div>";

}
}else{
        header('Location: index.php');
        exit();
    }
	
    include $tpl . 'footer.php';
    ob_end_flush();
?>