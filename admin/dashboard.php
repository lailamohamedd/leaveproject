<?php
// Developed by Laila Mohamed: Laila.arkanorg.com
/////////////////////////////////////////////////
    ob_start();  // Output Buffering Start
    session_start();
    if (isset($_SESSION['Username'])){
        $pageTitle = 'Dashboard';
        include 'init.php';
        
        // Start Dashboard Page
        $numLeaves = 5; //number of latest users
        $latestLeaves = getLatest("*", "leavapply", "LeaveID", $numLeaves); // latest Leaves array
        ?>
        <div class="container home-stats text-center">
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <div class="stat st-members">
                        <i class="fa fa-users"></i>
                        <div class="info">
                            TOTAL EMPLOYEES
                            <span><a href="members.php"><?php echo countItems('UserID', 'user') ?></a></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                <div class="stat st-members">
                    <i class="fa fa-cogs"></i>
                    <div class="info">
                         TOTAL DEPARTMENTS
                        <span><?php echo countItems('departID', 'depart') ?></span>
                    </div>
                </div>
            </div>
                <div class="col-md-4 col-sm-6">
                    <div class="stat st-members">
                        <i class="fa fa-plus"></i>
                        <div class="info">
                            TOTAL LEAVE APPLICATIONS
                            <span><a href="leave.php"><?php echo countItems('LeaveID', 'leavapply') ?></a></span>
                        </div>
                    </div>
                </div>
               
            </div>
        </div>
        <div class="container updated leaved">
            <div class="row">
                <div class="col-sm-12">
                <div class="newtable" style="margin-top: 50px">
                    
                        <ul class="list-unstyled latest-user">
                            <?php
                               if(! empty($latestLeaves)){ ?>
                                <div class="table-responsive">
                                <div class="table-wrapper">	
                                    <form name='frmSearch' action='' method='post'>				
                                        <div class="table-title">
                                        <table class="table table-hover text-center" id="myTable">
                                        <h1 class="text-left">LATEST LEAVE APPLICATIONS</h1>
                                            <thead>
                                                <tr>
                                                    <th>#ID</th>
                                                    <th>Type Of Leave</th>
                                                    <th>Posting Date</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach($latestLeaves as $leave){
                                                    echo "<tr>";
                                                        echo "<td>" . $leave['LeaveID'] . "</td>";
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
                                                            echo "<div><a href='leave.php?do=Edit&leavid=" . $leave['LeaveID'] . "' class='activ'>Waitting Approve</a></div>";
                                                        }
                                                    echo"</td>";
                                                       echo '<td><a href="view.php?leavid=' . $leave["LeaveID"] . '" class="btn btn-primary details"> View Details</a> </td>';
                                               echo "</tr>";
                                                }
                                            ?>
                                            </tbody>
                                        </table>
                                       
                                        
                                    </div>
                                </form>
                            </div>
                              <?php
                            }else{
                                      echo 'There\'s No Users To Show' ;     
                            }
                            ?>
                        </ul>
                </div>
            </div>
            </div>
            </div>
        <?php

        // End Dashboard Page
                        
        include $tpl . "footer.php";
    }else{
        header('Location: index.php');
        exit();
    }
ob_end_flush();
?>