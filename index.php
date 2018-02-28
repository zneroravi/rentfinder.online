<?php include "includes/mongo_connection.php";?>
<?php include "includes/header.php"; ?>
<body>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
     <script type="text/javascript">
        $(document).ready(function() {
        // Transition effect for navbar 
        $(window).scroll(function() {
          // checks if window is scrolled more than 500px, adds/removes solid class
          if($(this).scrollTop() > 50) { 
              $('.navbar').addClass('solid');

          } else {
              $('.navbar').removeClass('solid');


          }
        });
});
    </script>
 <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
<?php include "includes/navbar.php"; ?>

<?php
if (isset($_SESSION['account_type']) && $_SESSION['account_type']=='Admin') {
    $id = $_SESSION['_id'];
    header("location:admin/admin.php?id=$id");
}
?>

    <div class="jumbotron hero">
        <div class="container-fluid" style="margin-top: 170px">
        <br>
        <br>
           <center><img class=" img img-responsive"  style="width:500px;"src="assets/img/RentFinder.png"></center> 
            <p class="text-center t_par"><strong>Explore and find rooms and apartments which suits you the most. Please Login or Register for better experience.</strong></p>
        </div>
        <br>
        <div class="container ctn_cust">
            <form method="GET" action="search.php">
                <div class="input-group">
                    <input class="form-control input-lg" type="text" name="search_room" required="" placeholder="Search" autocomplete="on">
                    <div class="input-group-btn">
                        <button class="btn btn-primary btn-lg btn_s" type="submit" name="search" value="1" style="margin-top:9px; height:46px">Search <i class="glyphicon glyphicon-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
         
         <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-6 col-xs-offset-3">

            <br>
            <ul class="nav nav-pills nav-justified">
                <li class="active"><a href="#au1"  style=""id="about_us">About Us</a></li>
                <li class="active"><a href="#hw2"  style=""id="how_work">How we work</a></li>
                <li class="active"><a href="#rcc3" style=""id="rc3">Recent Properties</a></li>
            </ul>
        </div>

        </div>
       
     
       
    </div>
     </div> <div id="au1"><br><br></div>
       <div class="container">
        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12"><h1 class="text-left">About Us</h1></div></div>
    <div class="container">
        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
            <p class="text-justify">We know what you are facing students, and we know it is frustrating to roam around asking people about houses for rent. We know how much efforts it take to search for a paying guest in a new area. This is why we are here to help. Rentfinder
                is your online companion for the job. Search for paying guest, rooms in your nearest vicinity and save you precious effort and time. Rentfinder provides both a tenant and a landlord a platform where he could collectively see all paying
                guests available and at what rate they are advertising.<br><br> Landlords efforts of advertising for their properties will be reduced if they use Rentfinder as each property you create will be hosted in the website. It was about time that our
                traditional way of looking for rents should get changed.<br><br><strong>-- With Rentfinder, it just did.</strong> &nbsp; </p>
        </div>
        <div class="col-lg-3 col-lg-offset-1 col-md-3 col-md-offset-1 col-sm-3 col-sm-offset-1 hidden-xs hidden-sm">
            <div class="right-align"><img class="img-rounded img-responsive" src="assets/img/rfskyline.jpg"></div>
        </div>
    </div>
<br><br><br><br>
    <div class="container">
    <div class="col-lg-3 col-md-12">
        <div class=" welli well well-lg">
            <h1 class="text-center"> <i class="fa fa-building"></i></h1>
            <h5 class="text-center">Explore properties available online just for you to find out. Your desired room is just one click away.</h5></div>
    </div>
    <div class="col-lg-3 col-md-12">
        <div class="welli well well-lg">
            <h1 class="text-center"> <i class="fa fa-child"></i></h1>
            <h5 class="text-center">Many user are using to find their desired rooms. Join today to be a part of the community to find what you want.</h5></div>
    </div>
    <div class="col-lg-3 col-md-12">
        <div class="welli well well-lg">
            <h1 class="text-center"> <i class="fa fa-user"></i></h1>
            <h5 class="text-center">Several Landlords have registered their properties to we found by people. You want your property to be advertised? its you place.</h5></div>
    </div>
    <div class="col-lg-3 col-md-12">
        <div class="welli well well-lg">
            <h1 class="text-center"> <i class="fa fa-venus-mars"></i></h1>
            <h5 class="text-center">Available rooms for both Boys and Girls. Even joint rooms are available. With every facility you could possibly desire.</h5></div>
    </div>
</div>
 </div> <div id="hw2"><br><br></div>
   <div class="container">
    <br>
        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12"><h1 class="text-left">How We Work</h1></div>
        <div class="col-md-12">
            <p class="text-justify">The working of the website is based on interaction between Tenant and a Landlord. Rentfinder provides you with accounts when you register to become a member of the website. The account will allow you to Book any paying guest property of your
                desire or just take an appointment with the landlord, get to know him, see the property yourself.<br><br> Landlord on other hand will easily be able ot create a page about his property. This will enable him to advertise his property online in
                our website. Also landlord will be able to manage the whole property and the tenants from the interface. </p>
        </div>
    </div>
     <br>
      </div> <div id="rcc3"><br><br></div>
    <div class="container ctn">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><h1 class="text-left">Recent Properties</h1></div>
        <div>

       
            <?php
              $query_recent_properties = $property_collection->find()->sort(array('date_created'=> -1))->limit(4);
             if ($query_recent_properties->count(true)) {
                 foreach ($query_recent_properties as $row) {
                     $property_name = $row['property_name'];
                     $property_address = $row['property_address'];
                     $property_owner   = $row['owner'];
                     $date_created       = date('d-m-Y', $row['date_created']->sec);
                     $year = date('Y',$row['date_created']->sec);
                     $current_year = date('Y');
                     $years_active = $current_year - $year;
                     if($years_active ==0){
                        $years_active ="New";
                     }
                     $pictures =$row['pictures'];

                     if (count($pictures)>1) {
                          echo'<div class="col-lg-3 col-md-3 col-sm-3">
                      <div class="thumbnail"><img src=\'assets/img/'.$property_name.'/'.$property_name.$pictures[0].'\' >
                        <div class="caption">
                             <h3>'. $property_name .'</h3>
                <p><strong>Address:</strong> '.$property_address.' <br><strong>Property Owner:</strong>'. $property_owner.' </br> <strong>Years Active: '. $years_active.'</strong></p>
                            </div>
                             </div>
                         </div>
                 ';
                     }
                     else{
                            echo'<div class="col-lg-3 col-md-3 col-sm-3">
                      <div class="thumbnail"><img class="img img-responsive img-rounded" src="assets/img/VISION_PLAN.png"  />
                        <div class="caption">
                             <h3>'. $property_name .'</h3>
                <p><strong>Address:</strong> '.$property_address.' <br><strong>Property Owner:</strong>'. $property_owner.' </br> <strong>Years Active: '. $years_active.'</strong></p>
                            </div>
                             </div>
                         </div>
                 ';
                     }
                 
                 }
             }
            ?>
                
</div>
</div>
        <?php include "includes/footer.php"; ?>