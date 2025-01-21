<?php
/*
=============================================
== ApplybFor Leave Page
== You Can Add | Edit | Delete Employees From Here
*/

ob_start();  // Output Buffering Start
session_start();
$pageTitle='Employee Leave Management System';
include 'init.php';
if (isset($_SESSION['user'])){
        $getUser = $con->prepare("SELECT * FROM user WHERE Username =?");
        $getUser->execute(array($sessionUser));
        $info = $getUser->fetch();
        $userid = $info['UserID'];
        


            $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    
            // Start Manage Page
    
            if ($do == 'Manage'){   // Manage leaves Page     
                
            $leaves = getAllFrom("*", "leavapply", "where UserID = $userid", "", "LeaveID");
            if (!empty($leaves)){ 
                    
                if(isset($_POST['records-limit'])){
                    $_SESSION['records-limit'] = $_POST['records-limit'];
                }
                
                $limit = isset($_SESSION['records-limit']) ? $_SESSION['records-limit'] : 5;
                $page = (isset($_GET['page']) && is_numeric($_GET['page']) ) ? $_GET['page'] : 1;
                $paginationStart = ($page - 1) * $limit;
                $leaves = $con->query("SELECT * FROM leavapply ORDER BY LeaveID DESC LIMIT $paginationStart, $limit")->fetchAll();
  
                // Get total records
                $sql = $con->query("SELECT count(LeaveID) AS LeaveID FROM leavapply")->fetchAll();
                $allRecrods = $sql[0]['LeaveID'];
                
                // Calculate total pages
                $totoalPages = ceil($allRecrods / $limit);
  
                // Prev + Next
                $prev = $page - 1;
                $next = $page + 1;

                ?>
            
                <div class="container updated">
                    
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
                                    <table class="table table-bordered table-striped table-hover text-center" id="myTable">
                                        <thead>
                                            <tr>
                                                <th>#ID</th>
                                                <th>Type Of Leave</th>
                                                <th>From</th>
                                                <th>To</th>
                                                <th>Description</th>
                                                <th>Posting Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            foreach($leaves as $leave){
                                                echo "<tr>";
                                                    echo "<td>" . $leave['LeaveID'] . "</td>";
                                                    echo "<td>" . $leave['TypeLeave'] . "</td>";
                                                    echo "<td>" . $leave['DateFrom'] . "</td>";
                                                    echo "<td>" . $leave['DateTo'] . "</td>";
                                                    echo "<td>" . $leave['Disc'] . "</td>";
                                                    echo "<td>" . $leave['PostDate'] . "</td>";
                                                    echo "<td>";
                                                        if($leave['status'] == 'Waitting Approve'){
                                                            echo "<div style='font-weight:bold;color: blue; padding:5px'>Waitting For Approval</div>";
                                                        }
                                                        if($leave['status'] == 'Approve'){
                                                            echo "<div style='font-weight:bold;color:green; padding:5px'>Approve</div>";
                                                        }
                                                        if($leave['status'] == 'Not Approve'){
                                                            echo "<div style='font-weight:bold;color: red; padding:5px'>Not Approve</div>";
                                                        }
                                                       
                                                    echo"</td>";
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
                    echo '<div class="msg nice-message">There\'s No Leave History To Show</div><br>';
                        echo '<a href="leave.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> Apply Leave</a>';
                    echo '</div>';
                } ?>
     <?php } elseif($do == 'Add'){ //Add Apply Pages ?>
            
                 
                <div class="container updated" style="margin: 50px auto">
                <h1 class="text-left">Apply For  Leave</h1>
				<div class="addcat update" style="width: 1100px;">
                    <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
                        
                          <!-- Start  From Date Field -->
                        <div class="group col-md-6">
                            <input type="date" name="DateFrom" class="form-control" required="required">
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>From Date</label>
                        </div>
                        <!-- End From Date Field -->
                      
                          <!-- Start  To Date Field -->
                        <div class="group col-md-6">
                            <input type="date" name="DateTo" class="form-control" required="required">
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>To Date</label>
                        </div>
                        <!-- End To Date Field -->
                       
                        <!-- Start Select leave Type Field -->
                        <div class="grou col-md-12">
                            <select class="form-control" name="TypeLeave" style="margin-bottom: 10px">
                                <option value="0">Select leave Type..</option>
                                <option value="Casual Leave">Casual Leave</option>
                                <option value="Medical Leave test">Medical Leave test</option>
                                <option value="Restricted Holiday(RH)">Restricted Holiday(RH)</option>
                            </select>
                        </div>
                        <!-- End Select leave Type Field -->
                         <!-- Start Description Field -->
                         <div class="group col-md-12">
                                <textarea pattern="[A-Za-z-ا-ى].{2,}" title="Description should be in characters only and greater than 10 characters" name="Disc" class="form-control" autocomplete="off" required="required"></textarea>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>Description</label>
                        </div>
                        <!-- End Description Field -->

                        <!-- Start button Field -->
                        <div class="form-group form-group-lg">
                            <div class="col-sm-offset-3 col-sm-10">
                                <input type="submit" value="Apply" class="btn btn-primary btn-lg">
                            </div>
                        </div>
                        <!-- End button Field -->
                    </form>
                </div>
				</div>
   <?php 

        }elseif ($do == 'Insert') {

            // Insert ApplyLeave Page
            
            if($_SERVER['REQUEST_METHOD']== 'POST'){
                echo "<h1 class='text-center'>Apply <b> Leave</b></h1>";
                echo "<div class='container'>";

                // Get Variables From The Form
                $DateFrom   = $_POST['DateFrom'];
                $DateTo    = $_POST['DateTo'];
                $TypeLeave   = $_POST['TypeLeave'];
                $Disc  = $_POST['Disc'];                
                

                // Validate The Form

                $formError = array();

                if(empty($DateFrom)){
                    $formError[] = 'Date From Can\'t Be <strong>Empty</strong>';
                }
                if(empty($DateTo)){
                    $formError[] = 'Date To Can\'t Be <strong>Empty</strong>';
                }

				if(strlen($Disc) < 10) {
                    $formError[] = 'Description Can\'t Be Less Than <strong>10 Characters</strong>';
                }
				
                if(empty($Disc)){
                    $formError[] = 'Description Can\'t Be <strong>Empty</strong>';
                }

                if(empty($TypeLeave)) {
                    $formError[] = 'Type of Leave Can\'t Be <strong>Empty</strong>';
                }

                //Loop Into Error Array And Echo It

                foreach($formError as $error){
                    echo '<br><br><br><div class="msg danger-message">' . $error . '</div>';
                }

                // Check If No Error Proced The Update Operation

                if(empty($formError)){


                     // Insert leavapply Info In Database
                    $stmt = $con->prepare("INSERT INTO
                                                      leavapply(DateFrom, DateTo, TypeLeave, Disc, PostDate, status,UserID) 
                                           VALUES
                                                      (:zDateFrom, :zDateTo, :zTypeLeave, :zDisc,  now(), 'Waitting Approve',:zuser) ");
                    $stmt->execute(array(
                        'zDateFrom' => $DateFrom,
                        'zDateTo' => $DateTo,
                        'zTypeLeave' => $TypeLeave,
                        'zDisc' => $Disc,
                        'zuser' => $_SESSION['uid']
                    ));
                    
                    // Echo Success Message

                    echo "<div class='container'>";
                    $theMsg = "<div class='msg nice-message'>" . $stmt->rowCount() . ' ' . 'Recorde Inserted</div>';
                    redirectHome($theMsg,'back');
                    echo "</div>";
                
            }
               
                }else{

                $theMsg = "<div class='msg danger-message'>Sorry You Can\'t Browse this Page Directly</div>";
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