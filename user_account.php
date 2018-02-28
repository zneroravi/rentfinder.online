<?php include "includes/mongo_connection.php";?>
<?php include "includes/header.php"; ?>

<?php 


  session_start();  




if(isset($_SESSION['account_type'])){
	
$type = $_SESSION['account_type'];
 
 if ($type =="Tenant") {

	 $user           =$_SESSION['name'];
     $email          =$_SESSION['email'];
     $password       =$_SESSION['password'];
     $date           =$_SESSION['date_created'] ;
     $university     =$_SESSION['university'];
     $registration   =$_SESSION['registration'];
     $mothers_name   =$_SESSION['mothers_name'];
     $fathers_name   =$_SESSION['fathers_name'];
     $display_pic    =$_SESSION['display_pic'];
     $filled         =$_SESSION['filled']; 
     $split_user     =$_SESSION['split_user'];
     $account_status =$_SESSION['approved'];


       
 	
 }
  
 else if ($type =="Landlord") {

	 $user             		  = $_SESSION['name'];
     $email            		  = $_SESSION['email'];
     $password         		  = $_SESSION['password'];
     $date             		  = $_SESSION['date_created'] ;
     $occupation       		  = $_SESSION['occupation'];
     $permanent_add 		  = $_SESSION['permanent_add'];
     $contact 				  = $_SESSION['contact'];
     $display_pic             = $_SESSION['display_pic'];
     $filled                  = $_SESSION['filled'];
     $split_user              = $_SESSION['split_user'];
     $account_status          =$_SESSION['approved'];
      
 }
 else{
     header("location:/Rentfinder/includes/error.php?not=1");
 }



	} 
	else{
		header("location:includes/error.php");
	}

	?>

	<body>
<?php include "includes/user_navigation.php";?>


