<?php
    ob_start();  // Output Buffering Start
    session_start();
    $noNavbar = "";
    $noheader = "";
    $pageTitle = 'Login | Leave Application';

    if (isset($_SESSION['user'])){
        header("Location: updateuser.php?userid=$infoo"); //Redirect To profile Page
    }
    include "init.php";

    // Check If User Coming From HTTP Post Request
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        if (isset($_POST['login'])){
            $user = $_POST['Username'];
            $pass = $_POST['password'];
            $hashedPass = sha1($pass);

            // Check If The User Exist In Database
            $stmt = $con->prepare("SELECT
                                        *
                                FROM
                                        user
                                WHERE
                                        Username = ?
                                AND 
                                        Pasword = ?");

            $stmt->execute(array($user, $hashedPass));
			$row = $stmt->fetch();
			
           $count = $stmt->rowCount();
           // If Count > 0This Mean The Database Contain Record About This Username
            if ($count > 0){
                $_SESSION['user'] = $user;    // Register session name
                $_SESSION['uid'] = $row['UserID'];

                $infoo = $_SESSION['uid'];
                 header("Location: updateuser.php?userid=$infoo");
                   // Redirect To index Page
              exit();
            }else {
                $msg = '<strong>Danger :</strong> Password and Username NOT Correct';
            

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
    <body id="login">
         <h2 class="text-center">Leave Management System</h2>
        <div class="log">
            
            <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                <h3>EMPLOYEE LOGIN</h3>
                    <div class="group">
                        <input type="text"  name="Username" autocomplete="off" required />
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>User Name</label>
                    </div>

                    <div class="group">
                        <input id="myInput"  type="password"  name="password" autocomplete="new-password" required />
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>Password</label>
                    </div>

                <input class="btn btn-primary btn-lg" type="submit" value="LOGIN"  name="login"/>
                <?php
                if(!empty($msg)){
                    ?>
                    <div class="msg danger-message"><?=$msg;?></div>
                <?php
                }
                if(!empty($msg1)){
                    ?>
                    <div class="msg nice-message"><?=$msg1;?></div>
                <?php
                }
            ?>
            </form>
        </div>
<?php
    include $tpl . "footer.php";
?>