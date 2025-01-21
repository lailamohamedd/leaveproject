<?php
// Developed by Laila Mohamed: Laila.arkanorg.com
/////////////////////////////////////////////////

    ob_start();  // Output Buffering Start
    session_start();
    $pageTitle = 'Edit Password';
    include 'init.php';
    if(isset($_SESSION['Username'])){
 ?>
            
            <div class="container-fluid updated" style="margin: 50px auto">
            <h1 class="text-left">CHANGE ADMIN PASSWORD</h1>
                <div class="addcat update" style="width: 1100px;">
                    <div class="row">
                        <form class="form-horizontal" style="margin: 30px auto 30px auto;"  action="?do=Update" method="POST">
                            <!-- Start Phone Field -->
                            <div class="group">
                                <input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"  autocomplete="off" name="newpassword" class="form-control password" autocomplete="new-password" required >
                                <i class="show-pass fa fa-eye fa-2x"></i>                              
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Password</label>
                            </div>
                            <!-- End Phone Field -->
                            
                            <!-- Start button Field -->
                            <div class="text-center">
                            <input class="btn btn-primary btn-lg" type="submit" value="CHANGE" />
                        </div>
                            <!-- End button Field -->
                        </form>
                        </div>
                    </div>
                </div>
    <?php 
        if($_SERVER['REQUEST_METHOD']== 'POST'){
            echo "<div class='container'>";

            // Get Variables From The Form
                
            $pass = sha1($_POST['newpassword']);

            // Validate The Form
            $formError = array();

            //Loop Into Error Array And Echo It

            foreach($formError as $error){
                echo $error;
            }

            // Check If No Error Proced The Update Operation

            if(empty($formError)){
                
                // Update The Database With This Info

                $stmt = $con->prepare("UPDATE
                                            user 
                                    SET 
                                        Pasword=?
                                    WHERE 
                                            GroupID=1");
                $stmt->execute(array( $pass));
                // Echo Success Message
                $theMsg = "<div class='msg nice-message'>" . $stmt->rowCount() . ' ' . 'Recorde Updated</div>';
                redirectHome($theMsg);
        }
    }
echo "</div>";
    }else{
        header('Location: index.php');
        exit();
    }
	
    include $tpl . 'footer.php';
    ob_end_flush();
?>