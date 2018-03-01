<?php include "../includes/mongo_connection.php";?>
<?php include "includes_admin/header_admin.php"; ?>
<body>
    <?php include "includes_admin/navigation_admin.php";?>


     <?php 
    
        if($_SESSION['account_type']!="Admin")   {
            header("location:/Rentfinder/includes/error.php");
        }
    ?>
    <div class="top-more container-fluid">
        <div class="col-lg-12 col-md-12">
            <ul class="list-group">
                <li class="list-group-item big item1">
                    <h1 class="text-center">Property Records</h1></li>
                <li class="list-group-item">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Property name</th>
                                    <th>Address</th>
                                    <th>Owner</th>
                                    <th>Accomodation Type</th>
                                    <th>Property Status</th>
                                    <th>Options</th>
                                </tr>
                            </thead>
                            <tbody>

                            <?php 

                                    $query_all_property = $property_collection->find(array());
                                    if($query_all_property->count(true)) {

                                        foreach ($query_all_property as $row) {
                                           $app = $row['approved'];
                                           $accom = $row['accom_type'];
                                           if ($accom=="f") {
                                               $accom = "Girls";
                                           }
                                           else if ($accom == "b")  {
                                            $accom = "Boys/Girls";
                                           }
                                           else if($accom == "m")   {
                                            $accom = "Boys";
                                            
                                           }
                                           $qid = $row['_id'];
                                            echo ' <tr>
                                                        <td>'.$row['property_name'].'</td>
                                                        <td>'.$row['property_address'].'</td>
                                                        <td>'. $row['owner'].'</td>
                                                        <td>'.$accom.'</td>';
                                                        if($app=="0")   {
                                                           
                                                            echo'<td class="bg-danger"><span class="text-danger">Pending</span></td>';
                                                            echo'<td><a href="includes_admin/update_status_property.php?id=' .$qid .'&active=1" class="btn btn-success btn-xs">&nbsp Activate &nbsp&nbsp</a></td>';
                                                        }
                                                        else{
                                                             echo'<td class="bg-success"><span class="text-success">Active</span></td>';
                                                            echo'<td><a href="includes_admin/update_status_property.php?id=' .$qid .'&active=2" class="btn btn-danger btn-xs">Deactivate</a></td>';
                                                        }
                                                    echo '</tr>';
                                        }
                                    }


                                ?>
                               
                               
                            </tbody>
                            <caption>Based on last updation in the database.</caption>
                        </table>
                    </div>
                </li>
            </ul>
        </div>
    </div>


  <br>
  <br><br><br>
     <?php include "includes_admin/footer_admin.php"; ?>
