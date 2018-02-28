<?php include "includes/mongo_connection.php";?>
<?php include "includes/header.php"; ?>
<body>

<?php
if(!isset($_GET['user_id'])){
   
    header('location: /Rentfinder/includes/error.php?not=1');
    }
?>
<script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
     <script type="text/javascript">
        $(document).ready(function() {
     $('.navbar').addClass('solid');
});
    </script>

<?php include "includes/navbar.php";?>


<?php 
if ($_SESSION['approved']=="0") {
    echo "echo <script type='text/javascript'> $(window).load(function(){ $('#approval_modal').modal('show'); }); </script>";

    echo '  <div class="modal fade" role="dialog" tabindex="-1" id="approval_modal" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                
                                <h2 class="modal-title text-center text-danger">Account Approval Pending!</h2></div>
                            <div class="modal-body">
                                <p><h4>Oops! Looks like your account has not been approved by the admin yet, please try again later.</h4><br>
                                    <center><a class="btn btn-danger" href="includes/logout.php">Click to Logout</a></center></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div>';
}
?>
    <div class="container" style="margin-top: 100px">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2 class="text-nowrap "><i class="fa fa-building"></i>Property of User</h2>
                <p class="help-block">The information displayed are based on last updations done.</p>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-hover">


                        <thead>
                            <tr>
                                <th>Property Name</th>
                                <th>Date Created</th>
                                <th> </th>
                            </tr>
                        </thead>
                         <tbody>

                        <?php
                            if (isset($_GET['user_id'])) {
                               $property_search_query = $property_collection->find(array('owner_id' =>$_SESSION['_id'])) ;
                               if($property_search_query->count(true))  {

                                foreach ($property_search_query as $row ) {
                                    $property_id   = $row['_id'];
                                    $property_name = $row['property_name'];
                                    $date_created  = $row['date_created'];
                                    $app           = $row['approved'];
                                    $date =date("d-m-y",$date_created->sec);
                                    echo' <tr>
                                            <td>'.$property_name.'</td>
                                            <td>'.$date.'</td>
                                             <td><a class="btn btn-warning" role="button" href="update_property.php?id='.$property_id.'&update=0">Update Information</a></td>';
                                             if($app =="1") {
                                                 echo'<td><a class="btn btn-primary" role="button" href="property_page.php?id='.$property_id.'">View Information</a></td>
                                         </tr>';
                                             }
                                             else{
                                                 echo'<td><a class="btn btn-primary " disabled="disabled" role="button" >View Information</a></td>
                                         </tr>';
                                             }
                                           
                                }
                               }
                            }
                        ?>
                         </tbody>
                       
                           




                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <br>
    <br><br><br>
<?php include "includes/footer.php";?>