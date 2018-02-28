<?php include "includes/mongo_connection.php";?>
<?php include "includes/header.php";  ?>

<body>
<script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
     <script type="text/javascript">
        $(document).ready(function() {
     $('.navbar').addClass('solid');
});
    </script>

<?php include "includes/navbar.php" ?>

<?php
if($_SESSION['account_type']=="" || $_SESSION['account_type'] =="Admin" || $_SESSION['account_type']=="Tenant") {

    header("location:/Rentfinder/includes/error.php");
}

?> 
    <section style="margin-top:100px">
        <div class="container">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2><i class="fa fa-building"></i> Property Information</h2>
                </div>

                <div class="panel-body">

                <?php

                        if($_GET['update'] ==1) {
                            echo"<p class='bg-success' style='padding:5px'>Property Information Updated&nbsp&nbsp&nbsp&nbsp&nbsp<a class='text-success'  href='property_page.php?id=".$_GET['id']."'>View Property</a>&nbsp&nbsp&nbsp&nbsp<a href='list_property.php?user_id=".$_SESSION['_id']."'>View all properties</a></p>";
                               $property_id = $_GET['id'];
                                    header("refresh: 6; /Rentfinder/includes/reset_header.php?id=$property_id&update=1   ");
                                   
                         
                         
                        }
                ?>

                    <div class="alert alert-warning ">
                        <h4 class="text-center text-warning">Important Notice</h4>
                        <p class="text-center text-muted">Please provide valid information. Any information which found faulty later might lead to case of fraudency which may lead to permanent blocking of your account. </p>
                    </div>

                    <div class="col-lg-8 col-lg-offset-2 col-md-12">

                         <?php
                    //fetching query

                    if (isset($_GET['id'])) {
                            
                            $property_id_by_link = $_GET['id'];

                            $property_fetch_query = $property_collection->find(array("_id" => new MongoId($property_id_by_link)));
                            if($property_fetch_query->count(true))  {

                               foreach ($property_fetch_query as $row) {
                                   $property_name = $row['property_name'];
                                   $property_address = $row['property_address'];
                                   $accom_type  =$row['accom_type'];
                                   $owner      =$row['owner'];
                                   $owner_id = $row['owner_id'];
                                   $starting_price = $row['starting_price'];
                                   $rooms_available = $row['rooms_available'];
                                   $room_types = $row['room_types'];
                                   $room_prices = $row['room_prices'];
                                   $description = $row['description'];
                                   $facilities = $row['facilities'];
                                   $meal = $row['meal'];
                                   $pictures=$row['pictures'];
                                   $rules= $row['rules'];

                                  

                                   echo'  <form id="frmProduct" method="post" enctype="multipart/form-data" action="includes/update_property_info.php?id='.$property_id_by_link.'">

                            <div class="form-group">


                                <input class="form-control padd-input" type="text"  name="property_name" required="" placeholder="Property name" autocomplete="on" value="'. $property_name .'"/>
                                <input class="form-control padd-input" type="text" name="property_address" required="" placeholder="Property address" autocomplete="on" value="'.$property_address .'"/>
                                <input class="form-control padd-input" type="text" required="" name="owner_name" placeholder="Owner name" autocomplete="on" value="'.$owner.'" readonly/>
                                <input class="form-control padd-input" type="text" required="" name="starting_price" placeholder="Default starting price" autocomplete="on" value="'.$starting_price.'" maxlength="6" pattern="\d*"/>
                                <div class="row text-center">

                                <div class="row text-center">
                                    <div class="col-lg-6 col-lg-offset-1 col-md-12 pad-accom">
                                        <label class="control-label"> Accomodation Specific to:</label>
                                    </div>
                                    <div class="col-lg-4 col-md-12">
                                        <div class="form-group">

                                        <select class="form-control" required="" name="accom_type">
                                            <optgroup label="Select Gender" ">
                                                <option value="m"';

                                                if($accom_type == "m")
                                                 {echo' selected="selected"';
                                                 }
                                                  echo'>Boy</option>

                                                <option value="f"';
                                                  if($accom_type == "f")
                                                 {echo'selected="selected"';}
                                                echo '>Girl</option>

                                                <option value="b" ';
                                                if($accom_type=="b") {
                                                    echo'selected="selected"';
                                                }
                                                echo'>Both</option>
                                            </optgroup>
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="text-center">
                            <center> <button class="btn btn-warning visible-xs-block  visible-sm-inline visible-md-inline visible-lg-inline" type="submit" value="submit" name="submit_info">Update Information</button>
                             &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                              <button class="btn btn-danger visible-xs-block  visible-sm-inline visible-md-inline visible-lg-inline" type="submit" value="reset" name="reset_info">Reset Information</button></center>
                              </div>

                           </form>
                        
                    </div>
                </div>
            </div>

        </div>
    </div>

        <div class="container">
            
            <h1> <i class="fa fa-lightbulb-o"></i> <i class="fa fa-bed"></i> <i class="material-icons">ac_unit</i> <i class="fa fa-wifi"></i> <i class="fa fa-ambulance"></i> Facilities Available
            </h1>

             <div class="panel panel-default">
                
                
                    <div class="panel-body">


                     <p class="help-block text-center"><strong>Facilities Mentioned here will be visible to users visiting you property page.</strong></p>

                    <div class="col-lg-8 col-lg-offset-2 col-md-12">
                        
                        <form id="checkboxes" method="post" action="includes/update_property_checkboxes.php?id='.$property_id_by_link.'">

                        <div class="form-group">
                        
                               <div class="row">
                                    <div class="col-md-12">
                                        <h3 class="bg-primary">Basic Facilities</h3>
                                    </div>
                                    <div class="col-lg-3 col-md-12">
                                        <div class="checkbox">
                                            <label class="control-label">
                                            
                                                <input type="checkbox" name="bath" '; echo ($description["attached_bath"]== "1" ? 'checked' : '');
                                                echo'/><strong> Attached Bathroom</strong></label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-12">
                                        <div class="checkbox">
                                            <label class="control-label">
                                                <input type="checkbox" name="air_con" '; echo($description["ac"]== "1"? 'checked' : '');
                                                echo'/><strong> Air Conditioner</strong></label>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-12">
                                        <div class="checkbox">
                                            <label class="control-label">
                                                <input type="checkbox" name="television"'; echo($description["tv"]=="1"? 'checked' : '');
                                                echo'/><strong> TV</strong></label>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-12">
                                        <div class="checkbox">
                                            <label class="control-label">
                                                <input type="checkbox" name="bed"'; echo($description["bedding"]=="1"? 'checked' : '');
                                                echo'/><strong> Bedding</strong></label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-lg-offset-3 col-md-12">
                                        <div class="checkbox">
                                            <label class="control-label">
                                                <input type="checkbox" name="tnc"'; echo($description["tnc"]=="1"? 'checked' : '');
                                                echo'/><strong> Table / Chair</strong></label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-12">
                                        <div class="checkbox">
                                            <label class="control-label">
                                                <input type="checkbox" name="wifi" '; echo($description["wifi"]=="1"? 'checked' : '');
                                                echo'/><strong> Wifi</strong></label>
                                        </div>
                                    </div>
                                </div>
                                <br>

                                 <div class="text-center">
                            <center> <button class="btn btn-warning visible-xs-block  visible-sm-inline visible-md-inline visible-lg-inline" type="submit" value="submit" name="submit_check">Update Facilities</button>
                             &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                              <button class="btn btn-danger visible-xs-block  visible-sm-inline visible-md-inline visible-lg-inline" type="submit" value="reset" name="reset_check">Reset Facilities</button></center>
                              </div>

                        </form>

                        <form id="facilities-described" method="POST" action="includes/update_property_facilities.php?id='.$property_id_by_link.'">

                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 class="bg-primary">Facilities described</h3>
                                        </div>
                                </div>

                                    
                               <div id="fac">
                                <p class="help-block text-center">This information is based on last updations in database.</p>';

                                    if(!empty($facilities))
                                    {
                                        $n = count($facilities);

                                        for ($i=0; $i <$n ; $i++) { 
                                            echo'
                                              <div class="well" style="clear:both;">
                                                 <div class="row">
                                                 <div class="col-lg-2 col-sm-1 col-xs-3 padder-col " style="font-size:20px;">
                                                <a href="includes/delete_property_facilities.php?id='.$property_id_by_link.'&facility='.$facilities[$i].'" class="text-danger btn btn-default">
                                                <span class="fa fa-trash" style="display:inline-block"></span>&nbsp<span class="hidden-xs">Delete</span>
                                                </a>
                                                 </div>

                                            <div class="col-lg-9 col-lg-offset-1 col-md-9 col-md-offset-2 col-sm-11 col-xs-9">
                                            <input class="form-control" type="text" placeholder="Describe facility" name="faci_name[]" value="'. $facilities[$i] .'"/></div></div></div>

                                            ';
                                        }
                                         
                                }
                                        
                                        echo'
                                    </div>

                                </div>

                                 <p class="help-block text-center">Add new facility information</p>
                                 <div class="facility-item well" style="clear:both;">
                                    <div class="row">
                                        
                                        <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-12 col-xs-12">
                                            <input class="form-control" type="text" placeholder="Describe new facility" name="new_faci_name"  />
                                        </div>
                                    </div>

                                </div>

                                 <div class="text-center">
                             <center><button class="btn btn-warning visible-xs-block visible-sm-inline visible-md-inline visible-lg-inline" type="submit" value="submit" name="submit_faci">Update Descriptions</button>
                             &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                              <button class="btn btn-primary visible-xs-block visible-sm-inline visible-md-inline visible-lg-inline" type="submit" value="submit" name="add_faci">Add New Descriptions</button></center>
                              </div>


                               </form>

                               <form id="meal" method="POST" action="includes/update_property_meals.php?id='.$property_id_by_link.'">

                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 class="bg-warning">Meal (optional)</h3>
                                        </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-5 col-lg-offset-1 col-md-12 padd">
                                        <label class="control-label">Breakfast Timing</label>
                                    </div>
                                    <div class="col-lg-6 col-lg-offset-0 col-md-12">
                                        <select class="form-control" name="breakfast">
                                            <optgroup label="This is a group">
                                                <option value="7:00 AM"';echo($meal["b"]=='7:00 AM'? 'selected="selected"' : '');echo'>7:00AM</option>
                                                <option value="7:30 AM"';echo($meal["b"]=='7:30 AM'? 'selected="selected"' : '');echo'>7:30AM</option>
                                                <option value="8:00 AM"';echo($meal["b"]=='8:00 AM'? 'selected="selected"' : '');echo'>8:00AM</option>
                                                <option value="8:30 AM"';echo($meal["b"]=='8:30 AM'? 'selected="selected"' : '');echo'>8:30AM</option>
                                                <option value="9:00 AM"';echo($meal["b"]=='9:00 AM'? 'selected="selected"' : '');echo'>9:00AM</option>
                                                <option value="9:30 AM"';echo($meal["b"]=='9:30 AM'? 'selected="selected"' : '');echo'>9.30AM</option>
                                                <option value="10:00 AM"';echo($meal["b"]=='10:00 AM'? 'selected="selected"' : '');echo'>10:00AM</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>

                                <div class="row row-margin">
                                    <div class="col-lg-5 col-lg-offset-1 col-md-12 padd">
                                        <label class="control-label">Lunch Timing</label>
                                    </div>
                                    <div class="col-lg-6 col-lg-offset-0 col-md-12">
                                        <select class="form-control" name="lunch">
                                            <optgroup label="This is a group">
                                                <option value="2:00 PM"';echo($meal["l"]=='2:00 PM'? 'selected="selected"' : '');echo'>2:00PM</option>
                                                <option value="2:30 PM"';echo($meal["l"]=='2:30 PM'? 'selected="selected"' : '');echo'>2:30PM</option>
                                                <option value="3:00 PM"';echo($meal["l"]=='3:00 PM'? 'selected="selected"' : '');echo'>3:00PM</option>
                                                <option value="3:30 PM"';echo($meal["l"]=='3:30 PM'? 'selected="selected"' : '');echo'>3:30PM</option>
                                                
                                            </optgroup>
                                        </select>
                                    </div>
                                    
                                </div>

                                <div class="row row-margin">
                                    <div class="col-lg-5 col-lg-offset-1 col-md-12 padd">
                                        <label class="control-label">Dinner Timing</label>
                                    </div>

                                    <div class="col-lg-6 col-lg-offset-0 col-md-12">
                                        <select class="form-control" name="dinner">
                                            <optgroup label="This is a group">
                                                <option value="7:30 PM"';echo($meal["d"]=='7:30 PM'? 'selected="selected"' : '');echo'>7:30PM</option>
                                                <option value="8:00 PM"';echo($meal["d"]=='8:00 PM'? 'selected="selected"' : '');echo'>8:00PM</option>
                                                <option value="8:30 PM"';echo($meal["d"]=='8:30 PM'? 'selected="selected"' : '');echo'>8:30PM</option>
                                                <option value="9:00 PM"';echo($meal["d"]=='9:00 PM'? 'selected="selected"' : '');echo'>9:00PM</option>
                                                
                                            </optgroup>
                                        </select>
                                    </div>
                                 
                                </div>
                                <br>

                                 <div class="text-center">
                             <center><button class="btn btn-warning visible-xs-block  visible-sm-inline visible-md-inline visible-lg-inline" type="submit" value="submit" name="submit_meal">Update Meal Timings</button>
                             &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                              <button class="btn btn-danger visible-xs-block  visible-sm-inline visible-md-inline visible-lg-inline" type="submit" value="reset" name="reset_meal">Reset Meal Timings</button></center>
                              </div>

                                </form>


                                <form id="rooms" method="POST" action="includes/update_property_room.php?id='.$property_id_by_link.'">

                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 class="bg-primary">Rooms</h3></div>
                                </div>

                                <p class="help-block text-center">Provide information of atleast 5 rooms.</p>
                                <div id="product">
                                    
                                ';

                                $count_rooms = count($rooms_available);
                                //echo "$count_rooms";
                                for ($i=0; $i <$count_rooms ; $i++) {   
                                    $room_info = $rooms_available[$i];
                                   foreach ($room_info as $row) {
                                      
                                   

                                 echo'<div class="well" style="clear:both;">
                                    <div class="row">
                                      
                                        <div class="col-lg-5 col-lg-offset-1 col-md-5 col-md-offset-1 col-sm-5 col-sm-offset-1 col-xs-5 margin-s">
                                            <input class="form-control up" type="text" placeholder="Room number" value="'.$row['number'] .'" name="room_no[]">
                                        </div>
                                       <div class="col-lg-5 col-lg-offset-0 col-md-5 col-md-offset-0 col-sm-5 col-sm-offset-0 col-xs-5 ">
                                            <select class="form-control" name="seats[]">
                                                <option value=""Number of seats</option>
                                                <option value="1"';echo($row["seats"]=='1'? 'selected="selected"' : '');echo'>1</option>
                                                <option value="2"';echo($row["seats"]=='2'? 'selected="selected"' : '');echo'>2</option>
                                                <option value="4"';echo($row["seats"]=='4'? 'selected="selected"' : '');echo'>4</option>
                                                <option value="5"';echo($row["seats"]=='5'? 'selected="selected"' : '');echo'>5</option>
                                                <option value="6"';echo($row["seats"]=='6'? 'selected="selected"' : '');echo'>6</option>
                                                <option value="7"';echo($row["seats"]=='7'? 'selected="selected"' : '');echo'>7</option>
                                                <option value="8"';echo($row["seats"]=='8'? 'selected="selected"' : '');echo'>8</option>
                                                
                                            </select>
                                        </div>
                                       
                                    </div>
                                </div>';
                                    }
  
                                }

                               

                                                         
                                                            
                                                         
                                                            
                                echo'
                                <p class="help-block text-center">Add new room and information</p>

                                <div class="list-item well">
                                    <div class="row">
                                       
                                       <div class="col-lg-6 col-lg-offset-0 col-md-6 col-md-offset-0 col-sm-6 col-sm-offset-0 col-xs-12 padd margin-s">
                                            <input class="form-control up" type="text" placeholder="Room number"  name="new_room_no">
                                        </div>
                                       <div class="col-lg-6 col-lg-offset-0 col-md-6 col-md-offset-0 col-sm-6 col-sm-offset-0 col-xs-12 padd">
                                             <select class="form-control" name="new_room_seats">
                                                <option value="" selected="">Number of seats</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                
                                            </select>
                                        </div>
                                       
                                    </div>
                                </div>

                                </div>


                                 <div class="text-center">
                             <center><button class="btn btn-warning visible-xs-block  visible-sm-inline visible-md-inline visible-lg-inline" type="submit" value="submit" name="submit_room">Update Rooms Information</button>
                             &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                              <button class="btn btn-primary visible-xs-block  visible-sm-inline visible-md-inline visible-lg-inline" type="submit" value="submit" name="add_new_room">Add New Room Information</button></center>
                              </div>

                                </form>

                             <form id="rules">

                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 class="bg-warning">House Rules (optional)</h3></div>
                                </div>
                                

                                <p class="help-block text-center"></p>
                               <div id="rule">
                                  '; 
                                  $count = count($rules);
                                for ($i=0; $i <$count ; $i++) { 
                                   
                                echo' <div class="rule-item well">
                                    <div class="row">
                                       
                                        <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1">
                                            <input class="form-control" type="text" placeholder="Describe rule" value="'.$rules[$i] .'">
                                        </div>
                                    </div>
                                </div>';
                             }

                                echo'
                               </div>


                                 <div class="text-center">
                            <center> <button class="btn btn-warning visible-xs-block  visible-sm-inline visible-md-inline visible-lg-inline" type="submit" value="submit" name="submit_rules">Update Rules</button>
                             &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                              <button class="btn btn-danger visible-xs-block  visible-sm-inline visible-md-inline visible-lg-inline" type="submit" value="reset" name="reset_rules">Reset Rules</button></center>
                              </div>

                               </form>

                              


                               <form id="images" enctype="multipart/form-data" method="POST" action="includes/update_property_photos.php?id='.$property_id_by_link.'&property_name='.$property_name.'">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 class="bg-primary">Upload Images</h3></div>
                                </div>

                                <div class="well">
                                    <div class="row">
                                        <div class="col-md-12">
                                             <input type="file" accept="image/*" multiple=""/ name="image_array[]">
                                        </div>
                                    </div>
                                </div>


                                 <div class="text-center">
                             <center><button class="btn btn-warning visible-xs-block  visible-sm-inline visible-md-inline visible-lg-inline" type="submit" value="submit" name="submit_images">Update Images</button>
                             &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                            <button class="btn btn-danger visible-xs-block  visible-sm-inline visible-md-inline visible-lg-inline" type="submit" value="reset" name="reset_images">Reset Images</button></center>
                              </div>
 
                                </form>  ';

                               }
                            }

                }


                ?>


                                <br>
                                <p class="help-block text-center bg-warning">Information display based on the last updation in the database available.</p>
                                </br>
                                </br>  


                                    
                                </div>
                                </div>
                                </div>
                                </div>
                                </div>
                              

                                </div>
                                </div>
                                </div>
                                </div>

                                </section>


    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>





<?php include "includes/footer.php"; ?>


