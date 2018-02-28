<?php include "includes/mongo_connection.php"; ?>
<?php include "includes/header.php"; ?>

<body>
  <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
     <script type="text/javascript">

        $(document).ready(function() {   
          
       $('.navbar').addClass('solid');
             
});
    </script>
    <br><br><br><br>
<?php
if(!isset($_GET['id'])){
    $userid = $_SESSION['_id'];
    header('location: /Rentfinder/includes/error.php?not=1');
    }
?>
  
<?php include "includes/navbar.php";?>


  <?php 
  ob_start();
if (isset($_SESSION['approved']) && $_SESSION['approved']=="0" && isset($_SESSION['account_type'])) {
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



  <?php
if(isset($_SESSION['account_type']) && $_SESSION['account_type']=="Landlord") {
  
}
else{
     echo'  <div class="container-fluid search_sec_1 ctn_cust_2">
    <form method="GET" action="search.php">
        <div class="input-group input-group-lg">
            <input class="form-control" type="text"  name="search_room" required="" placeholder="Search" autocomplete="on">
            <div class="input-group-btn">
                <button class="btn btn-primary" type="submit" name="search_native" >Search <i class="glyphicon glyphicon-search"></i></button>
            </div>
            </form>
        </div>


   ' ;   
}


  
?>

<?php
if (isset($_GET['id'])) {

    $id = new MongoId($_GET['id']);
    $mongo_object_property = $property_collection->find( array('_id' =>$id));
     
     if($mongo_object_property->count(true)) {

       foreach ($mongo_object_property as$row) {

            $property_name = $row['property_name'];
            $property_address = $row['property_address'];
            $owner = $row['owner'];
            $owner_id =$row['owner_id'];
            $starting_price = $row['starting_price'];
            $rooms_available = $row['rooms_available'];//array
            $room_types      = $row['room_types'];
            $facilities     = $row['facilities'];//array
            $room_prices    = $row['room_prices']; //array
            $meal          = $row['meal'];
            $description  = $row['description'];
            $app           = $row['approved'];
           
            $rules          = $row['rules'];
            $pictures       = $row['pictures'];

           $landlord = $landlord_collection->find( array('_id' => $owner_id ));
           if($landlord->count(true))   {
                foreach ($landlord as $row) {
                  $contact = $row['contact'];
                }
           }


       }

     }
}


if(isset($_GET['id']) && $app =="0")    {
    header("location: includes/error.php");
}

if(isset($_GET['schedule_done']))   {
    $id = new MongoId($_GET['id']);
     echo"<br><div class='container' style='margin-top:35px'><p class='bg-success' style='padding:5px'>Appointment has been set with Landlord &nbsp&nbsp $owner</p></div>";
     header("refresh:5; /Rentfinder/includes/reset_header.php?property_page=1&id=$id");
}
?>
           <div class="modal fade" role="dialog" tabindex="-1" id="call_modal">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                <h3 class="modal-title">Call Now</h3></div>
                            <div class="modal-body">
                                <p><h4><strong>Landlord</strong> <?php echo $owner; ?> : <?php echo $contact; ?></h4></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div>

    <section style="margin-top: 50px">
        <div class="container">
            <h1 class="text-left ht"> <?php echo"$property_name";?></h1>
            <div class="col-lg-9 col-lg-offset-0 col-lg-pull-0 col-md-12">

           
                <div class="carousel slide" data-ride="carousel" id="carousel-1">
                    <div class="carousel-inner" role="listbox">
                        <div class="item active"><img <?php echo "src='assets/img/$property_name/$property_name$pictures[0]'"; ?>alt="Slide Image" style="height: 500px"></div>
                        
                        <div class="item"><img <?php echo "src='assets/img/$property_name/$property_name$pictures[1]'"; ?>alt="Slide Image" style="height: 500px"></div>
                        
                        <div class="item"><img <?php echo "src='assets/img/$property_name/$property_name$pictures[2]'"; ?>alt="Slide Image" style="height: 500px"></div>
                    </div>
                    <div><a class="left carousel-control" href="#carousel-1" role="button" data-slide="prev"><i class="glyphicon glyphicon-chevron-left"></i><span class="sr-only">Previous</span></a><a class="right carousel-control" href="#carousel-1" role="button"
                        data-slide="next"><i class="glyphicon glyphicon-chevron-right"></i><span class="sr-only">Next</span></a></div>
                    <ol class="carousel-indicators">
                        <li data-target="#carousel-1" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-1" data-slide-to="1"></li>
                        <li data-target="#carousel-1" data-slide-to="2"></li>
                    </ol>
                </div>
                <div class="well well-lg mov_dwn">
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <h1 class="text-left">Description </h1>
                            <h4 class="text-left"><?php echo "$property_address";?></h4></div>
                        <div class="col-lg-6 col-md-12">
                            <h1 class="text-right text-primary"><?php echo "$starting_price"; ?> INR</h1>
                            <h4 class=" text-right text-success">Number of availability of Rooms:</h4></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-9 col-md-12">
                            <div class="row">
                            <?php

                                echo($description['attached_bath']=="1"? '<div class="col-lg-4 col-md-12"><span><i class="glyphicon glyphicon-fire"></i> Attached Toilet</span></div>' : '');
                                echo($description['tv']=="1"? '<div class="col-lg-4 col-md-12"><span><i class="fa fa-television"></i> TV</span></div>':'');
                                echo($description['ac']=="1"? '<div class="col-lg-4 col-md-12"><span><i class="material-icons" style="font-size:15px ">ac_unit</i> AC</span></div>':'');
                                echo($description['bedding']=="1"? '<div class="col-lg-4 col-md-12"><span><i class="fa fa-bed"></i> Bedding</span></div>':'');
                                echo($description['tnc']=="1"? '<div class="col-lg-4 col-md-12"><span><i class="glyphicon glyphicon-fire"></i> Table Chair</span></div>':'');
                                echo($description['wifi']=="1"? '<div class="col-lg-4 col-md-12"><span><i class="fa fa-wifi"></i> WIFI</span></div>':'');
                                ?>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-12 cust_col">
                            <button class="btn btn-primary btn-lg cust_call" type="button" data-toggle="modal" data-target="#call_modal">Call Landlord</button>
                        </div>
                    </div>
                </div>

      

                <div>
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab-11" role="tab" data-toggle="tab">Rooms </a></li>
                        <li><a href="#tab-22" role="tab" data-toggle="tab">Ameneties </a></li>
                        <li><a href="#tab-33" role="tab" data-toggle="tab">Meals </a></li>
                        <li><a href="#tab-44" role="tab" data-toggle="tab">House Rules</a></li>
                        <li><a href="#tab-55" role="tab" data-toggle="tab">Photos </a></li>
                    </ul>


                    <div class="tab-content">
                        <div class="tab-pane active" role="tabpanel" id="tab-11">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="well">
                                        <h4 class="text-nowrap text-left">Room Details</h4>


                                        <h5 class="text-nowrap text-left text-success"><strong>

                                        <?php
                                          $str_type = "";
                                          $temp = explode(",", $room_types);
                                          foreach ($temp as $t) {
                                                $t=ucfirst($t);
                                                $str_type.= $t . " | ";
                                               
                                               
                                           } 
                                            $str_type = substr($str_type, 0,-2);
                                           $str_type.=" Occupancies";
                                           echo "$str_type";
                                        
                                        ?>

                                        </strong></h5>

                                       <p class="text-left well">The following property is verified by the officials of rentfinder. Any kind of descripency is found in the property should directly be reported to the owner. </p>

                                        
                                        <h5 class=" text-left text-info"><strong>Terms &amp; conditions of House indivually Applied.</strong></h5>


                                     
                                        <h3 class="text-nowrap bg-info">ROOMS </h3>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tbody>

                                                   <?php

                                                    
                                                    $i=0;
                                                    
                                                     foreach ($rooms_available as $room) {
                                                        if($i==0)
                                                        {echo " <tr>";
                                                        }
                                                        
                                                        echo'<td><span><strong>Room:'.$room[0]["number"].'<span class="text-success"><br><strong>Available: '.$room[0]["seats"].'</strong></span>
                                                            
                                                                </span>
                                                        </td>';
                                                        
                                                        $i++;
                                                        if($i==4)   {
                                                            echo " </tr>";
                                                            $i=0;
                                                        }

                                                    }
                                                   ?>
                                                  
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="tab-pane" role="tabpanel" id="tab-22">
                            <div class="well">
                                <h4 class="text-nowrap text-left">Facilities Available</h4>
                                <ul class="list-group">



                                <?php
                                    foreach ($facilities as $fac) {
                                       echo' <li class="list-group-item">
                                        <h4 class="text-left">'.$fac.'</h4></li>';
                                    }

                                ?>
                                </ul>
                            </div>
                        </div>
                        <div class="tab-pane" role="tabpanel" id="tab-33">
                            <div class="well">
                                <h4 class="text-left">Meals Available &amp; Timing</h4>


                                <?php
                                   if($meal!=0) {
                                    
                                    while($element = current($meal)) {
                                             $extracted_meal_key = key($meal);
                                             next($meal);
                                             if($extracted_meal_key =="b"){
                                                $key = "Breakfast";
                                             }
                                             elseif ($extracted_meal_key == "l") {
                                                $key = "Lunch";
                                             }
                                            elseif ($extracted_meal_key == "d"){
                                                $key = "Dinner";
                                            }
                                              echo'<h5 class="text-left">'.$key.' : '.$meal[$extracted_meal_key].'</h5>';
                                            }
                                         }

                                   
                                ?>
                               

                                
                            </div>
                        </div>
                        <div class="tab-pane" role="tabpanel" id="tab-44">
                            <div class="well">
                            <?php

                            if($rules==0)   {
                                echo'<h4 class="text-left">No Specified Rules</h4>';
                            }

                            else{
                                echo'<h4 class="text-left">House Rules (To be followed by every Individual Tenant)</h4>';
                                foreach ($rules as $r) {
                                echo'<h5 class="text-left">'.$r.'</h5>';
                                }

                            }
                            ?></div>
                                
                        </div>
                        <div class="tab-pane" role="tabpanel" id="tab-55">
                            <div class="well">
                                <h4 class="text-left">Property Photos</h4>


                                <?php
                                ?>
                                <div class="row">
                                <?php

                                    for ($i=0; $i <count($pictures) ; $i++) { 
                                       echo '<div class="col-lg-4 col-md-12">
                                        <div class="thumbnail"><img style="width:250px; height:150px" src=\'assets/img/'.$property_name.'/'.$property_name.$pictures[$i].'\'; ></div>
                                        </div>';
                                    }
                                ?>

                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" role="tabpanel" id="tab-3">
                            <p>Tab content.</p>
                        </div>
                    </div>
                </div>
            </div>

            <?php
             if(isset($_SESSION['account_type']) && $_SESSION["account_type"] == "Landlord")    {

                $fetch_appointments  = $scheduled_collection->find(array("property_id"=>$id));

                echo'<div class="col-lg-3 col-md-12">
                <div>
                    <ul class="nav nav-tabs">
                        <li class="active"><a class="text-info" href="#tab-1" role="tab" data-toggle="tab">Appointments</a></li>
                        <li><a class="text-primary" href="#tab-2" role="tab" data-toggle="tab">Tenants Staying</a></li>
                    </ul>
                    <div class="tab-content">
                    
                        <div class="tab-pane active" role="tabpanel" id="tab-1">';

                    echo '<br>
                    <small class="help-block ">The information displayed are based on last appointment applied.</small>
                    <table class="table table-striped table-hover">
                              <thead>
                                 <tr>
                                    <th>Name</th>
                                    <th>Contact</th>
                                    <th>Date</th>
                                    <th>Time</th>       
                                </tr>
                            </thead>
                            <tbody style="font-size:10px; font-weight:bold">
                            ';
                            if($fetch_appointments->count(true))    {
                                foreach ($fetch_appointments as $row) {
                                   $name      = $row['name'];
                                   $phno      = $row['phno'];
                                   $date      = date('d-m-y', $row['date']->sec);
                                   $timing    = $row['timing'];
                                   echo '

                                        <tr>
                                        <td>'. $name .'</td>
                                        <td>' .$phno. '</td>
                                        <td>'.$date.'</td>
                                        <td>'.$timing.'</td>

                                        </tr>

                                       ';
                                }
                            

                            }
                            else{
                                echo "Empty";
                            }
                            echo '</tbody> </table>';
                       echo' </div>
                        <div class="tab-pane" role="tabpanel" id="tab-2">';
                           
                        
                           if(!isset($_SESSION["name"]))  {
                            echo '<br><a href="includes/login_form.php" >Login</a> or <a href="includes/register_student.php" >Register</a>' ;
                           }

                           else{

                            echo' Nothing to show';
                           }
                        }

             else if(isset($_SESSION['account_type']) && $_SESSION["account_type"] == "Tenant")    {
            echo'<div class="col-lg-3 col-md-12">
                <div>
                    <ul class="nav nav-tabs">
                        <li class="active"><a class="text-info" href="#tab-1" role="tab" data-toggle="tab">Schedule A Visit</a></li>
                        <li><a class="text-primary" href="#tab-2" role="tab" data-toggle="tab">Book Now</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" role="tabpanel" id="tab-1">
                            <form id="scheduled" method="POST" action="includes/schedule_appointment.php?id='.$_GET['id'].'&landlord='.$owner_id.'">
                                <input class="form-control cust_int" type="text" required="" placeholder="Name" name="name" value="'.$_SESSION['name'].'">
                                <input class="form-control cust_int" type="email" required="" placeholder="Email" name="email">
                                <input class="form-control cust_int" type="text" required="" placeholder="Phone Number" name="ph_no">
                                <input class="form-control cust_int" type="date" name="date" min="'.date("Y-m-d").'">
                              <center>  <select class="form-control cust_int" name="hr">
                                    <optgroup label="Hours">
                                        <option value="Hrs" selected="">Hrs</option>';
                                       for ($i=8; $i <18 ; $i++) { 
                                            echo'<option value="'. ($i+1). '">'. ($i+1) .'</option>';
                                            if($i+1 == 9){
                                                echo'<option selected="" value="'. ($i+1). '">'. ($i+1) .'</option>';
                                            }
                                        }
                                       
                                    echo'</optgroup>
                                </select>
                                <select class="form-control cust_int_2" name="min">
                                    <optgroup label="Mins">
                                        <option value="Mins" selected="">Mins</option>';
                                       for ($i=0; $i <60 ; $i++) { 
                                            echo'<option value="'. ($i+1). '">'. ($i+1) .'</option>';
                                            if($i+1 == 30){
                                                echo'<option selected="" value="'. ($i+1). '">'. ($i+1) .'</option>';
                                            }
                                        }
                                       
                                    echo'</optgroup>
                                </select></center>
                                <button class="btn btn-warning btn-lg btn_schedule" type="submit" name="schedule">Schedule </button>
                            </form>
                        </div>
                        <div class="tab-pane" role="tabpanel" id="tab-2">';
                           
                        
                           if(!isset($_SESSION["name"]))  {
                            echo '<br><a href="includes/login_form.php" >Login</a> or <a href="includes/register_student.php" >Register</a>' ;
                           }

                           else{

                            echo' <form id="booking" method="post" action="includes/make_payment.php?id='.$_GET['id'].'">
                                <input class="form-control cust_int" type="date" required="" placeholder="Moving in Date" name="date" min="'.date("Y-m-d").'">
                                <input class="form-control cust_int" type="text" required="" name="name" placeholder="Name" value="'.$_SESSION["name"] .'">
                                <input class="form-control cust_int" type="text" required="" name="registration" placeholder="Registration Number" value="'.$_SESSION["registration"].'">
                                <input class="form-control cust_int" type="text" required="" placeholder="Phone Number" name="ph_no">
                                <input class="form-control cust_int" type="text" required="" placeholder="Room Number" name="room_no">
                                <button class="btn btn-success btn-lg btn_schedule" type="submit" name="pay">Make Payment</button>
                            </form>';
                           }
                        }


                        else {
            echo'<div class="col-lg-3 col-md-12">
                <div>
                    <ul class="nav nav-tabs">
                        <li class="active"><a class="text-info" href="#tab-1" role="tab" data-toggle="tab">Schedule A Visit</a></li>
                        <li><a class="text-primary" href="#tab-2" role="tab" data-toggle="tab">Book Now</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" role="tabpanel" id="tab-1">
                            <form id="appointment" method="post" action="includes/schedule_appointment.php?id='.$_GET['id'].'&landlord='.$owner_id.'">
                                <input class="form-control cust_int" type="text" required="" placeholder="Name" name="name">
                                <input class="form-control cust_int" type="email" required="" placeholder="Email" name="email">
                                <input class="form-control cust_int" type="text" required="" placeholder="Phone Number" name="ph_no">
                                <input class="form-control cust_int" type="date" name="date" min="'.date("Y-m-d").'">
                                <center> <select class="form-control cust_int" name="hr">
                                    <optgroup label="Hours">
                                        <option value="Hrs" selected="">Hrs</option>';
                                       for ($i=8; $i <18 ; $i++) { 
                                            echo'<option value="'. ($i+1). '">'. ($i+1) .'</option>';
                                            if($i+1 == 9){
                                                echo'<option selected="" value="'. ($i+1). '">'. ($i+1) .'</option>';
                                            }
                                        }
                                       
                                    echo'</optgroup>
                                </select>
                                <select class="form-control cust_int_2" name="min">
                                    <optgroup label="Mins">
                                        <option value="Mins" selected="">Hrs</option>';
                                        for ($i=0; $i <60 ; $i++) { 
                                            echo "<option value=$i>$i</option>";
                                            if($i+1 == 30){
                                                echo'<option selected="" value="'. ($i+1). '">'. ($i+1) .'</option>';
                                            }
                                        }
                                       
                                        
                                    echo'</optgroup>
                                </select></center>
                                <button class="btn btn-warning btn-lg btn_schedule" type="submit" name="schedule">Schedule </button>
                            </form>
                        </div>
                        <div class="tab-pane" role="tabpanel" id="tab-2">';
                           
                        
                           if(!isset($_SESSION["name"]))  {
                            echo '<br><div class="text-center"><a href="includes/login_form.php" >Login</a> or <a href="includes/register_student.php" >Register</a></div>' ;
                           }

                           else{

                            echo' <form id="booking">
                                <input class="form-control cust_int" type="date" required="" placeholder="Moving in Date" name="date" min="'.date("Y-m-d").'">
                                <input class="form-control cust_int" type="text" required="" placeholder="Name" value='.$_SESSION["name"] .'>
                                <input class="form-control cust_int" type="text" required="" placeholder="Registration Number" value='.$_SESSION["registration"].'>
                                <input class="form-control cust_int" type="text" required="" placeholder="Phone Number">
                                <input class="form-control cust_int" type="text" required="" placeholder="Room type">
                                <button class="btn btn-success btn-lg btn_schedule" type="submit" name="book">Make Payment</button>
                            </form>';
                           }
                        }

                           ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    </div>
    
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>

</div>

<?php include "includes/footer.php";?>