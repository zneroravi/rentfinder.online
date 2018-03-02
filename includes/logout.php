<?php
 session_start();
if( $_SESSION['account_type']=='Tenant')	{

  	  $_SESSION['account_type'] = null;
      $_SESSION['name']     	= null;
      $_SESSION['email']        = null;
      $_SESSION['password']     = null;
      $_SESSION['date_created'] = null;
      $_SESSION['registration'] =null;   




}
else if ($_SESSION['account_type']=='Landlord') {
	 $_SESSION['account_type'] 	= null;
      $_SESSION['name']         = null;
      $_SESSION['email']        = null;
      $_SESSION['password']     = null;
      $_SESSION['date_created'] = null;
      $_SESSION['occupation']   = null;
      $_SESSION['permanent_add']= null;
      $_SESSION['contact']      = null;
}
else if ($_SESSION['account_type']=='Admin') {
       $_SESSION['account_type']    = null;
      $_SESSION['name']         = null;
      $_SESSION['email']        = null;
      $_SESSION['password']     = null;
      $_SESSION['date_created'] = null;
      $_SESSION['occupation']   = null;
      $_SESSION['permanent_add']= null;
      $_SESSION['contact']      = null;
}
header("Location: ../index.php");



?>