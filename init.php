<?php
// Error Reporting
ini_set('display_errors', 'On');
error_reporting(E_ALL);

include 'admin/connect.php';

$sessionUser = '';
if(isset($_SESSION['user'])){
    $sessionUser = $_SESSION['user'];
}
// Routes
$tpl   = 'include/templates/'; // template Directory
$func  = 'admin/include/functions/'; // Function Directory
$css   = 'admin/layout/css/'; // css Directory
$js    = 'admin/layout/js/'; // js Directory


// Include The Important Files
include $func . "function.php";

//Include Header On All Expect The On With $noHeader Variable
if(!isset($noheader)){ include $tpl . "header.php"; }
//Include Navbar On All Expect The On With $noNavbar Variable
if(!isset($noNavbar)){ include $tpl . "navbar.php"; }


?>