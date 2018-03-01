<?php include "../includes/mongo_connection.php";?>
<?php include "includes_admin/header_admin.php"; ?>
    
    <?php include "includes_admin/navigation_admin.php";?>
    <?php 
    
        if($_SESSION['account_type']!="Admin")   {
            header("location:/Rentfinder/includes/error.php?not=1");
        }
    ?>
    <div class="container top-sh">
       
            <section>
            <div class="row re">
                <div class="col-lg-6 col-md-6 ">
                    <h1 class="cust_name"> <?php echo $_SESSION['name']; ?></h1></div>
                <div class="col-lg-6 col-md-6 ">
                    <h3 class="text-right cust_day"> <span class="span_1"><?php echo date("l")?> </span><span class="span_1"><?php echo date("d-m-Y");?></span></h3></div>
            </div>
        </section>


       </div>
    </div>
   <br>
        <section>

        <div class="container">
                <div class="col-lg-6 col-md-6 col-sm-6 hidden-sm hidden-xs">

                <?php
                    $query_landlords = $landlord_collection->count();
                    $query_students  = $student_collection->count();
                     $query_property  = $property_collection->count();
                     $query_admin  = $admin_collection->count();
                     $query_students_active =$student_collection->count(array("approved"=>"1"));
                     $query_landlord_active =$landlord_collection->count(array("approved"=> "1"));
                     $query_property_active =$property_collection->count(array("approved"=>"1"));
                   
                    $query_students_pending = $query_students - $query_students_active;
                    
                    $query_landlord_pending = $query_landlords- $query_landlord_active;
                    $query_property_pending = $query_property - $query_property_active;                      


                ?>

                   
                     

        <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Data', 'Count'],
          ['Tenants',    <?php echo $query_students; ?>],
          ['Landlords',      <?php  echo $query_landlords;?>],
          ['Properties',  <?php echo $query_property; ?>],
          ['Admin',  <?php echo $query_admin; ?>]
          
        ]);


        var options = {
          title: 'System database overview',
          slices: {0: {color: '#00a5db'}, 1:{color: '#f96b07'}, 2:{color: '#00b760'}, 3:{color:'#fcbf49'}}
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>





                       <div id="piechart"  style=" height: 300px;"></div>

                      



                </div>
                

                 <div class="col-lg-6 col-md-6 col-sm-6 hidden-sm hidden-xs">

                
  
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Entities in database', 'Total', 'Active', 'Inactive'],
          ['Tenant', <?php echo $query_students; ?>, <?php echo $query_students_active; ?> , <?php echo $query_students_pending; ?> ],
          ['Landlord', <?php echo $query_landlords; ?>, <?php echo $query_landlord_active; ?> , <?php echo $query_landlord_pending; ?> ],
          ['Property', <?php echo $query_property; ?>, <?php echo $query_property_active; ?> , <?php echo $query_property_pending; ?> ],
          ['Admin', <?php echo $query_admin; ?>, <?php echo $query_admin; ?> , 0]
        ]);

        var options = {
          chart: {
            title: 'Database Analytics',
            subtitle: 'Data, Active, Inactive : Tenant, Landlord, Property',

          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
  
                 <div id="columnchart_material" style="width: 500px; height: 300px;"></div>
 

                 </div>



        </div>



        </section>

       
        
    

    <div class="container "> 
            <div class="col-lg-12">
                <hr style="border-top-color: rgb(191,180,180)" />
            </div>
    </div>

    <div class="container">
        <div class="col-lg-4 col-md-4 col-sm-4">
            <ul class="list-group">
                <li class="list-group-item item1"><span class="big"><strong>DashBoard </strong></span></li>
                <li class="list-group-item hove"><a href="admin_tenant_view.php" class="item2" style="text-decoration:none;"><span>Tenant's Database</span></a></li>
                <li class="list-group-item hove"><a href="admin_landlord_view.php" class="item2" style="text-decoration:none;"><span>Landlord's Database</span></a></li>
                <li class="list-group-item hove"><a href="admin_property_view.php" class="item2" style="text-decoration:none;"><span>All Properties Registered</span></a></li>
                <li class="list-group-item hove"><a href="#" class="item2" style="text-decoration:none;"><span>Pending Properties</span></a></li>
                
            </ul>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8">
            <ul class="list-group">
                <li class="list-group-item item1"><span class="big">Recently Added Properties</span></li>
                <li class="list-group-item">
                    <div class="table-responsive">
                        <table class="table table-hover table-condensed">
                            <thead>
                                <tr>
                                    <th>Property Name</th>
                                    <th>Landlord </th>
                                    <th>Status </th>
                                </tr>
                            </thead>
                            <tbody><?php 
                                            $query_property_recent = $property_collection->find()->sort(array('date_created'=> -1))->limit(3);

                                            if($query_property_recent->count(true)) {
                                                foreach ($query_property_recent as $row) {

                                                    $property_name = $row['property_name'];
                                                    $owner         = $row['owner'];
                                                    $status        = $row['approved'];
                                                    echo '<tr>
                                                          <td>'.$property_name.'</td>
                                                          <td>'.$owner.'</td>';
                                                            if($status== "1")
                                    echo'<td> <span class="label label-success" role="button" >&nbspActive&nbsp</span></td></tr>';
                                                            else
                                    echo'<td> <span class="label label-danger" role="button" >&nbspInctive&nbsp</span></td></tr>';
                                                }

                                                   
                                            }

                                        ?>
                                
                            </tbody>
                            <caption>The information is based on last updations in the database.</caption>
                        </table>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <div class="container">
        <div class="panel panel-default">
            <div class="panel-body pan_body">
                <div class="col-lg-4">
                    <div class="well well-lg cust_well_admin">
                        <h1> <i class="glyphicon glyphicon-user"></i> Landlords <?php echo $query_landlords; ?></h1></div>
                </div>
                <div class="col-lg-4">
                    <div class="well well-lg cust_well_admin">
                        <h1> <i class="fa fa-user ico-big"></i> Tenants <?php echo $query_students;?></h1></div>
                </div>
                <div class="col-lg-4">
                    <div class="well well-lg cust_well_admin">
                        <h1> <i class="glyphicon glyphicon-home"></i> Properties <?php echo $query_property; ?></h1></div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <ul class="list-group">
            <li class="list-group-item item1"><span class="big"> <i class="fa fa-user"></i> Recent Tenants Registered </span><a href="#" class="xs-big color_href">View All Records</a></li>
            <li class="list-group-item">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name </th>
                                <th>Email </th>
                                <th>University </th>
                                <th>Account Status</th>
                            </tr>
                        </thead>
                        <tbody>
                                <?php

                                     $query_tenant_recent = $student_collection->find()->sort(array('date_created'=> -1))->limit(3);

                                            if($query_tenant_recent->count(true)) {
                                                foreach ($query_tenant_recent as $row) {
                                                        $university = $row['university'];
                                                        $app =$row['approved'];
                                                        if($university=="") {
                                                            $university = "Not Specified";
                                                        }
                                                    echo'
                                                     <tr>
                                                        <td>'.$row['name'].'</td>
                                                        <td>'.$row['email'].'</td>
                                                        <td>'.$university.'</td>';
                                                          if($app == '0')  {
                                                        echo'<td class="bg-danger">Pending</td>'; 
                                                        }
                                                        else{
                                                             echo'<td class="bg-success">Approved</td>';
                                                        } 
                                                   echo' </tr>';
                                                }
                                            }
                                ?>

                           
                            
                        </tbody>
                    </table>
                </div>
            </li>
        </ul>
    </div>
    <div class="container">
        <ul class="list-group">
            <li class="list-group-item item1"><span class="big"><i class="glyphicon glyphicon-user"></i> Recent Landlords Registered<a href="#" class="xs-big color_href"> View All Records</a></span></li>
            <li class="list-group-item">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name </th>
                                <th>Email </th>
                                <th>Occupation</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php

                                     $query_landlord_recent = $landlord_collection->find()->sort(array('date_created'=> -1))->limit(3);

                                            if($query_landlord_recent->count(true)) {
                                                foreach ($query_landlord_recent as $row) {
                                                        $app =$row['approved'];
                                                    echo'
                                                     <tr>
                                                        <td>'.$row['name'].'</td>
                                                        <td>'.$row['email'].'</td>
                                                        <td>'.$row['occupation'].'</td>';

                                                         if($app == '0')  {
                                                        echo'<td class="bg-danger">Pending</td>'; 
                                                        }
                                                        else{
                                                             echo'<td class="bg-success">Approved</td>';
                                                        } 
                                                   echo' </tr>';
                                                }
                                            }
                                ?>

                        </tbody>
                    </table>
                </div>
            </li>
        </ul>
    </div>
    
     <?php include "includes_admin/footer_admin.php"; ?>