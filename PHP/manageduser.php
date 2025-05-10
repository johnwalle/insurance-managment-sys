<?php
session_start();
require_once "db_conn.php"; // Ensure your database connection is properly set here

if(isset($_GET['action']) && isset($_GET['username'])){
    $action=$_GET['action'];
    $USERID=$_GET['userid'];;
    $user=$_GET['username'];
    $query=mysqli_query($conn,"UPDATE users set Status='$action' where UserId='$USERID'");
 if(!$query){
 $error="error please try again";
 }
 else{
  echo "<script> alert('".$user." is ".$action." seccessfully');</script>";
  echo '<meta content="1;manageusers.php" http-equiv="refresh" />';
}
}


?>