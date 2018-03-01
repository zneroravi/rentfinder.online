<?php include "mongo_connection.php";?>
<?php session_start(); ?>
<?php
if (isset($_GET['app_id'])) {
	$id =$_GET['app_id'];
	$id = new MongoId($id);
	var_dump($id);
	try{
	$delete_app = $scheduled_collection->remove(array("_id"=>$id));
	$userid = $_SESSION['_id'];
	header("location: /Rentfinder/user_account.php?userid=$userid");
	}

	catch(Exception $exc){
		
		echo $exc;
	}
}
?>