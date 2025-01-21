<?php
// Developed by Laila Mohamed: Laila.arkanorg.com
/////////////////////////////////////////////////
include 'connect.php';

// Routes
$tpl   = 'include/templates/'; // template Directory
$func  = 'include/functions/'; // Function Directory
$css   = 'layout/css/'; // css Directory
$js    = 'layout/js/'; // js Directory

$sessionUser = '';
if(isset($_SESSION['Username'])){
    $sessionUser = $_SESSION['Username'];
}

// Include The Important Files
include $func . "function.php";
// include $tpl . "header.php";

//Include Header On All Expect The On With $noHeader Variable
if(!isset($noheader)){ include $tpl . "header.php"; }
//Include Navbar On All Expect The On With $noNavbar Variable
if(!isset($noNavbar)){ include $tpl . "navbar.php"; }

//Include Navbar On All Expect The On With $noNavbar Variable
// if(!isset($noFooter)){ include $tpl . "footer.php"; }

?>