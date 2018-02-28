<?php
$connection = new MongoClient();
if($connection)	{

$database = $connection->rentfinder;

$student_collection 	= $database->student_users;
$document = $student_collection->find(array("name" => "Udipto Goswami"));
print_r($document);

foreach ($document as $k) {
	$name = $k["name"];
	echo "$name" ." ". $k['email'] ." ". $k['registration'];

}

}


?>