<?php 
if ($account_status=="0") {
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


    <div class="container jumb_cust">
        <section>
            <div class="row re">
                <div class="col-lg-6 col-md-12">
                    <h1 class="cust_name"><?php echo"$user";?></h1></div>
                <div class="col-lg-6 col-md-12">
                    <h3 class="text-right cust_day"> <span class="span_1"><?php echo date("l")?> </span><span class="span_1"><?php echo date("d-m-Y");?></span></h3></div>
            </div>
            <div class="row re r_row">
                <div class="col-md-12">
                    <div class="jumbotron cust_jumbo" style="height: 250px">
                        <div class="col-lg-2 col-md-12 cust_col"><img class="img-thumbnail img_cust" src='assets/img/user/<?php echo "$user" . "$display_pic";?>' onerror="this.src='assets/img/avatar_2x.png'" style="width: 200px"></div>

                        <p class="cust_type"><span class="span_1"><strong>Account type: </strong><?php echo"$type";?></span><span class="span_2"><strong>Date of Joining: </strong><?php echo"$date";?></span><span class="span_2">

                        <?php
                        if($type =='Landlord'){
                        	 echo'<strong>Occupation: </strong>' . $occupation . '</span> </p>';
                        	 echo'<p class="cust_type"><span class="span_1"><strong>Permanent Address:</strong>'.$permanent_add .'</span><span class="span_2"><strong>Contact Number: </strong>'. $contact .'</span> </p>';
                        }
                       
                    	else{

                		echo'<strong>University: </strong>'. $university .'</span> </p>';
                		 echo'<p class="cust_type"><span class="span_1"><strong>Registration Number:</strong>'.$registration .'</span><span class="span_2"><strong>Father\'s Name:</strong>'. $fathers_name .' </span><span class="span_2"><strong>Mother\'s Name: </strong>'. $mothers_name .'</span> </p>';

                    	}

                        ?>
                        
                    </div>
                </div>
            </div>
        </section>


<?php

	if($filled=='0'){

	 echo' <section>';
       echo'     <div class="col-md-12">';
        echo'<div class="alert alert-warning" role="alert"><span>You Haven\'t Filled up your details. Please fill up the rest of the fields for better user Experience.</span><span class="span_3"> <a class="alert-link" href="user_form.php">Fill Personal Details</a></span></div>';
            echo '</div>';
        echo'</section>';

}

      
?>


<?php
if($type=='Tenant'){
   
    echo'        
        <br>
        <div class="container ctn_cust">
            <form method="GET" action="search.php">
                <div class="input-group">
                    <input class="form-control input-lg" type="text" name="search_room" required="" placeholder="Search" autocomplete="on">
                    <div class="input-group-btn">
                        <button class="btn btn-primary btn-lg btn_s" type="submit" name="search_native" style="margin-top:9px; height:46px">Search <i class="glyphicon glyphicon-search" ></i></button>
                    </div>
                </div>
            </form>
        </div>
        ';


       
}

?>




		<?php 

		if($type=='Tenant')	
		{
            $query_find_schedule = $scheduled_collection->find(array("tenant_id"=>$_SESSION['_id']));
            if($query_find_schedule->count(true)){}
                else{
                    echo '<div class="col-md-12"> <h3 class="text-center">You haven\'t booked or scdeduled any appointments yet, Start searching Now!</h3></div>';
                }

                 if($query_find_schedule->count(true)){
                     echo' <div class="col-md-12"> <h3 class="text-center">Appointments Scheduled</h3></div>
        <div class="col-md-12">
            <div class="table-responsive tab_cust">
                <table class="table text-center" >
                    <thead class="cust_tab_header">
                        <tr >
                            <th style="text-align:center">Landlord</th>
                            <th style="text-align:center">Timing</th>
                            <th style="text-align:center">Date</th>
                            <th style="text-align:center">Address</th>
                            <th style="text-align:center">Contact</th>
                            <th style="text-align:center"></th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        ';

                    foreach ($query_find_schedule as $row) {
                        $appoint_id  = $row['_id'];
                        $property_id = $row['property_id'];
                        $landlord_id = $row['landlord_id'];
                        $timing      = $row['timing'];
                        $date        =date('d-m-y',$row["date"]->sec);
                        $address_query = $property_collection->find(array("_id"=>$property_id));
                        $landlord_query = $landlord_collection->find(array("_id"=>$landlord_id));

                        foreach ($address_query as $key) {
                            $address = $key['property_address'];
                           
                        }

                        foreach ($landlord_query as $key) {
                            $contact = $key['contact'];
                            $landlord_name = $key['name'];
                        }
                        echo'
                            <tr>
                            <td>'.$landlord_name.'</td>
                            <td>'.$timing.'</td>
                            <td>'.$date.'</td>
                            <td>'. $address. '</td>
                            <td>'. $contact. '</td>
                            <td><a class="btn btn-danger" href="includes/cancel_appointment.php?app_id='. $appoint_id .'">Cancel</a></td>
                        </tr>
                       
                    ';
                    }
                    echo '</tbody>
                </table>
            </div>
        </div>';


               

            

                 }

		
		}


		else if($type=='Landlord')	
		{ 
             $property_search_query = $property_collection->find(array('owner_id' =>$_SESSION['_id']));
            if($property_search_query->count(true)) {}
            else{
                 echo '<div class="col-md-12"> <h3 class="text-center">You haven\'t uploaded any property, Start you services now! </h3></div>';
            }
          

				echo'
                <div class="container-fluid text-center"><a href="create_pg.php?user_id='. $_SESSION['_id']. '&name='.$_SESSION['name'] .'" class="btn btn-success">Create Property</a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                                        <a href="list_property.php?user_id='.$_SESSION['_id'] .'" class="btn btn-primary">List All Properties</a>
                </div>
                <br>';

        
                  if($property_search_query->count(true)) {

                        echo'<div class="col-md-12">
            <div class="table-responsive tab_cust text-center">
                <table class="table">
                    <thead class="cust_tab_header">
                        <tr>
                            <th style="text-align:center">Property Name</th>
                            <th style="text-align:center">Date Created</th>
                            <th style="text-align:center">Property Address</th>
                        
                        
                        </tr>
                    </thead>
                    <tbody>';
                        
                         foreach ($property_search_query as $row) {
                        $property_name = $row["property_name"];
                        $date_created  = date('d-m-y',$row["date_created"]->sec);
                        $property_address = $row["property_address"];
                        echo"<tr>
                            <td>$property_name</td>
                            <td>$date_created</td>
                            <td>$property_address</td>
                          
                        </tr>
                        ";
                    }

                    }

                   
                        

                        echo'
                    </tbody>
                </table>
            </div>
        </div>';

		}

		?>
        
    </div>
   <?php include "includes/footer.php"; ?>