<?php include "mongo_connection.php";?>
<?php
if (isset($_GET['id']) && isset($_GET['room_index'])) {

//room is number
	  $property_id_by_link=new MongoId($_GET['id']);
	  $property_id_by_link = new MongoId($property_id_by_link);
	  $room_index = $_GET['room_index'];
    echo $room_index;

	   $delete_query = $property_collection->update(array("_id" => $property_id_by_link, "rooms_available" =>array("0" => array("number"=>"106") )), array('$pull' => array("rooms_available" =>array("0" => array("number"=>"106") )) ));
    if(!$delete_query) {
            
            echo "FAILED!";
        }
        else{
          header("Location:../update_property.php?id=$property_id_by_link&update=1");
          //echo "SUCCESS";
        }
    }
	 

else{
	echo"failed!!";
}
?>