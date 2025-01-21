<?php
/*
=============================================
== Manage Employee Page
== You Can Add | Edit | Delete Employees From Here
*/

ob_start();  // Output Buffering Start
session_start();
$pageTitle='Department Page';
include 'init.php';

    if (isset($_SESSION['Username'])){
        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

        // Start Manage Page

        if ($do == 'Manage'){ // Manage Department Page


            // Select All Users Except Admin
            $stmt = $con->prepare("SELECT * FROM depart");

            //Excute The Statment 

            $stmt->execute();
                        //Assign To Variable
			
            $rows = $stmt->fetchAll();
            if(! empty($rows)){
			
            ?>
            
	<div class="container">
		
		<h1 class="text-center">Manage <b>Department</b></h1>
		<div class="newtable">
		<a href="department.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Department</a>

			<div class="table-responsive">
				<div class="table-wrapper">	
						<table class="table table-bordered table-striped table-hover manage-members text-center" id="myTable">
							<thead>
								<tr>
									<th>#ID</th>
                                    <th>Department Name</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
							<?php
								foreach($rows as $row){
									echo "<tr>";
										echo "<td>" . $row['departID'] . "</td>";
                                        echo "<td>" . $row['departName'] . "</td>";
                                       
										echo "<td>
											<a href='department.php?do=Edit&departid=" . $row['departID'] . "' class='edit' title='Edit' data-toggle='tooltip'><i class='fa fa-edit'></i> </a>";
										
									echo "</td>";
								echo "</tr>";
								}
							?>
							</tbody>
						</table>
						
					</div>
			</div>        
		</div>
			
			
            
            </div>
            <?php }else{
                echo '<div class="container">';
                echo '<div class="msg nice-message">There\'s No Departments To Show</div><br>';
                    echo '<a href="department.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Department</a>';
                echo '</div>';
            } ?>
        <?php } elseif($do == 'Add'){ //Add Department Pages ?>

            
                <h1 class="text-center">Add New <b> Department</b></h1> 
                <div class="container">
				<div class="addcat">
                    <form class="form-horizontal" action="?do=Insert" method="POST">

 
                        <!-- Start Department Field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-3 control-label" for="">Department</label>
                            <div class="col-sm-8 col-md-8">
                                <input type="text" name="depart" class="form-control" required="required" placeholder="Department">
                            </div>
                        </div>
                        <!-- End Department Field -->
                        <!-- Start button Field -->
                        <div class="form-group form-group-lg">
                            <div class="col-sm-offset-3 col-sm-10">
                                <input type="submit" value="Add Employee" class="btn btn-primary btn-lg">
                            </div>
                        </div>
                        <!-- End button Field -->
                    </form>
                </div>
				</div>
   <?php 

        }elseif ($do == 'Insert') {

            // Insert Member Page
            
            if($_SERVER['REQUEST_METHOD']== 'POST'){
                echo "<h1 class='text-center'>Insert <b> Department</b></h1>";
                echo "<div class='container'>";

                // Get Variables From The Form              
                $depart   = $_POST['depart'];

                // Validate The Form

                $formError = array();
				
                if(empty($depart)){
                    $formError[] = '<div class="msg danger-message">Name Can\'t Be <strong>Empty</strong></div>';
                }
               
                //Loop Into Error Array And Echo It
                foreach($formError as $error){
                    echo '<div class="msg danger-message">' . $error . '</div>';
                }

                // Check If No Error Proced The Update Operation

                if(empty($formError)){

                    // Check If Department Exit In Database

                    $check = checkItem("departName", "depart", $depart);
                    if($check == 1){
                        $theMsg = '<div class="msg danger-message">Sorry This Department ' . '<strong> "' . $depart . '" </strong>' . ' Is Exist</div>';
                        redirectHome($theMsg, 'back');
                    }else{

                     // Insert department Info In Database
                    $stmt = $con->prepare("INSERT INTO depart(departName) VALUES (:zdepartname)");
                    $stmt->execute(array(
                        'zdepartname' => $depart
                    ));
                    
                    // Echo Success Message

                    echo "<div class='container'>";
                    $theMsg = "<div class='msg nice-message'>" . $stmt->rowCount() . ' ' . 'Recorde Inserted</div>';
                    redirectHome($theMsg,'back');
                    echo "</div>";
                }
            }
               
                }else{
                $theMsg = "<div class='msg danger-message'>Sorry You Can\'t Browse this Page Directly</div>";
                redirectHome($theMsg);
            }
            echo "</div>";
            
         }elseif ($do == 'Edit') { // Edit Page

            // check If Get Reques departid Is Numeric & Get The Integer Value Of It
            
            $departid = isset($_GET['departid']) && is_numeric($_GET['departid']) ? intval($_GET['departid']) : 0;
            
            // Select All Data Depend On This ID

            $stmt = $con->prepare("SELECT * FROM depart WHERE departID = ? LIMIT 1");
            
            // Execute Query
            
            $stmt->execute(array($departid));

            // Fetch The Data

            $row = $stmt->fetch();

            // The Row Count

            $count = $stmt->rowCount();

        // If There's No Such ID

        if ($count > 0){  ?>

            <h1 class="text-center">Edit <b>Department</b></h1> 
            <div class="container">
			<div class="addcat">
                <form class="form-horizontal" action="?do=Update" method="POST">
                <input type="hidden" name="departid" value="<?php echo $departid ?>">

                <!-- Start Department Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-3 control-label" for="">Department</label>
                    <div class="col-sm-8 col-md-8">
                        <input type="text" pattern="[A-Za-z-ا-ى].{2,}" title="Department should be in characters only and greater than 2 characters" name="departName" class="form-control" value="<?php echo $row['departName'] ?>" autocomplete="off" required="required" >
                    </div>
                </div>
                <!-- End Department Field -->
                    <!-- Start button Field -->
                    <div class="form-group form-group-lg">
                        <div class="col-sm-offset-3 col-sm-10">
                            <input type="submit" value="Edit" class="btn btn-primary btn-lg">
                        </div>
                    </div>
                    <!-- End button Field -->
                </form>
            </div>
		</div>

            <?php }else{
               
               // If There's No Such ID Show Error Message

                echo "<div class='container'>";
                $theMsg = '<div class="msg danger-message">there no such ID</div>';
                redirectHome($theMsg);
                echo "</div>";
            }

            }elseif($do == 'Update') {   // Update Page
              
                if($_SERVER['REQUEST_METHOD']== 'POST'){
                    echo "<h1 class='text-center'>Update <b>Department</b></h1>";
                    echo "<div class='container'>";
		
                    // Get Variables From The Form
                    $departid = $_POST['departid'];
					$depart   = $_POST['departName'];


                    // Validate The Form

                    $formError = array();

					 if(empty($depart)){
                        $formError[] = '<div class="msg danger-message">department Can\'t Be <strong>Empty</strong></div>';
                    }
                  
                    //Loop Into Error Array And Echo It

                    foreach($formError as $error){
                        echo $error;
                    }

                    // Check If No Error Proced The Update Operation

                    if(empty($formError)){

						// Check If depart Exit In Database

                        $stmt2 = $con->prepare("SELECT * From depart WHERE departName = ? AND departID != ?");
                        $stmt2->execute(array($depart, $departid));
                        $count = $stmt2->rowCount();
                        if($count == 1){
                            $theMsg ='<div class="msg danger-message">sorry This department Is Exist</div>';
                            redirectHome($theMsg, 'back');
                        }else{
                                // Update The Database With This Info

                                $stmt = $con->prepare("UPDATE depart SET departName=? WHERE departID=?");
                                $stmt->execute(array($depart, $departid));
                                // Echo Success Message
                                $theMsg = "<div class='msg nice-message'>" . $stmt->rowCount() . ' ' . 'Recorde Updated</div>';
                                redirectHome($theMsg, 'back');
                            }
                        }
                   
                    }else{
                    $theMsg = "<div class='msg danger-message'>Sorry You Can't Browse this Page Directly</div>";
                    redirectHome($theMsg);
                }
                echo "</div>";
            } elseif($do == 'Delete'){ // Delete department Page 
                
                echo "<h1 class='text-center'>Delete <b>department</b></h1>";
                echo "<div class='container'>";
              
                // check If Get Reques departid Is Numeric & Get The Integer Value Of It
            
                $departid = isset($_GET['departid']) && is_numeric($_GET['departid']) ? intval($_GET['departid']) : 0;
                
                // Select All Data Depend On This ID
                
                $check = checkItem('departid', 'depart', $departid);


            // If There's  Such ID Show The Form

            if ($check > 0){ 
                $stmt = $con->prepare("DELETE FROM depart WHERE departID = :departid");
                $stmt->bindParam(":departid", $departid);
                $stmt->execute();
                $theMsg = "<div class='msg nice-message'>" . $stmt->rowCount() . ' ' . 'Recorde Deleted</div>';
                redirectHome($theMsg);
            }else{
                $theMsg = '<div class="msg danger-message">This Id IS NOT Exist</div>';
                redirectHome($theMsg);
            }
            echo '</div>';
           
		 }
        include $tpl . "footer.php";
    }else{
        header('Location: index.php');
        exit();
    }
    ob_end_flush();
?>