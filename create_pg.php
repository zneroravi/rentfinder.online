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



 <?php
if (isset($_POST['submit_form'])) {
    
    $property_address=$_POST["property_address"];
    $property_name   =$_POST["property_name"];
    $accom_type      =$_POST["accom_type"];
    $owner_name      =$_POST["owner_name"];
    $starting_price  =$_POST["starting_price"];
   
   if(isset($_POST["bath"]))    {
    $bath ="1";
   } 
   else{
    $bath ="2";
   }
  if(isset($_POST["air_con"]))    {
    $air_con ="1";
   }
   else{
    $air_con ="2";
   }
   if(isset($_POST["television"]))    {
    $television ="1";
   }
   else{
    $television ="2";
   }
   if(isset($_POST["bed"]))    {
    $bed ="1";
   }
   else{
    $bed ="2";
   }
   if(isset($_POST["tnc"]))    {
    $tnc ="1";
   }
   else{
    $tnc ="2";
   }
   if(isset($_POST["wifi"]))    {
    $wifi ="1";
   }
   else{
    $wifi ="2";
   }
   
    

///////basic facilities done/////////////////////////
   $faci = $_POST['faci_name'];
   if (empty($_POST['breakfast']) || empty($_POST['lunch']) || empty($_POST['dinner'])) {
       $meal=0;
       //mongo query
   }
   else{
    
    $breakfast = $_POST['breakfast'];
    $lunch     = $_POST['lunch'];
    $dinner    = $_POST['dinner'];
    //mongo query
    $meal = array("b"=> $breakfast,"l"=>$lunch, "d"=> $dinner);
   }
   $room_no=$_POST['room_no'];
   $seats =$_POST['seats'];

   $number = count($room_no);
   
   
   for ($i=0; $i <$number ; $i++) { 

       $rooms_input [$i]= array(array("number" => $room_no[$i] , "seats"=>$seats[$i]));

   }
   


   if (empty($_POST['rule'])) {
       $rule =0;

   }
   else{
    $rule = $_POST['rule'];
   }


   if (isset($_FILES['images_array'])) {
       
         mkdir("assets/img/$property_name");
         chmod("assets/img/$property_name", 0777);
     $property_image      = $_FILES['images_array']['name'];
     $property_image_temp = $_FILES['images_array']['tmp_name'];

     
     for($i=0; $i<count($property_image_temp); $i++){

      move_uploaded_file($property_image_temp[$i], "assets/img/$property_name/"."$property_name".$property_image[$i] );

     }

   }


///////////////query time////////////////////
   $property_document = array(
    "property_name" => "$property_name",
    "property_address" => "$property_address",
    "accom_type"      => "$accom_type",
    "owner"          => "$owner_name",
    "owner_id"       => new MongoId($_SESSION["_id"]),
    "date_created"   => new MongoDate(),
    "starting_price" =>"$starting_price",
    "rooms_available" =>$rooms_input,
    "room_types"  =>"",
    "room_prices" =>"",
    "description" =>array("attached_bath" => "$bath" , "tv" =>"$television", "ac" =>"$air_con" , "bedding" => "$bed" ,"tnc"=>"$tnc", "wifi" => "$wifi"),
    "facilities" => $faci,
    "meal"       => $meal,
    "pictures" =>$property_image,
    "rules" => $rule,
    "approved"=> "0"

    );

if($property_collection->find(array("property_name" => "$property_name"))->count(true))  {
     echo "<p class = 'bg-danger text-center' style=' color:red; te'>Property already exists already with the name given. </p>";
     header("refresh: 5");
}
else{
    if($property_collection->insert($property_document))  {
    $user_id = $_SESSION['_id'];
     echo "<p class = 'bg-success' style=' color:green;'> Property Created. <a href='list_property.php?user_id=$user_id'>View Property</a> </p>";
  }
}
 
  

  

}
?>






                
                <div class="panel-body">

                    <div class="alert alert-warning ">
                        <h4 class="text-center text-warning">Important Notice</h4>
                        <p class="text-center text-muted">Please provide valid information. Any information which found faulty later might lead to case of fraudency which may lead to permanent blocking of your account. </p>
                    </div>

                    <div class="col-lg-8 col-lg-offset-2 col-md-12">

                        <form id="frmProduct" method="post" enctype="multipart/form-data">

                            <div class="form-group">


                                <input class="form-control padd-input" type="text"  name="property_name" required="" placeholder="Property name" autocomplete="on"/>
                                <input class="form-control padd-input" type="text" name="property_address" required="" placeholder="Property address" autocomplete="on" pattern=".+Punjab" />
                                <input class="form-control padd-input" type="text" required="" name="owner_name" placeholder="Owner name" autocomplete="on" value="<?php echo $_SESSION['name'];?>" readonly/>

                                <input class="form-control padd-input" type="text" required="" name="starting_price" placeholder="Default starting price" autocomplete="on"  maxlength="6" pattern="\d*" />
                                <div class="row text-center">
                                    <div class="col-lg-6 col-lg-offset-1 col-md-12 pad-accom">
                                        <label class="control-label"> Accomodation Specific to:</label>
                                    </div>
                                    <div class="col-lg-4 col-md-12">
                                        <div class="form-group">

                                        <select class="form-control" required="" name="accom_type">
                                            <optgroup label="Select Gender">
                                                <option value="m" selected="">Boy</option>
                                                <option value="f">Girl</option>
                                                <option value="b" selected="">Both</option>
                                            </optgroup>
                                        </select>

                                    </div>
                                </div>
                            </div>
                           <!--form and are in the bottom -->
                        
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
                        
                        
                        <div class="form-group">
                        
                               <div class="row">
                                    <div class="col-md-12">
                                        <h3 class="bg-primary">Basic Facilities</h3>
                                    </div>
                                    <div class="col-lg-3 col-md-12">
                                        <div class="checkbox">
                                            <label class="control-label">
                                                <input type="checkbox" name="bath"/><strong> Attached Bathroom</strong></label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-12">
                                        <div class="checkbox">
                                            <label class="control-label">
                                                <input type="checkbox" name="air_con"/><strong> Air Conditioner</strong></label>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-12">
                                        <div class="checkbox">
                                            <label class="control-label">
                                                <input type="checkbox" name="television"/><strong> TV</strong></label>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-12">
                                        <div class="checkbox">
                                            <label class="control-label">
                                                <input type="checkbox" name="bed"/><strong> Bedding</strong></label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-lg-offset-3 col-md-12">
                                        <div class="checkbox">
                                            <label class="control-label">
                                                <input type="checkbox" name="tnc"/><strong> Table / Chair</strong></label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-12">
                                        <div class="checkbox">
                                            <label class="control-label">
                                                <input type="checkbox" name="wifi"/><strong> Wifi</strong></label>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 class="bg-primary">Facilities described</h3>
                                        </div>
                                </div>

                                    <p class="help-block text-center">Describe atleast 5 facilities.</p>
                               <div id="fac">
                                   
                                <div class="facility-item well" style="clear:both;">
                                    <div class="row">
                                        
                                        <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-12 col-xs-12">
                                            <input class="form-control" type="text" placeholder="Describe facility" name="faci_name[]"  />
                                        </div>
                                    </div>

                                </div>

                                <div class="facility-item well" style="clear:both;">
                                    <div class="row">
                                       
                                        <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-12 col-xs-12">
                                            <input class="form-control" type="text" placeholder="Describe facility" name="faci_name[]"  />
                                        </div>
                                    </div>

                                </div>
                                <div class="facility-item well" style="clear:both;">
                                    <div class="row">
                                        
                                        <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-12 col-xs-12">
                                            <input class="form-control" type="text" placeholder="Describe facility" name="faci_name[]"  />
                                        </div>
                                    </div>

                                </div>
                                <div class="facility-item well" style="clear:both;">
                                    <div class="row">
                                        
                                        <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-12 col-xs-12">
                                            <input class="form-control" type="text" placeholder="Describe facility" name="faci_name[]"  />
                                        </div>
                                    </div>

                                </div>
                                <div class="facility-item well" style="clear:both;">
                                    <div class="row">
                                        
                                        <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-12 col-xs-12">
                                            <input class="form-control" type="text" placeholder="Describe facility" name="faci_name[]"  />
                                        </div>
                                    </div>

                                </div>

                               </div>

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
                                                <option value="7:00 AM" selected="">7:00AM</option>
                                                <option value="7:30 AM">7:30AM</option>
                                                <option value="8:00 AM">8:00AM</option>
                                                <option value="8:30 AM">8:30AM</option>
                                                <option value="9:00 AM">9:00AM</option>
                                                <option value="9:30 AM">9.30AM</option>
                                                <option value="10:00 AM">10:00AM</option>
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
                                                <option value="2:00 PM" selected="">2:00PM</option>
                                                <option value="2:30 PM">2:30PM</option>
                                                <option value="3:00 PM">3:00PM</option>
                                                <option value="3:30 PM">3:30PM</option>
                                                
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
                                                <option value="7:30 PM" selected="">7:30PM</option>
                                                <option value="8:00 PM">8:00PM</option>
                                                <option value="8:30 PM">8:30PM</option>
                                                <option value="9:00 PM">9:00PM</option>
                                                
                                            </optgroup>
                                        </select>
                                    </div>
                                 
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 class="bg-primary">Rooms</h3></div>
                                </div>

                                <p class="help-block text-center">Provide information of atleast 5 rooms.</p>
                                <div id="product">
                                    

                                <div class="list-item well">
                                    <div class="row">
                                      
                                        <div class="col-lg-6 col-lg-offset-0 col-md-6 col-md-offset-0 col-sm-6 col-sm-offset-0 col-xs-12 padd margin-s">
                                            <input class="form-control up" type="text" placeholder="Room number"  name="room_no[]">
                                        </div>
                                       <div class="col-lg-6 col-lg-offset-0 col-md-6 col-md-offset-0 col-sm-6 col-sm-offset-0 col-xs-12 padd">
                                            <select class="form-control" name="seats[]">
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


                                                            <div class="list-item well">
                                    <div class="row">
                                        
        <div class="col-lg-6 col-lg-offset-0 col-md-6 col-md-offset-0 col-sm-6 col-sm-offset-0 col-xs-12 padd margin-s">                                       <input class="form-control up" type="text" placeholder="Room number"  name="room_no[]">
                                        </div>
                                        <div class="col-lg-6 col-lg-offset-0 col-md-6 col-md-offset-0 col-sm-6 col-sm-offset-0 col-xs-12 padd">
                                             <select class="form-control" name="seats[]">
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

                                                            <div class="list-item well">
                                    <div class="row">
                                       
                                        <div class="col-lg-6 col-lg-offset-0 col-md-6 col-md-offset-0 col-sm-6 col-sm-offset-0 col-xs-12 padd margin-s">
                                            <input class="form-control up" type="text" placeholder="Room number"  name="room_no[]">
                                        </div>
                                        <div class="col-lg-6 col-lg-offset-0 col-md-6 col-md-offset-0 col-sm-6 col-sm-offset-0 col-xs-12 padd">
                                             <select class="form-control" name="seats[]">
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

                                                            <div class="list-item well">
                                    <div class="row">
                                        
                                       <div class="col-lg-6 col-lg-offset-0 col-md-6 col-md-offset-0 col-sm-6 col-sm-offset-0 col-xs-12 padd margin-s">
                                            <input class="form-control up" type="text" placeholder="Room number"  name="room_no[]">
                                        </div>
                                       <div class="col-lg-6 col-lg-offset-0 col-md-6 col-md-offset-0 col-sm-6 col-sm-offset-0 col-xs-12 padd">
                                              <select class="form-control" name="seats[]">
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

                                <div class="list-item well">
                                    <div class="row">
                                       
                                       <div class="col-lg-6 col-lg-offset-0 col-md-6 col-md-offset-0 col-sm-6 col-sm-offset-0 col-xs-12 padd margin-s">
                                            <input class="form-control up" type="text" placeholder="Room number"  name="room_no[]">
                                        </div>
                                       <div class="col-lg-6 col-lg-offset-0 col-md-6 col-md-offset-0 col-sm-6 col-sm-offset-0 col-xs-12 padd">
                                             <select class="form-control" name="seats[]">
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
                             

                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 class="bg-warning">House Rules (optional)</h3></div>
                                </div>


                                <p class="help-block text-center">Mention atleast 3 rules, if any.</p>
                               <div id="rule">
                                   

                                                                <div class="rule-item well">
                                    <div class="row">
                                       
                                        <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1">
                                            <input class="form-control" type="text" placeholder="Describe rule">
                                        </div>
                                    </div>
                                </div>
                                                                <div class="rule-item well">
                                    <div class="row">
                                        
                                        <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1">
                                            <input class="form-control" type="text" placeholder="Describe rule" name="rule[]">
                                        </div>
                                    </div>
                                </div>
                                                                <div class="rule-item well">
                                    <div class="row">
                                        
                                        <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1">
                                            <input class="form-control" type="text" placeholder="Describe rule" name=" rule[]">
                                        </div>
                                    </div>
                                </div>


                               </div>

                              



                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 class="bg-primary">Upload Images</h3></div>
                                </div>

                                <div class="well">
                                    <div class="row">
                                        <div class="col-md-12">
                                             <input type="file" name="images_array[]" multiple=""/>
                                        </div>
                                    </div>
                                </div> 


                                <p class="help-block text-center bg-warning">By clickiing the<strong> Create Property </strong>button you accept the terms and conditions for authenticity of your property. Any information irrelevent to the entered following will account you as responsible.</p>
                                </br>
                                </br>  


                                    <div class="row">

                                    <div class="col-lg-3 col-lg-offset-3 col-md-3 col-md-offset-3 col-sm-3 col-sm-offset-3 col-xs-6 col-xs-offset-0 text-center">

                                        <button class="btn btn-primary" type="submit" value="submit" name="submit_form">Create Property</button>

                                    </div>

                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 text-center">
                                        <a href="user_account.php?userid=<?php echo $_SESSION['_id'];?>" class="btn btn-danger" type="reset">Cancel Property</a>
                                    </div>

                                    </div>

                                </br>
                                </br>

                                </div>
                                </div>
                                </div>
                                </div>
                                </div>
                                </form>

                                </div>
                                </div>
                                </div>
                                </div>

                                </section>


    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>

<?php include "includes/footer.php"; ?>
