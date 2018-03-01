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
                    <h1 class="text-center">Landlord Records</h1></li>
                <li class="list-group-item">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Occupation</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>Address</th>
                                    <th>Account Status</th>
                                    <th>Options</th>
                                </tr>
                            </thead>
                            <tbody>

                            <?php 

                                    $query_all_landlord = $landlord_collection->find(array());
                                    if($query_all_landlord->count(true)) {

                                        foreach ($query_all_landlord as $row) {
                                           $app = $row['approved'];
                                           $qid = $row['_id'];
                                            echo ' <tr>
                                                        <td>'.$row['name'].'</td>
                                                        <td>'.$row['occupation'].'</td>
                                                        <td>'. $row['email'].'</td>
                                                        <td>'. $row['contact'].'</td>
                                                        <td>'.$row['permanent_add'].'</td>
                                                         <td>'.$row['approved'].'</td>';

                                                        if($app=="0")   {
                                                           
                                                            echo'<td class="bg-danger"><span class="text-danger">Pending</span></td>';
                                                            echo'<td><a href="includes_admin/update_status_landlord.php?id=' .$qid .'&active=1" class="btn btn-success btn-xs">&nbsp Activate &nbsp&nbsp</a></td>';
                                                        }
                                                        else{
                                                             echo'<td class="bg-success"><span class="text-success">Active</span></td>';
                                                            echo'<td><a href="includes_admin/update_status_landlord.php?id=' .$qid .'&active=2" class="btn btn-danger btn-xs">Deactivate</a></td>';
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

  
     <?php include "includes_admin/footer_admin.php"; ?>