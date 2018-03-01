<?php include "mongo_connection.php";?>
<?php
if (isset($_GET['id']) && isset($_GET['facility'])) {


	  $property_id_by_link=new MongoId($_GET['id']);
	  $property_id_by_link = new MongoId($property_id_by_link);
	  $facility = $_GET['facility'];

	   $delete_query = $property_collection->update(array("_id" => $property_id_by_link,"facilities"=>$facility),
                                                              array('$pull' => array("facilities"=>$facility)
                                                               
                                                               ));
    if(!$delete_query) {
            
            echo "FAILED!";
        }
        else{
          header("Location:../update_property.php?id=$property_id_by_link&update=1");
        }
    }
	 

else{
	echo"failed!!";
}
?>