<?php
// Developed by Laila Mohamed: Laila.arkanorg.com
/////////////////////////////////////////////////
ob_start();  // Output Buffering Start
session_start();
$pageTitle='View | Leave Application';
include 'init.php';
if(isset($_SESSION['Username'])){

	$leavid = isset($_GET['leavid']) && is_numeric($_GET['leavid']) ? intval($_GET['leavid']) : 0;
	
	$stmt = $con->prepare("SELECT leavapply.*, user.Username, user.Fullname, user.Email, user.Phone FROM leavapply INNER JOIN user ON user.UserID = leavapply.UserID WHERE leavapply.LeaveID = $leavid ORDER BY LeaveID DESC");
	


	
	$stmt->execute();
	
	// Fetch The Data

	$leave = $stmt->fetch();

	// The Row Count

	$count = $stmt->rowCount();

	// If There's No Such ID

	if ($count > 0){ 

	?>
		<!-- Start Employee Data  -->
		<div class="shop-detail-box-main">
			<div class="container">
				<h4 class="leave">LEAVE DETAILS</h4>
				<div class="newtable">
				   <div class="table-responsive">
						<div class="table-wrapper">	
							<div class="table-title">
								<table class="table table-hover text-left" id="myTable">
								<h5 class="view text-left">LEAVE DETAILS</h5>
									<?php
									echo "<tr>";
										echo "<td class='bold'>Employee Name:</td>";
										echo "<td style='color: blue; font-weight:200'>" . $leave['Fullname'] . "</td>";
										echo "<td class='bold'>Emp username:</td>";
										echo "<td style='font-weight:200'>" . $leave['Username'] . "</td>";
										echo "<td></td>";
										echo "<td></td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td class='bold'>Emp Email:</td>";
										echo "<td style='font-weight:200'>" . $leave['Email'] . "</td>";
										echo "<td width='200px' class='bold'>Emp Contact No:</td>";
										echo "<td style='font-weight:200'>" . $leave['Phone'] . "</td>";
										echo "<td></td>";
										echo "<td></td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td class='bold'>Leave Type:</td>";
										echo "<td style='font-weight:200'>" . $leave['TypeLeave'] . "</td>";
										echo "<td class='bold'>Leave Date:</td>";
										echo "<td style='font-weight:200'> From " . $leave['DateFrom'] . " To " . $leave['DateTo'] . "</td>";
										echo "<td class='bold'>Posting Date:</td>";
										echo "<td style='font-weight:200'>" . $leave['PostDate'] . "</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td width='240px' class='bold'>Employee Leave Description:</td>";
										echo "<td style='font-weight:200'>" . $leave['Disc'] . "</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td class='bold'>Leave Status:</td>";
										echo "<td style='color: red !important; text-decoration: none'>";
											 if($leave['status'] == "Approve"){
                                                echo "<div class='nactive'>Approve</div>";
                                            }
                                            if($leave['status'] == "Not Approve"){
                                                echo "<div class='activi'>Not Approve</div>";
                                            }
                                            if($leave['status'] == "Waitting Approve"){
                                                echo "<div id='myBtn'><a href='leave.php?do=Edit&leavid=" . $leave['LeaveID'] . "' class='activ'>Waitting Approve</a></div>";
                                            }
										
										"</td>";
										echo "<td></td>";
										echo "<td></td>";
										echo "<td></td>";
										echo "<td></td>";
									echo "</tr>";
									?>
								</table>
						</div>
					</div>
				</div><br>
				<a href="leave.php" class="btn btn-primary details"> Back</a>
			</div>
		 </div>
		<!-- End Employee Data  -->
	<?php	}	else {
		  echo "<div class='container'>";
		  $theMsg = "<div class='msg danger-message' style='margin-top:150px'>Sorry You Can\'t Browse this Page Directly</div>";
		  redirectHome($theMsg);
		  echo '</div>';
	}
  }else{
	header('Location: index.php');
	exit();
}
include $tpl . 'footer.php';
ob_end_flush();
?>