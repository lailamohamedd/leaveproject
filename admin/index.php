<?php
    session_start();
    $noNavbar = "";
    $noheader = "";
    $pageTitle = 'Login | Admin';
    if (isset($_SESSION['Username'])){
        header('Location: dashboard.php'); //Redirect To Dashboard Page
    }
    include "init.php";

    // Check If User Coming From HTTP Post Request
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $username = $_POST['user'];
        $password = $_POST['pass'];
        $hashedPass = sha1($password);

        // Check If The User Exist In Database
        $stmt = $con->prepare("SELECT
                                     UserID, Username, Pasword
                               FROM
                                     user
                               WHERE
                                     Username = ?
                               AND 
                                     Pasword = ? 
                               AND 
                                     GroupID = 1 
                               LIMIT 
                                     1");

        $stmt->execute(array($username, $hashedPass));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();
        //If Count > 0This Mean The Database Contain Record About This Username
        if ($count > 0){
            $_SESSION['Username'] = $username;    // Register session name
            $_SESSION['ID'] = $row['UserID'];    // Register Session Id
            header('Location: dashboard.php');  // Redirect To Dashboard Page
            exit();
        }
        if($row > 0){
            $_SESSION['user'] = $id;
            $msg1 = '<strong>Success :</strong> Password and Username is Correct';
			header('refresh:1;url=dashboard.php');
			exit();
		}else {
            $msg = '<strong>Danger :</strong> Password and Username NOT Correct';
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
		<style>
			body{
				
			}
		</style>
    </head>
    <body id="login">
         <h2 class="text-center">Admin Login</h2>
        <div class="log">
            
            <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                <h3>ADMIN LOGIN</h3>
                    <div class="group">
                        <input type="text" name="user" autocomplete="off" required />
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>User Name</label>
                    </div>

                    <div class="group">
                        <input id="myInput"  type="password" name="pass" autocomplete="new-password" required />
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>Password</label>
                    </div>
                    <input class="btn btn-primary btn-lg" type="submit" value="LOGIN" />
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