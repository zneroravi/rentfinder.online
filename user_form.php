<?php include"includes/mongo_connection.php"; ?>
<?php include "includes/header.php"; ?>

<?php

session_start(1);


if(isset($_SESSION['account_type']) && isset($_SESSION['_id'])){
    
$type = $_SESSION['account_type'];

 
 if ($type == 'Tenant') {

     $id           = new MongoId($_SESSION['_id']);
     $split_user   =$_SESSION['split_user'];


     $mongo_object_student = $student_collection->find( array('_id' => $id ));
     
     if($mongo_object_student->count(true)) {
            
          foreach ($mongo_object_student as$row) {

            $user         =$row['name'];
            $email        =$row['email'];
            $password     =$row['password'];
            $date         =$row['date_created'] ;
            $university   =$row['university'];
            $registration =$row['registration'];
            $mothers_name =$row['mothers_name'];
            $fathers_name =$row['fathers_name'];
            $permanent_add=$row['permanent_add'];
            $display_pic  =$row['display_pic'];
            $filled       =$row['filled']; 

          }
      }


       
    
 }
  
 if ($type == 'Landlord') {

     $id = new MongoId($_SESSION['_id']);
     $split_user   =$_SESSION['split_user'];


     $mongo_object_landlord = $landlord_collection->find( array('_id' => $id ));
      
         if($mongo_object_landlord->count(true)) {
            
          foreach ($mongo_object_landlord as$row) {
              $user                    = $row['name'];
              $email                   = $row['email'];
              $password                = $row['password'];
              $date                    = $row['date_created'] ;
              $occupation              = $row['occupation'];
              $permanent_add           = $row['permanent_add'];
              $contact                 = $row['contact'];
              $display_pic             = $row['display_pic'];
              $filled                  = $row['filled'];
            }
            
        }

     }
}

    else{




    header("location:/Rentfinder/includes/error.php");


    }

   

?>
  
<?php include "includes/user_navigation.php";?>

<body >
    <section>
        <div class="container user_form">
            <div class="col-lg-10 col-lg-offset-1 col-md-12">
                <form class="bootstrap-form-with-validation" method="post" action="includes/update_user_information.php" enctype="multipart/form-data">
                    <h1 class="text-center">User Profile Information</h1>
                        <?php
                        if(isset($_GET['updated'])) {

                            echo "<p class='bg-success'>Profile Information Updated</p>";
                        }

                        ?>
                        <br><br>
                        <center><div class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-5 col-md-offset-5 col-sm-offset-5 col-xs-offset-0"><img class="img-thumbnail img_cust" src='assets/img/user/<?php echo "$user" . "$display_pic";?>' onerror="this.src='assets/img/avatar_2x.png'" style="width: 100px; overflow:hidden;"></div></center>
                        
<br><br><br><br><br><br><br><br><br>

                    <div class="form-group" >
                        <label class="control-label" for="text-input">Full Name</label>
                        <input class="form-control input-lg" type="text" name="full_name" required="" id="full_name" value='<?php echo "$user";?>'>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="email-input">Email Input</label>
                        <input class="form-control input-lg" type="email" name="email" required="" id="email" value='<?php echo "$email";?>'>
                    </div>
                    <?php
                    if($type=='Tenant') {
                        
                        echo '<div class="form-group">
                        <label class="control-label" for="text-input">University </label>
                        <input class="form-control input-lg" type="text" name="university" required="" id="university" value= "'.$university.'">
                        </div>';

                        echo '<div class="form-group">
                        <label class="control-label" for="text-input">Registration Number</label>
                        <input class="form-control input-lg" type="text" name="registration" required="" id="registration" value= "'.$registration.'">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="text-input">Mother\'s Name</label>
                        <input class="form-control input-lg" type="text" name="mothers_name" required="" id="mothers_name" value= "'.$mothers_name.'">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="text-input">Father\'s Name</label>
                        <input class="form-control input-lg" type="text" name="fathers_name" required="" id="fathers_name" value= "'.$fathers_name.'">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="text-input">Permanent Address</label>
                        <input class="form-control input-lg" type="text" name="permanent_add" required="" id="permanent_add" value= "'.$permanent_add.' ">
                    </div>';
                   }

                   if($type=='Landlord'){

                      echo '<div class="form-group">';
                      echo'<label class="control-label" for="text-input">Occupation</label>';
                      echo'<input class="form-control input-lg" type="text" name="occupation" required="" id="occupation" value= "'.$occupation.'" >';
                    echo '</div>';

                   
                     echo'<div class="form-group">
                        <label class="control-label" for="textarea-input">Contact</label>
                        <input class="form-control input-lg" type="text" name="contact" required="" id="contact" value= "'.$contact.'" >';
                    echo '</div>';

                     echo'<div class="form-group">
                        <label class="control-label" for="textarea-input">Permanent Address</label>
                        <input class="form-control input-lg" type="text" name="permanent_add" required="" id="permanent_add" value= "' .$permanent_add.'" >';
                    echo '</div>';

                   }

                    ?>
                    
                    <div class="form-group">
                        <label class="control-label" for="password-input">Password</label>
                        <input class="form-control input-lg" type="password" name="password" required="" id="password" value='<?php echo"$password"?>'>
                    </div>
                   
                    <div class="form-group">
                        <label class="control-label" for="file-input">Display Pic</label>
                        <input type="file" name="dp" value='<?php echo"$display_pic"?>'>
                    </div>
                    <div class="form-group submit_grp">
                        <button class="btn btn-info btn-lg btn_submit" type="submit" name="update">Update Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </section>



<?php include "includes/footer.php"; ?>

  