<?php
// Developed by Laila Mohamed: Laila.arkanorg.com
/////////////////////////////////////////////////

    ob_start();  // Output Buffering Start
    session_start();
    $pageTitle = 'Change Password';
    include 'init.php';
    if(isset($_SESSION['user'])){
    

        //  Check If User Coming From HTTP Post Request
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $formErrors = array();
        $id     = $_POST['userid'];
        $pass = $_POST['oldpassword'];
        $password = $_POST["password"];
        $password2 = $_POST['password2'];
        $hashedPass = sha1($pass);
        $passid = empty($_POST['password']) ? $_POST['oldpassword'] : sha1($_POST['password']);
        /////////////////////////////////////////

        if(isset($password) && isset($password2)){
            if(empty($_POST['password'])){
                $formErrors[] = 'Sorry Password Cant Be Empty';
            }
            $pass1 = sha1($password);
            $pass2 = sha1($password2);
            if($pass1 !== $pass2){
                $formErrors[] = 'Sorry Password is Not match';
            }
        }

        // check if there's no error proced the user add
        if(empty($formErrors)){
             // Check If The User Exist In Database
        $stmts = $con->prepare("SELECT UserID, Pasword FROM user  WHERE Pasword = ? LIMIT 1");
        
        $stmts->execute(array($hashedPass));
        $row = $stmts->fetch();
        $count = $stmts->rowCount();
        if ($count > 0){
            $_SESSION['oldpassword'] = $pass;    // Register session name
        }
        if($row > 0){
            $_SESSION['uid'] = $id;
            $msg1 = '<strong>Success :</strong>The Old Password Correct';

                // insert userinfo in database
                $stmt = $con->prepare("UPDATE 
                                        user SET Pasword=? 
                                        WHERE 
                                            UserID=?");
                                            $stmt->execute(array($pass, $id));

                // echo success message
                $succesMsg = 'congrats you are now Change Password';

               
                }else {
                    $msg = '<strong>Sorry :</strong> The Old Password NOT Correct';
                }
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?php echo $css ?>bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $css ?>font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo $css ?>backend.css">
    <title><?php echo getTitle(); ?></title>
</head>
<body>
<div class="container-fluid updated" style="margin: 50px auto">
    <h1 class="text-left">CHANGE PASSWORD</h1>
        <div class="addcat update" style="width: 1100px; padding: 0">
        <?php
             if(!empty($msg)){
                ?>
                <div class="msg danger-message" style="margin: 30px 20px;"><?=$msg;?></div>
            <?php
            }
             if(!empty($msg1)){
                ?>
                <div class="msg nice-message" style="margin: 30px 20px;"><?=$msg1;?></div>
            <?php
            }
            ?>
             <div class="the-errors text-center" style="margin: 30px 20px;">
                <?php
                    if(!empty($formErrors)){
                        foreach($formErrors as $error){
                            echo '<div class="msg danger-message">' .$error . '</div>';
						   
                        }
                    }
                    if(isset($succesMsg)){
                        echo '<div class="msg nice-message">' . $succesMsg . '</div>';
                    }
                ?>
         <form class="login" style="margin: 30px auto 30px auto;" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
         <input type="hidden" name="userid" value="<?php echo $id ?>">
             <div class="group">
                 <input type="password" autocomplete="off" name="oldpassword" class="form-control password" required >
                 <span class="highlight"></span>
                 <span class="bar"></span>
                 <label>Enter Old Password</label>
             </div>
             <div class="group">
                  <input type="hidden" name="password" Value="<?php echo $row['Pasword'] ?>">
                 <input id="myInput"  type="password" name="password" autocomplete="new-password" required />
                 <span class="highlight"></span>
                 <span class="bar"></span>
                 <label>Enter New Password</label>
             </div>
             <div class="group">
                 <input id="myInput"  type="password" name="password2" autocomplete="new-password" required />
                 <span class="highlight"></span>
                 <span class="bar"></span>
                 <label>Enter Confirm Password</label>
             </div>
             <div class="text-center">
                 <input class="btn btn-primary btn-lg" type="submit" value="CHANGE" />
             </div>
        
     </form>
    </div>
    </div>
        <?php
                    
    }else{
        header('Location: index.php');
        exit();
    }
	
    include $tpl . 'footer.php';
    ob_end_flush();