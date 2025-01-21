<?php
/*
=============================================
// Developed by Laila Mohamed: Laila.arkanorg.com
== ApplybFor Leave Page
== You Can Add | Edit | Delete Employees From Here
*/

ob_start();  // Output Buffering Start
session_start();
$pageTitle='Employee Leave Management System';
include 'init.php';
if (isset($_SESSION['Username'])){

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    
    if ($do == 'Manage'){   // Manage Members Page     
        
        $stmt = $con->prepare("SELECT leavapply.*, user.Username, user.Fullname FROM leavapply INNER JOIN user ON user.UserID = leavapply.UserID ORDER BY LeaveID DESC");
        
        $stmt->execute();
        $leaves = $stmt->fetchAll();
        if(! empty($leaves)){
            if(isset($_POST['records-limit'])){
                $_SESSION['records-limit'] = $_POST['records-limit'];
            }
            
            $limit = isset($_SESSION['records-limit']) ? $_SESSION['records-limit'] : 5;
            $page = (isset($_GET['page']) && is_numeric($_GET['page']) ) ? $_GET['page'] : 1;
            $paginationStart = ($page - 1) * $limit;
            $leaves = $con->query("SELECT leavapply.*, user.Username, user.Fullname FROM leavapply INNER JOIN user ON user.UserID = leavapply.UserID ORDER BY LeaveID DESC LIMIT $paginationStart, $limit")->fetchAll();

            // Get total records
            $sql = $con->query("SELECT count(LeaveID) AS LeaveID FROM leavapply")->fetchAll();
            $allRecrods = $sql[0]['LeaveID'];
            
            // Calculate total pages
            $totoalPages = ceil($allRecrods / $limit);

            // Prev + Next
            $prev = $page - 1;
            $next = $page + 1;
         ?>
        <div class="container-fluid updated leaved" style="margin: 50px auto">
            <h1 class="text-left">Leave History</h1>
            <div class="newtable">
                <div class="table-responsive">
                    <div class="table-wrapper">	
                        <form name='frmSearch' action='' method='post'>		
                            <div class="table-title">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <div class="show-entries">
                                            <div class="d-flex flex-row-reverse bd-highlight mb-3">
                                                <form action="leave.php" method="post">
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
                            <table class="table table-hover text-center" id="myTable">
                                <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th>Employee Name</th>
                                        <th>Type Of Leave</th>
                                        <th>Posting Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    foreach($leaves as $leave){
                                        echo "<tr>";
                                            echo "<td>" . $leave['LeaveID'] . "</td>";
                                            echo "<td><a href='view.php?leavid=" . $leave['LeaveID'] . "'>" . $leave['Fullname'] . '(' . $leave['Username'] . ")</a></td>";
                                            echo "<td>" . $leave['TypeLeave'] . "</td>";
                                            echo "<td>" . $leave['PostDate'] . "</td>";
                                            echo "<td>";
                                            if($leave['status'] == "Approve"){
                                                echo "<div class='nactive'>Approve</div>";
                                            }
                                            if($leave['status'] == "Not Approve"){
                                                echo "<div class='activi'>Not Approve</div>";
                                            }
                                            if($leave['status'] == "Waitting Approve"){
                                                echo "<div id='myBtn'><a href='leave.php?do=Edit&leavid=" . $leave['LeaveID'] . "' class='activ'>Waitting Approve</a></div>";
                                            }
                                        echo"</td>";
                                          
                                            echo '<td><a href="view.php?leavid=' . $leave["LeaveID"] . '" class="btn btn-primary details"> View Details</a> </td>';
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
                                                <a class="page-link" href="leave.php?page=<?= $i; ?>"> <?= $i; ?> </a>
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
            echo '</div>';
        } 
    } elseif ($do == 'Edit') {

            echo "<div class='container-fluid'>";
        
		// check If Get Reques leavid Is Numeric & Get The Integer Value Of It
		
		$leavid = isset($_GET['leavid']) && is_numeric($_GET['leavid']) ? intval($_GET['leavid']) : 0;
		
		// Select All Data Depend On This ID

		$stmt = $con->prepare("SELECT * FROM leavapply WHERE LeaveID = ? LIMIT 1");
		
		// Execute Query
		
		$stmt->execute(array($leavid));

		// Fetch The Data

		$row = $stmt->fetch();

		// The Row Count

		$count = $stmt->rowCount();

		// If There's No Such ID

        if ($count > 0){  ?>
   
         <div class="container-fluid updated" style="margin: 50px auto">
			<h1 class="text-center">Update Status</h1> 
			<div class="addcat update">
                <form class="form-horizontal" action="?do=Update" method="POST">
                    <input type="hidden" name="leavid" value="<?php echo $leavid ?>">
                    <!-- Start Status Field -->
                    <div class="grou col-md-12">
                        <select class="form-control" name="status" style="margin-bottom: 30px">
                            <option value="0">Status..</option>
                            <option value="Approve" <?php if($row['status'] == 1){ echo 'selected';} ?>>Approved</option>
                            <option value="Not Approve" <?php if($row['status'] == 3){ echo 'selected';} ?>>Not Approval</option>
                        </select>
                    </div>
                    <!-- End Status Field -->
                     <!-- Start Description Field -->
                     <div class="group col-md-12">
                        <textarea pattern="[A-Za-z-ا-ى].{2,}" title="Description should be in characters only and greater than 10 characters" name="Disc" class="form-control" required ></textarea>
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label style="color: gray; font-weight: bold">Description</label>
                    </div>
                    <!-- End Description Field -->
                    <!-- End Department Field -->
                    <!-- Start button Field -->
                    <div class="form-group form-group-lg text-center">
                        <div class="row">
                            <div class="col-sm-offset-2 col-sm-6">
                                <input type="submit" value="Edit" class="btn btn-primary btn-lg">
                            </div>
                        </div>
                    </div>
                    <!-- End button Field -->
                </form>
            </div>
         </div>
        <?php 
            }else{
            
            // If There's No Such ID Show Error Message
                echo "<div class='container'>";
                $theMsg = '<div class="msg danger-message">there no such ID</div>';
                redirectHome($theMsg);
                echo "</div>";
            }
        }elseif($do == 'Update') {   // Update Page
               
            if($_SERVER['REQUEST_METHOD']== 'POST'){
                echo "<h1 class='text-center'>Update <b>Status</b></h1>";
                echo "<div class='container'>";
                // Get Variables From The Form
                
                $leavid     = $_POST['leavid'];
                $status   = $_POST['status'];
                $disc   = $_POST['Disc'];
             // Validate The Form

             $formError = array();
                               
                if(empty($status)){
                    $formError[] = '<div class="msg danger-message">status Can\'t Be <strong>Empty</strong></div>';
                }
                 //Loop Into Error Array And Echo It

                 foreach($formError as $error){
                    echo $error;
                }

                // Check If No Error Proced The Update Operation

                if(empty($formError)){


                    // Update The Database With This Info

                    $stmt = $con->prepare("UPDATE
                                                leavapply 
                                        SET 
                                                status=?,
                                                Disc=?
                                        WHERE 
                                                LeaveID=?");
                    $stmt->execute(array($status, $disc, $leavid));
                    // Echo Success Message
                    $theMsg = "<div class='msg nice-message'>" . $stmt->rowCount() . ' ' . 'Recorde Updated</div>';
                    redirectHome($theMsg, 'leave.php');
                }
                 
               
            }else{
                $theMsg = "<div class='msg danger-message'>Sorry You Can't Browse this Page Directly</div>";
                redirectHome($theMsg);
            }
            echo "</div>";
        }
    include $tpl . "footer.php";
    }else{
        header('Location: index.php');
        exit();
    }
    ob_end_flush();
?>