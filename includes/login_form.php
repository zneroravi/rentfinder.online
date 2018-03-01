<?php include "header_login_register.php";?>
<body>
    <nav class="navbar navbar-default cust_nav">
        <div class="container-fluid" style="width: 100%">
            <div class="navbar-header"><a class="navbar-brand navbar-link" href="../index.php">RentFinder.com </a>
                <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
            </div>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav navbar-right">
                    <li role="presentation"><a href="register_student.php">Register </a></li>
                </ul>
            </div>
        </div>
    </nav>

<script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    
    <div class="login-card"><img src="../assets/img/avatar_2x.png" class="profile-img-card">
        <p class="profile-name-card">User Login</p>

        <form method="post"  class="form-signin"><span class="reauth-email"> </span>
        <?php 
        if (isset($_COOKIE['RF_remember'])) {
          $saved_email =$_COOKIE['RF_email'];
          $saved_pass  =$_COOKIE['RF_password'];
        }
        ?>
            <input class="form-control" type="email" required="" placeholder="Email address" name="email" autofocus="" id="inputEmail" <?php if(isset($saved_email)) echo 'value="'. $saved_email. '"';?>>
            <input class="form-control" type="password" required="" placeholder="Password" name="password" id="inputPassword"<?php if(isset($saved_pass)) echo 'value="'. $saved_pass.'"';?>>
           
            <button class="btn btn-primary btn-block btn-lg btn-signin" type="submit" name="login">Login </button>
            <div class="checkbox">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="remember" <?php if(isset($_COOKIE['RF_remember'])) echo 'checked="checked"';?>>Remember me?</label>
                </div>
            </div>
        </form>
    <h3 class="text-center">Start Exploring Areas. </h3>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>

       </body>

</html>



<?php 

include "mongo_connection.php";

session_start();

if(isset($_POST['login']))  {

  $email = $_POST['email'];
  $password_taken =$_POST['password'];

  $password  =hash('sha512',(md5($password_taken)));
  $mongo_object_student = $student_collection->find( array('email' => "$email" ));
  $mongo_object_landlord = $landlord_collection->find( array('email' => "$email" ));
    $mongo_object_admin = $admin_collection->find( array('email' => "$email" ));
      
       if($mongo_object_student->count(true)) {
          
          foreach ($mongo_object_student as$row) {
            
            $_SESSION['_id']          = $row['_id'];
            $_SESSION['account_type'] = "Tenant";
            $_SESSION['name']         = $row["name"];
            $_SESSION['email']        = $row["email"];
            $_SESSION['password']     = $row["password"];
            $_SESSION['date_created'] = date ('d-m-Y ',$row["date_created"]->sec);
            $_SESSION['university']   = $row["university"];
            $_SESSION['registration'] = $row["registration"];
            $_SESSION['mothers_name'] = $row["mothers_name"];
            $_SESSION['fathers_name'] = $row["fathers_name"];
            $_SESSION['permanent_add']= $row['permanent_add'];
            $_SESSION['display_pic']  = $row['display_pic'];
            $_SESSION['filled']       = $row['filled'];
            $_SESSION['approved']     = $row['approved'];
            $_SESSION['split_user']   = explode(' ', $_SESSION['name']);
                 
      
            }       




                if($password == $_SESSION['password'])  {

                   $userid = $_SESSION['_id'];
                   $email = $_SESSION['email'];
                   $pass  = $password_taken;
                   
                    if (isset($_POST['remember'])) {
                      $rem=1;
                       $expiration = time() + (60*60*24*7);
                       setcookie("RF_email",$email,$expiration);
                       setcookie("RF_password",$pass,$expiration);
                       setcookie("RF_remember",$rem,$expiration);

                    }
                    else{
                       
                       $expiration = time() + (60*60*24*7);
                       setcookie("RF_email","",$expiration);
                       setcookie("RF_password","",$expiration);
                       setcookie("RF_remember","",$expiration);
                    }
                         header("Location:../user_account.php?userid=$userid");
                 }


                else {

                  session_destroy();
                  
                  echo "<p class = 'bg-danger' style=' color:red; text-align:center;'>Wrong Username or Password!</p>";
                 } 





        
              }
      
           else if($mongo_object_landlord->count(true)){
          
           foreach ($mongo_object_landlord as$row) {
            $_SESSION['_id']          = $row['_id'];
            $_SESSION['account_type'] = "Landlord";
            $_SESSION['name']         = $row["name"];
            $_SESSION['email']        = $row["email"];
            $_SESSION['password']     = $row["password"];
            $_SESSION['date_created'] = date ('d-m-Y ',$row["date_created"]->sec);
            $_SESSION['occupation']   = $row["occupation"];
            $_SESSION['permanent_add']= $row["permanent_add"];
            $_SESSION['contact']      = $row["contact"];
            $_SESSION['display_pic']  = $row["display_pic"];
            $_SESSION['filled']       = $row['filled'];
             $_SESSION['approved']     = $row['approved'];
            $_SESSION['split_user']   = explode(' ', $_SESSION['name']);   
            }


                      if($password == $_SESSION['password'])  {

                        $userid = $_SESSION['_id'];
                         $email = $_SESSION['email'];
                        $pass  =  $password_taken;
                   
                    if (isset($_POST['remember'])) {
                      $rem=1;
                       $expiration = time() + (60*60*24*7);
                       setcookie("RF_email",$email,$expiration);
                       setcookie("RF_password",$pass,$expiration);
                       setcookie("RF_remember",$rem,$expiration);

                    }
                     else{
                       
                       $expiration = time() + (60*60*24*7);
                       setcookie("RF_email","",$expiration);
                       setcookie("RF_password","",$expiration);
                       setcookie("RF_remember","",$expiration);
                    }
                     
                         header("Location:../user_account.php?userid=$userid");
                       }


                      else {
                         session_destroy();
                         echo "<p class = 'bg-danger' style=' color:red; text-align:center;'>Wrong Username or Password!</p>";
                       } 
          
      
            } 



             else if($mongo_object_admin->count(true)){
          
           foreach ($mongo_object_admin as$row) {
            $_SESSION['_id']          = $row['_id'];
            $_SESSION['account_type'] = "Admin";
            $_SESSION['name']         = $row["name"];
            $_SESSION['email']        = $row["email"];
            $_SESSION['password']     = $row["password"];
            $_SESSION['split_user']   = explode(' ', $_SESSION['name']);   
            }
                  

                      if($password == $_SESSION['password'])  {

                        $userid = $_SESSION['_id'];
                         $email = $_SESSION['email'];
                   $pass  = $password_taken;
                   
                    if (isset($_POST['remember'])) {
                      $rem=1;
                       $expiration = time() + (60*60*24*7);
                       setcookie("RF_email",$email,$expiration);
                       setcookie("RF_password",$pass,$expiration);
                       setcookie("RF_remember",$rem,$expiration);

                    }
                     else{
                       
                       $expiration = time() + (60*60*24*7);
                       setcookie("RF_email","",$expiration);
                       setcookie("RF_password","",$expiration);
                       setcookie("RF_remember","",$expiration);
                    }
                                   
                         header("Location:../admin/admin.php?userid=$userid");
                       }


                      else {
                        session_destroy();
                         echo "<p class = 'bg-danger' style=' color:red; text-align:center;'>Wrong Username or Password!</p>";
                       } 
          
      
            }  

              else{
              session_destroy();
              echo "<p class = 'bg-danger' style=' color:red; text-align:center;'> User Does Not exists!</p>";
              }
      



    

}

?>