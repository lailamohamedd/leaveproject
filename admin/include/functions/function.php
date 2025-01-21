<?php

    /*
    ** Get all Function v2.0
    ** Function To Get All Records From Any Database Table
    */
    function getAllFrom($field, $table, $where = NULL, $and = NULL, $orderfield, $ordering = "DESC"){
        global $con;
        $getAll = $con->prepare("SELECT $field FROM $table $where $and ORDER BY $orderfield $ordering");
        $getAll->execute();
        $all = $getAll->fetchAll();
        return $all;
    }

  /*
   ** Title Function V1.0
   ** Title Function That Echo The Page Title In Case The Page
   ** Has The Variable $pageTitle And Echo Default Title For Other Pages
   */

   function getTitle(){
       global $pageTitle;
       if (isset($pageTitle)){ echo $pageTitle; }else{ echo 'default'; }
   }

   /*
   ** Redirect Function v2.0
   ** This Function Accept Parameters
   ** $theMsg = Echo The Message [ error / success / warning]
   ** $url = The Link You Want To Redirect To
   ** $seconds = Seconds Before Redirecting
   */

   function redirectHome($theMsg, $url = null,$seconds = 3){
       if ($url === null){
           $url = 'index.php';
           $link = 'Homepage';
       } else {
           if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== ''){
                $url = $_SERVER['HTTP_REFERER'];
                $link = 'Previous Page';
            }else{
                $url = 'index.php';
                $link = 'Homepage';
           }  
       }
       echo $theMsg;
       echo "<div class='alert alert-info'>You Will Be Redirected To $link After $seconds Seconds</div>";
       header("refresh:$seconds;url=$url");
       exit();
    }

    /*
    ** Check Items Function v1.0
    ** Function to Check Item In Database [ function Accept Parameters ]
    ** $select = The Item To Select [ Example: user, item, category ]
    ** $form = The Table To Select From [ Example: users, items, categories ]
    ** $value = The Value Of Select [ Example: osama, Box, Electronics]
    */

    function checkItem($select, $from, $value){
        global $con;
        $statement = $con->prepare("SELECT $select FROM $from WHERE $select = ?");
        $statement->execute(array($value));
        $count = $statement->rowCount();
        return $count;
    }

    /*
    ** count Number of Items Function v1.0 
    ** Function To Count Number Of Items Rows
    ** $items = The Item To Count
    ** $table = The Table To Choose From
    */

    function countItems($item, $table){
        global $con;
        $stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");
        $stmt2->execute();
        return $stmt2->fetchColumn();
    }

    /*
    ** Get Latest Records Function v1.5
    ** Function To Get Latest Items From Database [ Users, Items, Comments ]
    ** $select = Field To Select
    ** $table = The Table To choose From
    ** $order = The Desc Ordering
    ** $limit = Number Of Records To Get
    */
    function getLatest($select, $table, $order, $limit = 6){
        global $con;
        $getStmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC Limit $limit");
        $getStmt->execute();
        $rows = $getStmt->fetchAll();
        return $rows;
    }
   /*
    ** Shop Page In Front End Design
    ** Get AD Items Function v1.0
    ** Function To Get AD Items From Database
    */
    function getItems($where, $value, $approve= NULL){
        global $con;
		$sql = $approve == NULL ? 'AND Approve = 1' : '';
        $getItems = $con->prepare("SELECT * FROM items WHERE $where =? $sql ORDER BY Items_ID DESC");
        $getItems->execute(array($value));
        $items = $getItems->fetchAll();
        return $items;
    } 
	    /*
    ** Check Post Function v1.0
    ** Function to Check Post In Database [ function Accept Parameters ]
    ** $select = The Post To Select [ Example: user, Post, category ]
    ** $form = The Table To Select From [ Example: users, Post, categories ]
    ** $value = The Value Of Select [ Example: osama, Box, Electronics]
    */

    function checkPost($select, $from, $value){
        global $con;
        $statement = $con->prepare("SELECT $select FROM $from WHERE $select = ?");
        $statement->execute(array($value));
        $count = $statement->rowCount();
        return $count;
    }

        /*
    ** Check If User Is Not Activated
    ** Function To check The RegStatus Of The User
    */
    function checkUserStatus($user){
        global $con;
        // Check If The User Exist In Database
        $stmtx = $con->prepare("SELECT
                                     Username, RegStatus
                               FROM
                                     user
                               WHERE
                                     Username = ?
                               AND 
                                     RegStatus = 0");

        $stmtx->execute(array($user));
        $status = $stmtx->rowCount();
        return $status;
    }

    function split_words($string, $nb_caracs, $separator){
        $string = strip_tags(html_entity_decode($string));
        if( strlen($string) <= $nb_caracs ){
            $final_string = $string;
        } else {
            $final_string = "";
            $words = explode(" ", $string);
            foreach( $words as $value ){
                if( strlen($final_string . " " . $value) < $nb_caracs ){
                    if( !empty($final_string) ) $final_string .= " ";
                    $final_string .= $value;
                } else {
                    break;
                }
            }
            $final_string .= $separator;
        }
        return $final_string;
    }
?>